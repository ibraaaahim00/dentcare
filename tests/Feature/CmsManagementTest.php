<?php

use App\Enums\UserRole;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\HeroBanner;
use App\Models\User;
use App\Models\WorkingHour;
use App\Services\AppointmentService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create([
        'role' => UserRole::Admin,
    ]);
});

test('admin can create and toggle hero banners which render on homepage', function () {
    $response = $this->actingAs($this->admin)->post(route('admin.hero-banners.store'), [
        'title_ar' => 'بانر تجريبي مميز',
        'title_en' => 'Special Test Banner',
        'description_ar' => 'وصف بانر تجريبي للتأكد من الديناميكية',
        'description_en' => 'Dynamic banner test description',
        'button_text_ar' => 'احجز استشارة',
        'button_text_en' => 'Book Consult',
        'button_url' => '/appointments/special',
        'sort_order' => 1,
        'is_active' => 1,
    ]);

    $response->assertRedirect(route('admin.hero-banners.index'));

    $this->assertDatabaseHas('hero_banners', [
        'title_en' => 'Special Test Banner',
        'is_active' => true,
    ]);

    // Verify it renders on the public homepage
    $homeResponse = $this->get(route('home'));
    $homeResponse->assertStatus(200);
    $homeResponse->assertSee('Special Test Banner');
    $homeResponse->assertSee('/appointments/special');

    // Toggle banner to disabled
    $banner = HeroBanner::where('title_en', 'Special Test Banner')->first();
    $this->actingAs($this->admin)->patch(route('admin.hero-banners.toggle', $banner->id));

    expect($banner->fresh()->is_active)->toBeFalse();

    // Verify it is hidden when disabled
    $homeResponseAfterToggle = $this->get(route('home'));
    $homeResponseAfterToggle->assertDontSee('Special Test Banner');
});

test('admin can update about section and it updates frontend', function () {
    $response = $this->actingAs($this->admin)->post(route('admin.about-section.update'), [
        'title_ar' => 'قصة مركزنا المتطور',
        'title_en' => 'The Story of Our Advanced Center',
        'description_ar' => 'نحن نقدم أرقى مستويات الرعاية السنية العالمية.',
        'description_en' => 'We offer world-class comprehensive dental excellence.',
        'experience_years' => 20,
        'experience_text_ar' => 'عاماً من الإبداع',
        'experience_text_en' => 'Years of Innovation',
        'is_active' => 1,
    ]);

    $response->assertRedirect(route('admin.about-section.edit'));

    $this->assertDatabaseHas('about_sections', [
        'title_en' => 'The Story of Our Advanced Center',
        'experience_years' => 20,
    ]);

    // Check homepage and about page
    $homeResponse = $this->get(route('home'));
    $homeResponse->assertStatus(200);
    $homeResponse->assertSee('The Story of Our Advanced Center');

    $aboutResponse = $this->get(route('about'));
    $aboutResponse->assertStatus(200);
    $aboutResponse->assertSee('The Story of Our Advanced Center');
});

test('admin can manage statistics dynamically', function () {
    $response = $this->actingAs($this->admin)->post(route('admin.statistics.store'), [
        'title_ar' => 'ابتسامة مشرقة منجزة',
        'title_en' => 'Smiles Restored',
        'value' => '9,999+',
        'icon' => 'sparkles',
        'sort_order' => 1,
        'is_active' => 1,
    ]);

    $response->assertRedirect(route('admin.statistics.index'));

    $this->assertDatabaseHas('statistics', [
        'value' => '9,999+',
        'title_en' => 'Smiles Restored',
    ]);

    $homeResponse = $this->get(route('home'));
    $homeResponse->assertStatus(200);
    $homeResponse->assertSee('9,999+');
    $homeResponse->assertSee('Smiles Restored');
});

test('admin can manage features (why choose us) dynamically', function () {
    $response = $this->actingAs($this->admin)->post(route('admin.features.store'), [
        'title_ar' => 'تقنية تعقيم ألمانية',
        'title_en' => 'German Sterilization Tech',
        'description_ar' => 'أعلى مستويات الحماية البيولوجية المعتمدة.',
        'description_en' => 'Certified high-grade biological protection standard.',
        'icon' => 'shield-check',
        'sort_order' => 1,
        'is_active' => 1,
    ]);

    $response->assertRedirect(route('admin.features.index'));

    $this->assertDatabaseHas('features', [
        'title_en' => 'German Sterilization Tech',
    ]);

    $homeResponse = $this->get(route('home'));
    $homeResponse->assertStatus(200);
    $homeResponse->assertSee('German Sterilization Tech');
});

test('admin can manage how it works booking steps dynamically', function () {
    $response = $this->actingAs($this->admin)->post(route('admin.how-it-works.store'), [
        'step_number' => 1,
        'title_ar' => 'خطوة الاختبار السريع',
        'title_en' => 'Instant Digital Triaging',
        'description_ar' => 'تحديد سريع لحالتك الطبية بدقة.',
        'description_en' => 'Rapid digital evaluation before clinical seating.',
        'icon' => 'calendar',
        'sort_order' => 1,
        'is_active' => 1,
    ]);

    $response->assertRedirect(route('admin.how-it-works.index'));

    $this->assertDatabaseHas('how_it_works', [
        'title_en' => 'Instant Digital Triaging',
    ]);

    $homeResponse = $this->get(route('home'));
    $homeResponse->assertStatus(200);
    $homeResponse->assertSee('Instant Digital Triaging');
});

test('admin can update CTA section dynamically', function () {
    $response = $this->actingAs($this->admin)->post(route('admin.cta-section.update'), [
        'badge_ar' => 'عرض خاص محدود',
        'badge_en' => 'Limited Exclusive Offer',
        'title_ar' => 'احصل على فحص شامل مجاني اليوم',
        'title_en' => 'Claim Your Comprehensive Free Checkup Today',
        'description_ar' => 'فريقنا جاهز لاستقبالك في عيادتنا المجهزة بأحدث التقنيات.',
        'description_en' => 'Our specialized team is ready to welcome you.',
        'button_text_ar' => 'احجز فحصك الآن',
        'button_text_en' => 'Claim Free Exam',
        'button_url' => '/appointments/free-checkup',
        'phone' => '+966 50 999 8888',
        'is_active' => 1,
    ]);

    $response->assertRedirect(route('admin.cta-section.edit'));

    $this->assertDatabaseHas('cta_sections', [
        'title_en' => 'Claim Your Comprehensive Free Checkup Today',
    ]);

    $homeResponse = $this->get(route('home'));
    $homeResponse->assertStatus(200);
    $homeResponse->assertSee('Claim Your Comprehensive Free Checkup Today');
    $homeResponse->assertSee('+966 50 999 8888');
});

test('admin clinic settings update topbar and footer dynamically', function () {
    $response = $this->actingAs($this->admin)->post(route('admin.settings.update-clinic'), [
        'clinic_name_ar' => 'مجمع دنت كير الطبي التخصصي',
        'clinic_name_en' => 'DentCare Specialized Polyclinic',
        'email' => 'custom-info@dentcare.test',
        'phone' => '+966 11 999 0000',
        'address_ar' => 'الرياض، حي النخيل',
        'address_en' => 'Al-Nakheel District, Riyadh',
        'header_topbar_announcement_en' => 'Flash Sale: 50% Off Laser Whitening!',
        'footer_text_en' => 'Custom dynamic footer text for testing purposes.',
        'copyright_text_en' => '© 2026 DentCare Polyclinic. Custom Rights.',
        'booking_interval' => 30,
        'minimum_notice_hours' => 2,
        'maximum_days_ahead' => 60,
        'cancellation_hours' => 12,
    ]);

    $response->assertRedirect(route('admin.settings.index'));

    $homeResponse = $this->get(route('home'));
    $homeResponse->assertStatus(200);
    $homeResponse->assertSee('+966 11 999 0000');
    $homeResponse->assertSee('custom-info@dentcare.test');
    $homeResponse->assertSee('Flash Sale: 50% Off Laser Whitening!');
    $homeResponse->assertSee('Custom dynamic footer text for testing purposes.');
});

test('doctor day off in schedule prevents available slot generation', function () {
    $doctorUser = User::factory()->create(['role' => UserRole::Doctor]);
    $doctor = Doctor::create([
        'user_id' => $doctorUser->id,
        'specialization' => 'Dentist',
        'experience_years' => 5,
        'consultation_fee' => 50,
        'is_active' => true,
    ]);

    // Let's create an appointment service instance
    /** @var AppointmentService $service */
    $service = app(AppointmentService::class);

    // Pick a date that is tomorrow
    $testDate = Carbon::tomorrow();
    $dayOfWeek = $testDate->dayOfWeek;

    // Set doctor schedule for this day to be an OFF DAY
    DoctorSchedule::updateOrCreate(
        ['doctor_id' => $doctor->id, 'day_of_week' => $dayOfWeek],
        [
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
            'is_day_off' => true,
        ]
    );

    $slots = $service->getAvailableSlots($doctor->id, $testDate->toDateString());
    expect($slots)->toBeEmpty();

    // Now set doctor schedule for this day to be a WORKING DAY
    DoctorSchedule::updateOrCreate(
        ['doctor_id' => $doctor->id, 'day_of_week' => $dayOfWeek],
        [
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
            'is_day_off' => false,
        ]
    );

    // Make sure clinic working hour also open for this day
    WorkingHour::updateOrCreate(
        ['day_of_week' => $dayOfWeek],
        ['start_time' => '09:00:00', 'end_time' => '17:00:00', 'is_closed' => false]
    );

    $slotsAfter = $service->getAvailableSlots($doctor->id, $testDate->toDateString());
    expect($slotsAfter)->not->toBeEmpty();
});
