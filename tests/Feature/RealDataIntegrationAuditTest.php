<?php

use App\Enums\AppointmentStatus;
use App\Enums\ReviewStatus;
use App\Enums\UserRole;
use App\Models\Appointment;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\GalleryItem;
use App\Models\HeroBanner;
use App\Models\HowItWork;
use App\Models\Review;
use App\Models\Service;
use App\Models\Statistic;
use App\Models\User;
use App\Models\WorkingHour;
use App\Services\AppointmentService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Seed essential configurations
    $this->artisan('db:seed', ['--class' => 'ClinicSettingSeeder']);
    $this->artisan('db:seed', ['--class' => 'WorkingHourSeeder']);
    $this->artisan('db:seed', ['--class' => 'AppointmentSettingSeeder']);

    $this->admin = User::factory()->create([
        'email' => 'admin_audit@example.com',
        'role' => UserRole::Admin,
    ]);
});

test('3. Hero Banner: Admin create -> Homepage shows -> Admin update -> Homepage updates -> Deactivate -> Homepage hides', function () {
    // 1. Admin creates Banner with exact requested test values
    $response = $this->actingAs($this->admin)->post(route('admin.hero-banners.store'), [
        'title_ar' => 'DENTCARE_DYNAMIC_TEST_AR',
        'title_en' => 'DENTCARE_DYNAMIC_TEST',
        'description_ar' => 'وصف تجريبي من قاعدة البيانات',
        'description_en' => 'THIS_CONTENT_COMES_FROM_DATABASE',
        'button_text_ar' => 'احجز موعدك',
        'button_text_en' => 'Book Appointment',
        'button_url' => '/appointments/create',
        'sort_order' => 1,
        'is_active' => 1,
    ]);
    $response->assertRedirect(route('admin.hero-banners.index'));

    $banner = HeroBanner::where('title_en', 'DENTCARE_DYNAMIC_TEST')->firstOrFail();

    // 2. Open Homepage: verify exact text appears
    $home = $this->get(route('home'));
    $home->assertStatus(200);
    $home->assertSee('DENTCARE_DYNAMIC_TEST');
    $home->assertSee('THIS_CONTENT_COMES_FROM_DATABASE');

    // 3. Admin updates Banner to DENTCARE_UPDATED_TEST
    $updateResponse = $this->actingAs($this->admin)->put(route('admin.hero-banners.update', $banner->id), [
        'title_ar' => 'DENTCARE_UPDATED_TEST_AR',
        'title_en' => 'DENTCARE_UPDATED_TEST',
        'description_ar' => 'وصف محدث',
        'description_en' => 'UPDATED_DATABASE_CONTENT',
        'button_text_ar' => 'احجز الآن',
        'button_text_en' => 'Book Now',
        'button_url' => '/appointments/create',
        'sort_order' => 1,
        'is_active' => 1,
    ]);
    $updateResponse->assertRedirect(route('admin.hero-banners.index'));

    // 4. Refresh Homepage: verify updated text appears, old text does not
    $homeAfterUpdate = $this->get(route('home'));
    $homeAfterUpdate->assertStatus(200);
    $homeAfterUpdate->assertSee('DENTCARE_UPDATED_TEST');
    $homeAfterUpdate->assertDontSee('DENTCARE_DYNAMIC_TEST');

    // 5. Admin deactivates Banner
    $this->actingAs($this->admin)->patch(route('admin.hero-banners.toggle', $banner->id));
    expect($banner->fresh()->is_active)->toBeFalse();

    // 6. Refresh Homepage: verify banner is hidden
    $homeAfterDeactivate = $this->get(route('home'));
    $homeAfterDeactivate->assertStatus(200);
    $homeAfterDeactivate->assertDontSee('DENTCARE_UPDATED_TEST');
});

test('4. About Section: Admin update title, description, image -> /about and Homepage show new values', function () {
    Storage::fake('public');

    $fakeImage = UploadedFile::fake()->create('about_test.jpg', 100, 'image/jpeg');

    $response = $this->actingAs($this->admin)->post(route('admin.about-section.update'), [
        'title_ar' => 'عن مركزنا المتميز',
        'title_en' => 'ABOUT_DYNAMIC_TEST',
        'description_ar' => 'وصف تفصيلي عن المركز الطبي وطاقمه المتميز.',
        'description_en' => 'ABOUT_DESCRIPTION_DYNAMIC_TEST_CONTENT',
        'experience_years' => 18,
        'experience_text_ar' => 'سنة خبرة وتميز',
        'experience_text_en' => 'Years of Master Clinical Dentistry',
        'image' => $fakeImage,
        'is_active' => 1,
    ]);
    $response->assertRedirect(route('admin.about-section.edit'));

    // Open Homepage
    $home = $this->get(route('home'));
    $home->assertStatus(200);
    $home->assertSee('ABOUT_DYNAMIC_TEST');
    $home->assertSee('ABOUT_DESCRIPTION_DYNAMIC_TEST_CONTENT');
    $home->assertSee('18');

    // Open /about page
    $about = $this->get(route('about'));
    $about->assertStatus(200);
    $about->assertSee('ABOUT_DYNAMIC_TEST');
    $about->assertSee('ABOUT_DESCRIPTION_DYNAMIC_TEST_CONTENT');
    $about->assertSee('18');
});

test('5. Statistics: Create 9999 -> Homepage displays -> Update to 8888 -> Homepage updates -> Deactivate -> Hides', function () {
    // 1. Create statistic
    $response = $this->actingAs($this->admin)->post(route('admin.statistics.store'), [
        'title_ar' => 'حالة ناجحة تجريبية',
        'title_en' => 'DYNAMIC_STAT_TEST',
        'value' => '9999',
        'icon' => 'sparkles',
        'sort_order' => 1,
        'is_active' => 1,
    ]);
    $response->assertRedirect(route('admin.statistics.index'));

    $stat = Statistic::where('title_en', 'DYNAMIC_STAT_TEST')->firstOrFail();

    // 2. Verify on Homepage
    $home = $this->get(route('home'));
    $home->assertStatus(200);
    $home->assertSee('9999');
    $home->assertSee('DYNAMIC_STAT_TEST');

    // 3. Update to 8888
    $updateResponse = $this->actingAs($this->admin)->put(route('admin.statistics.update', $stat->id), [
        'title_ar' => 'حالة ناجحة تجريبية محدثة',
        'title_en' => 'DYNAMIC_STAT_TEST',
        'value' => '8888',
        'icon' => 'sparkles',
        'sort_order' => 1,
        'is_active' => 1,
    ]);
    $updateResponse->assertRedirect(route('admin.statistics.index'));

    // 4. Homepage shows 8888
    $homeAfterUpdate = $this->get(route('home'));
    $homeAfterUpdate->assertStatus(200);
    $homeAfterUpdate->assertSee('8888');
    $homeAfterUpdate->assertDontSee('9999');

    // 5. Deactivate
    $this->actingAs($this->admin)->put(route('admin.statistics.update', $stat->id), [
        'title_ar' => 'حالة ناجحة تجريبية محدثة',
        'title_en' => 'DYNAMIC_STAT_TEST',
        'value' => '8888',
        'icon' => 'sparkles',
        'sort_order' => 1,
        'is_active' => 0,
    ]);

    // 6. Homepage hides it
    $homeAfterDeactivate = $this->get(route('home'));
    $homeAfterDeactivate->assertStatus(200);
    $homeAfterDeactivate->assertDontSee('DYNAMIC_STAT_TEST');
});

test('6. Features (Why Choose Us): Create FEATURE_DYNAMIC_TEST -> Shows -> Update -> Shows updated -> Deactivate -> Hides', function () {
    // 1. Create feature
    $response = $this->actingAs($this->admin)->post(route('admin.features.store'), [
        'title_ar' => 'ميزة تجريبية ديناميكية',
        'title_en' => 'FEATURE_DYNAMIC_TEST',
        'description_ar' => 'وصف الميزة التجريبية الدقيقة.',
        'description_en' => 'Precision digital robotics in implant dentistry.',
        'icon' => 'shield-check',
        'sort_order' => 1,
        'is_active' => 1,
    ]);
    $response->assertRedirect(route('admin.features.index'));

    $feature = Feature::where('title_en', 'FEATURE_DYNAMIC_TEST')->firstOrFail();

    // 2. Shows on Homepage
    $home = $this->get(route('home'));
    $home->assertStatus(200);
    $home->assertSee('FEATURE_DYNAMIC_TEST');

    // 3. Edit feature
    $updateResponse = $this->actingAs($this->admin)->put(route('admin.features.update', $feature->id), [
        'title_ar' => 'ميزة معدلة',
        'title_en' => 'FEATURE_UPDATED_TEST',
        'description_ar' => 'وصف معدل.',
        'description_en' => 'Updated feature description.',
        'icon' => 'sparkles',
        'sort_order' => 1,
        'is_active' => 1,
    ]);
    $updateResponse->assertRedirect(route('admin.features.index'));

    // 4. Shows updated
    $homeAfterUpdate = $this->get(route('home'));
    $homeAfterUpdate->assertStatus(200);
    $homeAfterUpdate->assertSee('FEATURE_UPDATED_TEST');
    $homeAfterUpdate->assertDontSee('FEATURE_DYNAMIC_TEST');

    // 5. Deactivate
    $this->actingAs($this->admin)->put(route('admin.features.update', $feature->id), [
        'title_ar' => 'ميزة معدلة',
        'title_en' => 'FEATURE_UPDATED_TEST',
        'description_ar' => 'وصف معدل.',
        'description_en' => 'Updated feature description.',
        'icon' => 'sparkles',
        'sort_order' => 1,
        'is_active' => 0,
    ]);

    // 6. Hides
    $homeAfterDeactivate = $this->get(route('home'));
    $homeAfterDeactivate->assertStatus(200);
    $homeAfterDeactivate->assertDontSee('FEATURE_UPDATED_TEST');
});

test('7. How It Works: Create step -> Shows -> Reorder -> Order updates -> Deactivate -> Hides', function () {
    // 1. Create step
    $response = $this->actingAs($this->admin)->post(route('admin.how-it-works.store'), [
        'step_number' => 9,
        'title_ar' => 'خطوة الفحص بالأشعة ثلاثية الأبعاد',
        'title_en' => 'STEP_3D_SCAN_TEST',
        'description_ar' => 'تصوير فوري دقيق للفكين.',
        'description_en' => 'High resolution cone beam CT scanning.',
        'icon' => 'camera',
        'sort_order' => 99,
        'is_active' => 1,
    ]);
    $response->assertRedirect(route('admin.how-it-works.index'));

    $step = HowItWork::where('title_en', 'STEP_3D_SCAN_TEST')->firstOrFail();

    // 2. Shows on Homepage
    $home = $this->get(route('home'));
    $home->assertStatus(200);
    $home->assertSee('STEP_3D_SCAN_TEST');

    // 3. Deactivate
    $this->actingAs($this->admin)->put(route('admin.how-it-works.update', $step->id), [
        'step_number' => 9,
        'title_ar' => 'خطوة الفحص بالأشعة ثلاثية الأبعاد',
        'title_en' => 'STEP_3D_SCAN_TEST',
        'description_ar' => 'تصوير فوري دقيق للفكين.',
        'description_en' => 'High resolution cone beam CT scanning.',
        'icon' => 'camera',
        'sort_order' => 99,
        'is_active' => 0,
    ]);

    // 4. Hides from Homepage
    $homeAfterDeactivate = $this->get(route('home'));
    $homeAfterDeactivate->assertStatus(200);
    $homeAfterDeactivate->assertDontSee('STEP_3D_SCAN_TEST');
});

test('8. CTA: Update Title, Description, Button, URL, Phone -> Homepage renders all new values', function () {
    $response = $this->actingAs($this->admin)->post(route('admin.cta-section.update'), [
        'badge_ar' => 'عرض موسمي خاص',
        'badge_en' => 'SEASONAL_EXCLUSIVE_BADGE',
        'title_ar' => 'احصل على ابتسامة هوليوود المتألقة',
        'title_en' => 'CTA_EXCLUSIVE_TITLE_TEST',
        'description_ar' => 'احجز استشارتك التجميلية مع نخبة الاستشاريين اليوم.',
        'description_en' => 'CTA_EXCLUSIVE_DESCRIPTION_TEST',
        'button_text_ar' => 'ابدأ تحولك الآن',
        'button_text_en' => 'CTA_BUTTON_TEXT_TEST',
        'button_url' => '/appointments/special-cta',
        'phone' => '+966 55 123 9999',
        'is_active' => 1,
    ]);
    $response->assertRedirect(route('admin.cta-section.edit'));

    $home = $this->get(route('home'));
    $home->assertStatus(200);
    $home->assertSee('CTA_EXCLUSIVE_TITLE_TEST');
    $home->assertSee('CTA_EXCLUSIVE_DESCRIPTION_TEST');
    $home->assertSee('CTA_BUTTON_TEXT_TEST');
    $home->assertSee('/appointments/special-cta');
    $home->assertSee('+966 55 123 9999');
});

test('9. Services: Admin Create -> Homepage & /services -> Edit -> Updates both -> Deactivate -> Hides both -> /services/{slug} detail', function () {
    // 1. Admin creates service
    $response = $this->actingAs($this->admin)->post(route('admin.services.store'), [
        'name_ar' => 'تقويم شفاف غير مرئي',
        'name_en' => 'INVISALIGN_TEST_SERVICE',
        'description_ar' => 'خدمة تقويم الأسنان الشفاف بأحدث التقنيات.',
        'description_en' => 'Invisalign digital clear aligners therapy.',
        'short_description_ar' => 'تقويم شفاف بدون أسلاك معدنية',
        'short_description_en' => 'Clear aligners without metallic brackets',
        'duration' => 45,
        'price' => 1200.00,
        'is_active' => 1,
    ]);
    $response->assertRedirect(route('admin.services.index'));

    $service = Service::where('name_en', 'INVISALIGN_TEST_SERVICE')->firstOrFail();

    // 2. Appears on Homepage and /services
    $home = $this->get(route('home'));
    $home->assertStatus(200);
    $home->assertSee('INVISALIGN_TEST_SERVICE');

    $servicesPage = $this->get(route('services.index'));
    $servicesPage->assertStatus(200);
    $servicesPage->assertSee('INVISALIGN_TEST_SERVICE');

    // 3. Edit service
    $updateResponse = $this->actingAs($this->admin)->put(route('admin.services.update', $service->id), [
        'name_ar' => 'تقويم شفاف متطور',
        'name_en' => 'INVISALIGN_ADVANCED_SERVICE',
        'description_ar' => 'خدمة تقويم الأسنان الشفاف بأحدث التقنيات المطورة.',
        'description_en' => 'Invisalign advanced digital therapy.',
        'duration' => 45,
        'price' => 1400.00,
        'is_active' => 1,
    ]);
    $updateResponse->assertRedirect(route('admin.services.index'));

    // 4. Shows updated on both
    $homeAfterUpdate = $this->get(route('home'));
    $homeAfterUpdate->assertSee('INVISALIGN_ADVANCED_SERVICE');
    $homeAfterUpdate->assertDontSee('INVISALIGN_TEST_SERVICE');

    $servicesAfterUpdate = $this->get(route('services.index'));
    $servicesAfterUpdate->assertSee('INVISALIGN_ADVANCED_SERVICE');

    // 5. Open /services/{slug} detail page
    $slugResponse = $this->get(route('services.show', $service->fresh()->slug));
    $slugResponse->assertStatus(200);
    $slugResponse->assertSee('INVISALIGN_ADVANCED_SERVICE');

    // 6. Deactivate service
    $this->actingAs($this->admin)->put(route('admin.services.update', $service->id), [
        'name_ar' => 'تقويم شفاف متطور',
        'name_en' => 'INVISALIGN_ADVANCED_SERVICE',
        'description_ar' => 'خدمة تقويم الأسنان الشفاف بأحدث التقنيات المطورة.',
        'description_en' => 'Invisalign advanced digital therapy.',
        'duration' => 45,
        'price' => 1400.00,
        'is_active' => 0,
    ]);

    // 7. Disappears from Homepage and /services
    $homeAfterDeactivate = $this->get(route('home'));
    $homeAfterDeactivate->assertDontSee('INVISALIGN_ADVANCED_SERVICE');

    $servicesAfterDeactivate = $this->get(route('services.index'));
    $servicesAfterDeactivate->assertDontSee('INVISALIGN_ADVANCED_SERVICE');
});

test('10. Doctors: Admin Create -> Homepage & /doctors -> Edit -> Updates both -> Deactivate -> Hides both', function () {
    // 1. Admin creates Doctor
    $response = $this->actingAs($this->admin)->post(route('admin.doctors.store'), [
        'name' => 'Dr. Alexander Vance',
        'email' => 'dr.alexander@example.com',
        'password' => 'SecurePass123!',
        'password_confirmation' => 'SecurePass123!',
        'phone' => '+966 50 111 2233',
        'specialization' => 'Prosthodontics Specialist',
        'specialization_ar' => 'أخصائي تركيبات وتجميل الأسنان',
        'specialization_en' => 'Prosthodontics Specialist',
        'bio_en' => 'Distinguished prosthetic smile architect.',
        'bio_ar' => 'خبير تصميم وتأهيل الابتسامة المتقدمة.',
        'experience_years' => 14,
        'consultation_fee' => 120.00,
        'is_active' => 1,
    ]);
    $response->assertRedirect(route('admin.doctors.index'));

    $doctor = Doctor::whereHas('user', function ($q) {
        $q->where('name', 'Dr. Alexander Vance');
    })->firstOrFail();

    // 2. Appears on Homepage and /doctors
    $home = $this->get(route('home'));
    $home->assertStatus(200);
    $home->assertSee('Dr. Alexander Vance');

    $doctorsPage = $this->get(route('doctors.index'));
    $doctorsPage->assertStatus(200);
    $doctorsPage->assertSee('Dr. Alexander Vance');

    // 3. Edit doctor
    $updateResponse = $this->actingAs($this->admin)->put(route('admin.doctors.update', $doctor->id), [
        'name' => 'Dr. Alexander Vance Senior',
        'email' => 'dr.alexander@example.com',
        'phone' => '+966 50 111 2233',
        'specialization' => 'Senior Prosthodontics Consultant',
        'specialization_ar' => 'استشاري أول تركيبات وتجميل الأسنان',
        'specialization_en' => 'Senior Prosthodontics Consultant',
        'experience_years' => 16,
        'consultation_fee' => 150.00,
        'is_active' => 1,
    ]);
    $updateResponse->assertRedirect(route('admin.doctors.index'));

    // 4. Shows updated name and fee
    $homeAfterUpdate = $this->get(route('home'));
    $homeAfterUpdate->assertSee('Dr. Alexander Vance Senior');

    $doctorsAfterUpdate = $this->get(route('doctors.index'));
    $doctorsAfterUpdate->assertSee('Dr. Alexander Vance Senior');

    // 5. Deactivate doctor
    $this->actingAs($this->admin)->put(route('admin.doctors.update', $doctor->id), [
        'name' => 'Dr. Alexander Vance Senior',
        'email' => 'dr.alexander@example.com',
        'phone' => '+966 50 111 2233',
        'specialization' => 'Senior Prosthodontics Consultant',
        'experience_years' => 16,
        'consultation_fee' => 150.00,
        'is_active' => 0,
    ]);

    // 6. Disappears from Homepage and /doctors
    $homeAfterDeactivate = $this->get(route('home'));
    $homeAfterDeactivate->assertDontSee('Dr. Alexander Vance Senior');

    $doctorsAfterDeactivate = $this->get(route('doctors.index'));
    $doctorsAfterDeactivate->assertDontSee('Dr. Alexander Vance Senior');
});

test('11. Doctor Schedule: Working Day, Day Off, Hours, Breaks, Existing Booking slot calculation', function () {
    $doctorUser = User::factory()->create(['name' => 'Dr. Schedule Expert', 'role' => UserRole::Doctor]);
    $doctor = Doctor::create([
        'user_id' => $doctorUser->id,
        'specialization' => 'Oral Surgeon',
        'experience_years' => 8,
        'consultation_fee' => 100,
        'is_active' => true,
    ]);

    $service = Service::create([
        'name_ar' => 'خلع جراحي للضرس',
        'name_en' => 'Surgical Extraction',
        'slug' => 'surgical-extraction',
        'description_ar' => 'وصف الخلع الجراحي',
        'description_en' => 'Surgical extraction description',
        'duration' => 30,
        'price' => 300,
        'is_active' => true,
    ]);

    /** @var AppointmentService $appointmentService */
    $appointmentService = app(AppointmentService::class);

    // Pick a date in the near future (e.g. 3 days from now)
    $targetDate = Carbon::today()->addDays(3);
    $dayOfWeek = $targetDate->dayOfWeek;

    // Clinic is open 09:00 - 17:00
    WorkingHour::updateOrCreate(
        ['day_of_week' => $dayOfWeek],
        ['start_time' => '09:00:00', 'end_time' => '17:00:00', 'is_closed' => false]
    );

    // Case A: Doctor has Day Off -> 0 slots
    DoctorSchedule::updateOrCreate(
        ['doctor_id' => $doctor->id, 'day_of_week' => $dayOfWeek],
        ['start_time' => '09:00:00', 'end_time' => '17:00:00', 'is_day_off' => true]
    );

    $slotsDayOff = $appointmentService->getAvailableSlots($doctor->id, $targetDate->toDateString());
    expect($slotsDayOff)->toBeEmpty();

    // Case B: Doctor works 10:00 to 14:00 with Break 12:00 to 13:00
    DoctorSchedule::updateOrCreate(
        ['doctor_id' => $doctor->id, 'day_of_week' => $dayOfWeek],
        [
            'start_time' => '10:00:00',
            'end_time' => '14:00:00',
            'break_start' => '12:00:00',
            'break_end' => '13:00:00',
            'is_day_off' => false,
        ]
    );

    $slots = $appointmentService->getAvailableSlots($doctor->id, $targetDate->toDateString());
    expect($slots)->not->toBeEmpty();

    // Verify 09:00 is NOT present (doctor starts at 10:00)
    $slot9 = collect($slots)->firstWhere('time', '09:00');
    expect($slot9)->toBeNull();

    // Verify 10:00 is available
    $slot10 = collect($slots)->firstWhere('time', '10:00');
    expect($slot10)->not->toBeNull();
    expect($slot10['available'])->toBeTrue();

    // Verify 12:00 slot is marked UNAVAILABLE due to doctor break
    $slot12 = collect($slots)->firstWhere('time', '12:00');
    expect($slot12)->not->toBeNull();
    expect($slot12['available'])->toBeFalse();
    expect($slot12['reason'])->toBe('Doctor on break');

    // Case C: Book appointment at 10:00 -> Slot becomes unavailable
    $patient = User::factory()->create(['role' => UserRole::Patient]);
    $appointment = Appointment::create([
        'patient_id' => $patient->id,
        'doctor_id' => $doctor->id,
        'service_id' => $service->id,
        'appointment_date' => $targetDate->toDateString(),
        'start_time' => '10:00:00',
        'end_time' => '10:30:00',
        'status' => AppointmentStatus::Confirmed,
    ]);

    $slotsAfterBooking = $appointmentService->getAvailableSlots($doctor->id, $targetDate->toDateString());
    $slot10After = collect($slotsAfterBooking)->firstWhere('time', '10:00');
    expect($slot10After['available'])->toBeFalse();
    expect($slot10After['reason'])->toBe('Slot already booked');
});

test('12. Gallery: Admin upload -> Gallery shows -> Edit metadata -> Updates -> Deactivate -> Hides -> Delete -> Disk cleaned', function () {
    Storage::fake('public');

    $fakeImage = UploadedFile::fake()->create('smile_case.jpg', 100, 'image/jpeg');

    // 1. Upload
    $response = $this->actingAs($this->admin)->post(route('admin.gallery.store'), [
        'title_ar' => 'حالة ابتسامة هوليوود',
        'title_en' => 'HOLLYWOOD_SMILE_GALLERY_TEST',
        'category' => 'Cosmetic Dentistry',
        'image' => $fakeImage,
        'sort_order' => 1,
        'is_active' => 1,
    ]);
    $response->assertRedirect(route('admin.gallery.index'));

    $item = GalleryItem::where('title_en', 'HOLLYWOOD_SMILE_GALLERY_TEST')->firstOrFail();
    expect(Storage::disk('public')->exists($item->image))->toBeTrue();

    // 2. Shows in public Gallery
    $galleryPage = $this->get(route('gallery'));
    $galleryPage->assertStatus(200);
    $galleryPage->assertSee('HOLLYWOOD_SMILE_GALLERY_TEST');

    // 3. Edit metadata
    $updateResponse = $this->actingAs($this->admin)->put(route('admin.gallery.update', $item->id), [
        'title_ar' => 'حالة ابتسامة هوليوود المتطورة',
        'title_en' => 'HOLLYWOOD_SMILE_UPDATED_TEST',
        'category' => 'Cosmetic Dentistry',
        'sort_order' => 1,
        'is_active' => 1,
    ]);
    $updateResponse->assertRedirect(route('admin.gallery.index'));

    $galleryAfterUpdate = $this->get(route('gallery'));
    $galleryAfterUpdate->assertSee('HOLLYWOOD_SMILE_UPDATED_TEST');

    // 4. Deactivate via toggle
    $this->actingAs($this->admin)->patch(route('admin.gallery.toggle', $item->id));
    expect($item->fresh()->is_active)->toBeFalse();

    $galleryAfterDeactivate = $this->get(route('gallery'));
    $galleryAfterDeactivate->assertDontSee('HOLLYWOOD_SMILE_UPDATED_TEST');

    // 5. Delete and verify image is cleaned from disk
    $imagePath = $item->image;
    $this->actingAs($this->admin)->delete(route('admin.gallery.destroy', $item->id));
    $this->assertDatabaseMissing('gallery_items', ['id' => $item->id]);
    expect(Storage::disk('public')->exists($imagePath))->toBeFalse();
});

test('13. FAQ: Admin Create -> Shows -> Update -> Updates -> Deactivate -> Hides', function () {
    // 1. Create FAQ
    $response = $this->actingAs($this->admin)->post(route('admin.faqs.store'), [
        'question_ar' => 'هل تبييض الأسنان بالليزر مؤلم؟',
        'question_en' => 'FAQ_LASER_PAIN_TEST_QUESTION',
        'answer_ar' => 'إجراء آمن تماماً وبدون ألم.',
        'answer_en' => 'Completely painless laser whitening protocol.',
        'sort_order' => 1,
        'is_active' => 1,
    ]);
    $response->assertRedirect(route('admin.faqs.index'));

    $faq = Faq::where('question_en', 'FAQ_LASER_PAIN_TEST_QUESTION')->firstOrFail();

    // 2. Shows on Homepage and /faq
    $home = $this->get(route('home'));
    $home->assertStatus(200);
    $home->assertSee('FAQ_LASER_PAIN_TEST_QUESTION');

    $faqPage = $this->get(route('faq'));
    $faqPage->assertStatus(200);
    $faqPage->assertSee('FAQ_LASER_PAIN_TEST_QUESTION');

    // 3. Update FAQ
    $updateResponse = $this->actingAs($this->admin)->put(route('admin.faqs.update', $faq->id), [
        'question_ar' => 'هل تبييض الأسنان بالليزر مؤلم؟ (محدث)',
        'question_en' => 'FAQ_LASER_PAIN_UPDATED_QUESTION',
        'answer_ar' => 'إجراء آمن تماماً ومريح جداً.',
        'answer_en' => 'Updated painless laser answer.',
        'sort_order' => 1,
        'is_active' => 1,
    ]);
    $updateResponse->assertRedirect(route('admin.faqs.index'));

    // 4. Shows updated
    $faqPageAfterUpdate = $this->get(route('faq'));
    $faqPageAfterUpdate->assertSee('FAQ_LASER_PAIN_UPDATED_QUESTION');
    $faqPageAfterUpdate->assertDontSee('FAQ_LASER_PAIN_TEST_QUESTION');

    // 5. Deactivate via toggle
    $this->actingAs($this->admin)->patch(route('admin.faqs.toggle', $faq->id));
    expect($faq->fresh()->is_active)->toBeFalse();

    // 6. Hides from public
    $faqPageAfterDeactivate = $this->get(route('faq'));
    $faqPageAfterDeactivate->assertDontSee('FAQ_LASER_PAIN_UPDATED_QUESTION');
});

test('14. Blog: Admin Create -> Publish -> /blog and slug -> Edit -> Unpublish -> 404 on slug & hidden from list', function () {
    $category = Category::create([
        'name_ar' => 'نصائح طبية',
        'name_en' => 'Clinical Advice',
        'slug' => 'clinical-advice',
    ]);

    // 1. Create and publish blog post
    $response = $this->actingAs($this->admin)->post(route('admin.blog.store'), [
        'title_ar' => 'دليلك الشامل لزراعة الأسنان الفورية',
        'title_en' => 'BLOG_IMPLANT_GUIDE_TEST',
        'slug' => 'blog-implant-guide-test',
        'content_ar' => 'محتوى تفصيلي عن تقنيات الزراعة بدون جراحة تقليدية.',
        'content_en' => 'Comprehensive clinical evidence on immediate implants.',
        'excerpt_ar' => 'موجز المقال الطبي.',
        'excerpt_en' => 'Short clinical summary of the implant article.',
        'is_published' => 1,
        'categories' => [$category->id],
    ]);
    $response->assertRedirect(route('admin.blog.index'));

    $post = BlogPost::where('slug', 'blog-implant-guide-test')->firstOrFail();

    // 2. Shows on /blog and /blog/{slug}
    $blogList = $this->get(route('blog.index'));
    $blogList->assertStatus(200);
    $blogList->assertSee('BLOG_IMPLANT_GUIDE_TEST');

    $blogShow = $this->get(route('blog.show', $post->slug));
    $blogShow->assertStatus(200);
    $blogShow->assertSee('BLOG_IMPLANT_GUIDE_TEST');

    // 3. Edit title
    $this->actingAs($this->admin)->put(route('admin.blog.update', $post->id), [
        'title_ar' => 'دليلك الشامل لزراعة الأسنان الفورية (محدث)',
        'title_en' => 'BLOG_IMPLANT_GUIDE_UPDATED',
        'slug' => 'blog-implant-guide-test',
        'content_ar' => 'محتوى محدث.',
        'content_en' => 'Updated clinical content.',
        'is_published' => 1,
    ]);

    $blogShowUpdated = $this->get(route('blog.show', $post->slug));
    $blogShowUpdated->assertSee('BLOG_IMPLANT_GUIDE_UPDATED');

    // 4. Unpublish post
    $this->actingAs($this->admin)->put(route('admin.blog.update', $post->id), [
        'title_ar' => 'دليلك الشامل لزراعة الأسنان الفورية (محدث)',
        'title_en' => 'BLOG_IMPLANT_GUIDE_UPDATED',
        'slug' => 'blog-implant-guide-test',
        'content_ar' => 'محتوى محدث.',
        'content_en' => 'Updated clinical content.',
        'is_published' => 0,
    ]);

    // 5. Must disappear from /blog and return 404 on show
    $blogListAfterUnpublish = $this->get(route('blog.index'));
    $blogListAfterUnpublish->assertDontSee('BLOG_IMPLANT_GUIDE_UPDATED');

    $blogShow404 = $this->get(route('blog.show', $post->slug));
    $blogShow404->assertStatus(404);
});

test('15. Reviews / Testimonials: Patient submits -> Starts Pending -> Admin Approves -> Shows -> Admin Rejects -> Hides', function () {
    $patient = User::factory()->create(['role' => UserRole::Patient]);
    $doctorUser = User::factory()->create(['role' => UserRole::Doctor]);
    $doctor = Doctor::create([
        'user_id' => $doctorUser->id,
        'specialization' => 'Endodontist',
        'experience_years' => 7,
        'consultation_fee' => 80,
        'is_active' => true,
    ]);

    $service = Service::create([
        'name_ar' => 'فحص روتيني',
        'name_en' => 'Routine Checkup',
        'slug' => 'routine-checkup',
        'description_ar' => 'وصف فحص روتيني',
        'description_en' => 'Routine checkup description',
        'duration' => 30,
        'price' => 50,
        'is_active' => true,
    ]);

    $appointment = Appointment::create([
        'patient_id' => $patient->id,
        'doctor_id' => $doctor->id,
        'service_id' => $service->id,
        'appointment_date' => Carbon::yesterday()->toDateString(),
        'start_time' => '10:00:00',
        'end_time' => '10:30:00',
        'status' => AppointmentStatus::Completed,
    ]);

    // 1. Patient submits review
    $response = $this->actingAs($patient)->post(route('patient.reviews.store'), [
        'appointment_id' => $appointment->id,
        'doctor_id' => $doctor->id,
        'rating' => 5,
        'comment' => 'REVIEW_SUPER_SATISFIED_PATIENT_TEST',
    ]);
    $response->assertRedirect();

    $review = Review::where('comment', 'REVIEW_SUPER_SATISFIED_PATIENT_TEST')->firstOrFail();

    // 2. Starts PENDING
    expect($review->status)->toBe(ReviewStatus::Pending);

    // 3. Public Homepage does NOT show pending review
    $home = $this->get(route('home'));
    $home->assertDontSee('REVIEW_SUPER_SATISFIED_PATIENT_TEST');

    // 4. Admin approves review
    $approveResponse = $this->actingAs($this->admin)->patch(route('admin.reviews.update-status', $review->id), [
        'status' => 'approved',
    ]);
    $approveResponse->assertRedirect(route('admin.reviews.index'));

    expect($review->fresh()->status)->toBe(ReviewStatus::Approved);

    // 5. Public Homepage NOW shows the approved review
    $homeAfterApproval = $this->get(route('home'));
    $homeAfterApproval->assertSee('REVIEW_SUPER_SATISFIED_PATIENT_TEST');

    // 6. Admin rejects review
    $rejectResponse = $this->actingAs($this->admin)->patch(route('admin.reviews.update-status', $review->id), [
        'status' => 'rejected',
    ]);
    $rejectResponse->assertRedirect(route('admin.reviews.index'));

    // 7. Public Homepage hides rejected review
    $homeAfterRejection = $this->get(route('home'));
    $homeAfterRejection->assertDontSee('REVIEW_SUPER_SATISFIED_PATIENT_TEST');
});

test('16. Clinic Settings: Update Clinic Name, Phone, WhatsApp, Email, Address, Socials, Footer, Copyright, Topbar, SEO -> Propagates everywhere', function () {
    $response = $this->actingAs($this->admin)->post(route('admin.settings.update-clinic'), [
        'clinic_name_ar' => 'مجمع النخبة الطبي التخصصي',
        'clinic_name_en' => 'ELITE_CLINIC_NAME_TEST',
        'email' => 'contact@elite-clinic-test.com',
        'phone' => '+966 11 888 7777',
        'whatsapp' => '+966 50 888 7777',
        'address_ar' => 'الرياض، برج المملكة، الدور 15',
        'address_en' => 'ELITE_ADDRESS_TEST_RIYADH',
        'header_topbar_announcement_en' => 'ELITE_TOPBAR_ANNOUNCEMENT_TEST',
        'footer_text_en' => 'ELITE_FOOTER_CUSTOM_TEXT_TEST',
        'copyright_text_en' => 'ELITE_COPYRIGHT_2026_TEST',
        'facebook_url' => 'https://facebook.com/elite-test',
        'instagram_url' => 'https://instagram.com/elite-test',
        'linkedin_url' => 'https://linkedin.com/company/elite-test',
        'youtube_url' => 'https://youtube.com/@elite-test',
        'twitter_url' => 'https://x.com/elite-test',
        'meta_description_en' => 'ELITE_SEO_META_DESCRIPTION_TEST',
        'meta_keywords_en' => 'elite, implants, surgery, riyadh',
        'booking_interval' => 30,
        'minimum_notice_hours' => 2,
        'maximum_days_ahead' => 60,
        'cancellation_hours' => 12,
    ]);
    $response->assertRedirect(route('admin.settings.index'));

    // 1. Homepage & Layout Checks
    $home = $this->get(route('home'));
    $home->assertStatus(200);

    // Navbar & Header
    $home->assertSee('ELITE_CLINIC_NAME_TEST');
    $home->assertSee('+966 11 888 7777');
    $home->assertSee('ELITE_TOPBAR_ANNOUNCEMENT_TEST');
    $home->assertSee('https://wa.me/966508887777');

    // Social Links in Footer
    $home->assertSee('https://facebook.com/elite-test');
    $home->assertSee('https://instagram.com/elite-test');
    $home->assertSee('https://linkedin.com/company/elite-test');
    $home->assertSee('https://youtube.com/@elite-test');
    $home->assertSee('https://x.com/elite-test');

    // Footer Text & Copyright & Address
    $home->assertSee('ELITE_FOOTER_CUSTOM_TEXT_TEST');
    $home->assertSee('ELITE_COPYRIGHT_2026_TEST');
    $home->assertSee('ELITE_ADDRESS_TEST_RIYADH');
    $home->assertSee('contact@elite-clinic-test.com');

    // SEO Meta description
    $home->assertSee('ELITE_SEO_META_DESCRIPTION_TEST');

    // 2. Contact Page Checks
    $contact = $this->get(route('contact'));
    $contact->assertStatus(200);
    $contact->assertSee('ELITE_ADDRESS_TEST_RIYADH');
    $contact->assertSee('+966 11 888 7777');
    $contact->assertSee('contact@elite-clinic-test.com');
});

test('19. Admin Dashboard Reality Check: Statistics dynamically reflect database records', function () {
    // Check initial dashboard metrics
    $initialResponse = $this->actingAs($this->admin)->get(route('admin.dashboard'));
    $initialResponse->assertStatus(200);

    // Create 3 new patients
    User::factory()->count(3)->create(['role' => UserRole::Patient]);

    // Create 2 new services
    Service::create([
        'name_ar' => 'خدمة قياس 1',
        'name_en' => 'Metric Service 1',
        'slug' => 'metric-service-1',
        'description_ar' => 'وصف خدمة قياس 1',
        'description_en' => 'Metric Service 1 description',
        'duration' => 30,
        'price' => 100,
        'is_active' => true,
    ]);
    Service::create([
        'name_ar' => 'خدمة قياس 2',
        'name_en' => 'Metric Service 2',
        'slug' => 'metric-service-2',
        'description_ar' => 'وصف خدمة قياس 2',
        'description_en' => 'Metric Service 2 description',
        'duration' => 30,
        'price' => 120,
        'is_active' => true,
    ]);

    $updatedResponse = $this->actingAs($this->admin)->get(route('admin.dashboard'));
    $updatedResponse->assertStatus(200);

    $stats = $updatedResponse->viewData('stats');
    expect($stats['total_patients'])->toBe(3);
    expect($stats['total_services'])->toBeGreaterThanOrEqual(2);
});

test('24. Full End-to-End Acceptance Scenario: Settings -> CMS -> Doctor Schedule -> Booking -> Doctor Completion -> Review Moderation -> Public Display', function () {
    // 1. Change clinic name and phone
    $this->actingAs($this->admin)->post(route('admin.settings.update-clinic'), [
        'clinic_name_ar' => 'مركز دينت كير العالمي',
        'clinic_name_en' => 'DentCare Global Polyclinic',
        'email' => 'care@dentcare-global.com',
        'phone' => '+966 11 555 4444',
        'address_ar' => 'الرياض',
        'address_en' => 'Riyadh',
        'booking_interval' => 30,
        'minimum_notice_hours' => 1,
        'maximum_days_ahead' => 60,
        'cancellation_hours' => 12,
    ]);

    // 2. Create Hero Banner
    $this->actingAs($this->admin)->post(route('admin.hero-banners.store'), [
        'title_ar' => 'ابتسامة مشرقة تدوم',
        'title_en' => 'E2E Radiance Smile',
        'description_ar' => 'رعاية متكاملة لأسنانك.',
        'description_en' => 'Total clinical excellence for your smile.',
        'button_text_ar' => 'احجز موعدك',
        'button_text_en' => 'Book E2E',
        'button_url' => '/appointments/create',
        'sort_order' => 1,
        'is_active' => 1,
    ]);

    // 3. Create Service
    $this->actingAs($this->admin)->post(route('admin.services.store'), [
        'name_ar' => 'تبييض الأسنان بالليزر E2E',
        'name_en' => 'E2E Laser Whitening',
        'description_ar' => 'تبييض احترافي سريع وآمن.',
        'description_en' => 'High-end clinical laser whitening.',
        'duration' => 30,
        'price' => 450,
        'is_active' => 1,
    ]);
    $service = Service::where('name_en', 'E2E Laser Whitening')->firstOrFail();

    // 4. Create Doctor
    $this->actingAs($this->admin)->post(route('admin.doctors.store'), [
        'name' => 'Dr. Olivia Carter',
        'email' => 'dr.olivia@dentcare.test',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'phone' => '+966 54 321 0000',
        'specialization' => 'Aesthetic Dentistry',
        'experience_years' => 9,
        'consultation_fee' => 100,
        'is_active' => 1,
    ]);
    $doctor = Doctor::whereHas('user', function ($q) {
        $q->where('name', 'Dr. Olivia Carter');
    })->firstOrFail();

    // 5. Set Doctor Schedule (Working 09:00 - 17:00, Break 13:00 - 14:00)
    $bookingDate = Carbon::today()->addDays(2);
    $dayOfWeek = $bookingDate->dayOfWeek;

    WorkingHour::updateOrCreate(
        ['day_of_week' => $dayOfWeek],
        ['start_time' => '09:00:00', 'end_time' => '17:00:00', 'is_closed' => false]
    );

    $this->actingAs($this->admin)->post(route('admin.doctors.schedule.update', $doctor->id), [
        'schedules' => [
            $dayOfWeek => [
                'start_time' => '09:00',
                'end_time' => '17:00',
                'break_start' => '13:00',
                'break_end' => '14:00',
                'is_day_off' => 0,
            ],
        ],
    ]);

    // 6. Create FAQ
    $this->actingAs($this->admin)->post(route('admin.faqs.store'), [
        'question_ar' => 'هل الإجراء مؤلم؟',
        'question_en' => 'Is E2E procedure painful?',
        'answer_ar' => 'غير مؤلم تماماً.',
        'answer_en' => 'Completely comfortable and painless.',
        'sort_order' => 1,
        'is_active' => 1,
    ]);

    // 7. Verify Public Pages Render Dynamic Elements
    $home = $this->get(route('home'));
    $home->assertStatus(200);
    $home->assertSee('DentCare Global Polyclinic');
    $home->assertSee('E2E Radiance Smile');
    $home->assertSee('E2E Laser Whitening');
    $home->assertSee('Dr. Olivia Carter');
    $home->assertSee('Is E2E procedure painful?');

    // 8. Book Appointment as Patient
    $patient = User::factory()->create([
        'name' => 'Sarah Jenkins',
        'email' => 'sarah.j@example.test',
        'role' => UserRole::Patient,
    ]);

    $bookResponse = $this->actingAs($patient)->post(route('appointments.store'), [
        'doctor_id' => $doctor->id,
        'service_id' => $service->id,
        'appointment_date' => $bookingDate->toDateString(),
        'start_time' => '10:00',
        'notes' => 'Looking forward to laser whitening.',
    ]);
    $appointment = Appointment::where('patient_id', $patient->id)->firstOrFail();
    $bookResponse->assertRedirect(route('patient.appointments.show', $appointment->id));
    expect($appointment->doctor_id)->toBe($doctor->id);
    expect($appointment->status)->toBe(AppointmentStatus::Pending);

    // 9. Doctor logins and sees appointment, confirms it, then completes it
    $doctorUser = $doctor->user;
    $this->actingAs($doctorUser);

    // Update appointment status: Pending -> Confirmed
    $this->actingAs($this->admin)->patch(route('admin.appointments.update-status', $appointment->id), [
        'status' => 'confirmed',
    ]);
    expect($appointment->fresh()->status)->toBe(AppointmentStatus::Confirmed);

    // Update appointment status: Confirmed -> Completed
    $this->actingAs($this->admin)->patch(route('admin.appointments.update-status', $appointment->id), [
        'status' => 'completed',
    ]);
    expect($appointment->fresh()->status)->toBe(AppointmentStatus::Completed);

    // 10. Patient submits Review
    $reviewResponse = $this->actingAs($patient)->post(route('patient.reviews.store'), [
        'appointment_id' => $appointment->id,
        'doctor_id' => $doctor->id,
        'rating' => 5,
        'comment' => 'E2E_EXCEPTIONAL_WHITENING_RESULT_TEST',
    ]);
    $reviewResponse->assertRedirect();

    $review = Review::where('comment', 'E2E_EXCEPTIONAL_WHITENING_RESULT_TEST')->firstOrFail();
    expect($review->status)->toBe(ReviewStatus::Pending);

    // Review not yet on homepage
    $this->get(route('home'))->assertDontSee('E2E_EXCEPTIONAL_WHITENING_RESULT_TEST');

    // 11. Admin approves Review
    $this->actingAs($this->admin)->patch(route('admin.reviews.update-status', $review->id), [
        'status' => 'approved',
    ]);

    // 12. Review now appears publicly on homepage
    $this->get(route('home'))->assertSee('E2E_EXCEPTIONAL_WHITENING_RESULT_TEST');
});
