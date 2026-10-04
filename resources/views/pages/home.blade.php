@extends('layouts.app')

@section('title', __('app.home'))

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-b from-medical-50/60 to-white overflow-hidden py-16 lg:py-24 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
            
            <!-- Hero Text Content -->
            <div class="lg:col-span-7 space-y-6 text-center lg:{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-medical-100/80 text-medical-800 text-xs font-bold tracking-wide">
                    <span class="w-2 h-2 rounded-full bg-medical-500 animate-pulse"></span>
                    <span>{{ app()->getLocale() === 'ar' ? 'أحدث مركز لطب وتجميل وزراعة الأسنان' : 'State-of-the-Art Dental Care Center' }}</span>
                </div>
                
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-navy-900 tracking-tight leading-[1.15]">
                    {{ app()->getLocale() === 'ar' ? 'ابتسامتك المثالية تبدأ برعاية ' : 'Your Perfect Smile Begins With ' }}
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-medical-600 to-medical-500">
                        {{ app()->getLocale() === 'ar' ? 'استثنائية ومتطورة' : 'Exceptional Dental Care' }}
                    </span>
                </h1>
                
                <p class="text-slate-600 text-base sm:text-lg leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    {{ app()->getLocale() === 'ar' ? 'نقدم لكم أرقى مستويات طب وجراحة الفم والأسنان بأيدي نخبة من أمهر الأطباء والاستشاريين مع أحدث تقنيات الليزر والعلاج بدون ألم.' : 'Experience world-class dental procedures delivered by board-certified specialists with gentle touch and cutting-edge painless technology.' }}
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                    <a href="{{ route('appointments.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl bg-gradient-to-r from-medical-600 to-medical-500 hover:from-medical-700 hover:to-medical-600 text-white font-bold text-base shadow-xl shadow-medical-500/25 transition duration-300 transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>{{ __('app.appointments') }}</span>
                    </a>
                    <a href="{{ route('services.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl bg-white hover:bg-slate-50 text-slate-700 font-bold text-base border border-slate-200 transition duration-300">
                        <span>{{ __('app.services') }}</span>
                        <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <!-- Trust Badges -->
                <div class="pt-6 border-t border-slate-200/80 flex flex-wrap items-center justify-center lg:justify-start gap-6 text-xs text-slate-500">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span class="font-semibold">{{ app()->getLocale() === 'ar' ? 'تعقيم متكامل 100%' : '100% Hospital Grade Sterilization' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span class="font-semibold">{{ app()->getLocale() === 'ar' ? 'تقنيات علاج بدون ألم' : 'Painless Laser Treatments' }}</span>
                    </div>
                </div>
            </div>

            <!-- Hero Image Banner -->
            <div class="lg:col-span-5 relative">
                <div class="relative mx-auto max-w-md lg:max-w-none">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white">
                        <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?w=800&auto=format&fit=crop&q=80" 
                             alt="Dental Clinic" class="w-full h-[440px] object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-navy-950/70 via-transparent to-transparent"></div>
                        <div class="absolute bottom-6 left-6 right-6 text-white">
                            <span class="text-xs uppercase tracking-wider text-medical-300 font-bold block mb-1">DentCare Center</span>
                            <h3 class="text-lg font-bold leading-tight">{{ app()->getLocale() === 'ar' ? 'أكثر من 15 عاماً من التميز والابتسامة المشرقة' : '15+ Years of Clinical Excellence' }}</h3>
                        </div>
                    </div>

                    <!-- Floating Card -->
                    <div class="absolute -bottom-6 {{ app()->getLocale() === 'ar' ? '-left-6' : '-right-6' }} bg-white rounded-2xl p-4 shadow-xl border border-slate-100 flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center font-bold text-xl">
                            ★
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-navy-900">4.9 / 5.0</span>
                            <span class="block text-xs text-slate-400">{{ app()->getLocale() === 'ar' ? 'تقييم أكثر من 2,400 مريض' : 'Based on 2,400+ reviews' }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Statistics Bar -->
<section class="bg-navy-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-3xl sm:text-4xl font-black text-medical-400 mb-1">{{ number_format($stats['patients_count']) }}+</div>
                <div class="text-xs sm:text-sm text-slate-300 font-medium">{{ app()->getLocale() === 'ar' ? 'مريض تم علاجهم' : 'Happy Patients' }}</div>
            </div>
            <div>
                <div class="text-3xl sm:text-4xl font-black text-medical-400 mb-1">{{ $stats['doctors_count'] }}</div>
                <div class="text-xs sm:text-sm text-slate-300 font-medium">{{ app()->getLocale() === 'ar' ? 'أطباء واستشاريون' : 'Specialist Doctors' }}</div>
            </div>
            <div>
                <div class="text-3xl sm:text-4xl font-black text-medical-400 mb-1">{{ $stats['services_count'] }}+</div>
                <div class="text-xs sm:text-sm text-slate-300 font-medium">{{ app()->getLocale() === 'ar' ? 'خدمات تخصصية' : 'Dental Services' }}</div>
            </div>
            <div>
                <div class="text-3xl sm:text-4xl font-black text-medical-400 mb-1">{{ number_format($stats['completed_appointments']) }}+</div>
                <div class="text-xs sm:text-sm text-slate-300 font-medium">{{ app()->getLocale() === 'ar' ? 'جلسة علاجية ناجحة' : 'Successful Treatments' }}</div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Dental Services -->
<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-medical-600 font-bold text-xs uppercase tracking-wider block mb-2">{{ app()->getLocale() === 'ar' ? 'رعاية طبية تخصصية' : 'Specialized Care' }}</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'خدماتنا الطبية المتكاملة' : 'Our Dental Services' }}</h2>
            <p class="text-slate-500 text-sm mt-3">{{ app()->getLocale() === 'ar' ? 'نقدم باقة واسعة من خدمات طب وتجميل الأسنان بأحدث التقنيات وأعلى معايير الجودة العالمية.' : 'Comprehensive dental solutions from routine cleanings to advanced oral surgeries.' }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services as $service)
                <div class="bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group">
                    <div class="h-48 overflow-hidden relative">
                        <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <span class="absolute top-4 {{ app()->getLocale() === 'ar' ? 'left-4' : 'right-4' }} bg-navy-900/80 backdrop-blur-md text-white text-xs font-bold px-3 py-1 rounded-full">
                            {{ $service->duration }} {{ app()->getLocale() === 'ar' ? 'دقيقة' : 'min' }}
                        </span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-navy-900 mb-2 group-hover:text-medical-600 transition">{{ $service->name }}</h3>
                            <p class="text-slate-500 text-sm line-clamp-2 leading-relaxed mb-4">{{ $service->description }}</p>
                        </div>
                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs text-slate-400 block">{{ app()->getLocale() === 'ar' ? 'تبدأ من' : 'Starts at' }}</span>
                                <span class="text-lg font-black text-medical-600">${{ number_format($service->price, 2) }}</span>
                            </div>
                            <a href="{{ route('appointments.create', ['service_id' => $service->id]) }}" class="px-4 py-2 bg-medical-50 text-medical-700 hover:bg-medical-600 hover:text-white rounded-xl text-xs font-bold transition">
                                {{ __('app.appointments') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-medical-600 hover:text-medical-700">
                <span>{{ app()->getLocale() === 'ar' ? 'عرض جميع الخدمات' : 'View All Services' }}</span>
                <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</section>

<!-- Meet Our Doctors Section -->
<section class="py-20 bg-white border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-medical-600 font-bold text-xs uppercase tracking-wider block mb-2">{{ app()->getLocale() === 'ar' ? 'الفريق الطبي' : 'Medical Team' }}</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'نخبة من أمهر أطباء الأسنان' : 'Meet Our Specialists' }}</h2>
            <p class="text-slate-500 text-sm mt-3">{{ app()->getLocale() === 'ar' ? 'فريقنا حاصل على أعلى الدرجات والشهادات الدولية لضمان أفضل علاج لك ولعائلتك.' : 'Dedicated, certified professionals with years of specialized clinical experience.' }}</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($doctors as $doctor)
                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-100 text-center hover:shadow-xl transition-all duration-300 group">
                    <div class="w-28 h-28 mx-auto rounded-full overflow-hidden mb-4 border-4 border-white shadow-md">
                        <img src="{{ $doctor->image_url }}" alt="{{ $doctor->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    </div>
                    <h3 class="text-lg font-bold text-navy-900 mb-1">{{ $doctor->name }}</h3>
                    <p class="text-xs font-semibold text-medical-600 mb-2">{{ $doctor->specialization }}</p>
                    <p class="text-slate-400 text-xs line-clamp-2 mb-4">{{ $doctor->bio }}</p>

                    <div class="pt-4 border-t border-slate-200/60 flex items-center justify-between text-xs">
                        <span class="text-slate-500">{{ $doctor->experience_years }} {{ app()->getLocale() === 'ar' ? 'سنوات خبرة' : 'years exp.' }}</span>
                        <a href="{{ route('doctors.show', $doctor->id) }}" class="text-medical-600 font-bold hover:underline">
                            {{ __('app.view') }} &rarr;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-20 bg-gradient-to-br from-navy-950 via-navy-900 to-navy-950 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="text-medical-400 font-bold text-xs uppercase tracking-wider block mb-2">{{ app()->getLocale() === 'ar' ? 'لماذا تختار عيادتنا؟' : 'Why DentCare?' }}</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight leading-snug mb-6">
                    {{ app()->getLocale() === 'ar' ? 'نضع راحتك وسلامتك على رأس أولوياتنا' : 'Dedicated to Precision, Comfort & Lasting Smiles' }}
                </h2>
                <div class="space-y-6 text-sm text-slate-300">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-medical-500/20 text-medical-400 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-base font-bold text-white mb-1">{{ app()->getLocale() === 'ar' ? 'تعقيم طبي أوروبي معتمد' : 'Hospital-Standard Sterilization' }}</h4>
                            <p class="text-slate-400">{{ app()->getLocale() === 'ar' ? 'أعلى معايير مكافحة العدوى والتعقيم الحراري المتقدم لكل مريض.' : 'Stringent multi-stage autoclaving and individual hygienic packs.' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-medical-500/20 text-medical-400 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-base font-bold text-white mb-1">{{ app()->getLocale() === 'ar' ? 'أجهزة ليزر وأشعة رقمية ثلاثية الأبعاد' : '3D Cone Beam Imaging & Laser' }}</h4>
                            <p class="text-slate-400">{{ app()->getLocale() === 'ar' ? 'تشخيص فائق الدقة بدون ألم وبأقل تعرض للإشعاع.' : 'Instant computerized diagnoses with precision planning for all implants.' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-medical-500/20 text-medical-400 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-base font-bold text-white mb-1">{{ app()->getLocale() === 'ar' ? 'حجز ذكي ودقيق بدون انتظار' : 'Zero Wait Time Online Booking' }}</h4>
                            <p class="text-slate-400">{{ app()->getLocale() === 'ar' ? 'نظام مواعيد لحظي يتيح لك اختيار الطبيب والوقت المناسب مباشرة.' : 'Direct slot booking engine synchronizing real clinic schedules.' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image Block -->
            <div class="relative">
                <img src="https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?w=800&auto=format&fit=crop&q=80" 
                     alt="DentCare modern clinic" class="rounded-3xl shadow-2xl border-4 border-navy-800 object-cover w-full h-[400px]">
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-medical-600 font-bold text-xs uppercase tracking-wider block mb-2">{{ app()->getLocale() === 'ar' ? 'آراء مراجعينا' : 'Patient Reviews' }}</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'ماذا يقول مرضانا عنا؟' : 'Real Stories, Real Smiles' }}</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($reviews as $review)
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex flex-col justify-between">
                    <div>
                        <!-- Stars -->
                        <div class="flex items-center gap-1 text-amber-400 mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-slate-200' }}" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed mb-6 italic">"{{ $review->comment }}"</p>
                    </div>
                    <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                        <img src="{{ $review->patient?->avatar_url }}" alt="{{ $review->patient?->name }}" class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <span class="block text-sm font-bold text-navy-900">{{ $review->patient?->name }}</span>
                            @if($review->doctor)
                                <span class="block text-[11px] text-slate-400">{{ app()->getLocale() === 'ar' ? 'مع د.' : 'With Dr.' }} {{ $review->doctor->name }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Latest Articles -->
@if($blogPosts->count() > 0)
<section class="py-20 bg-white border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-medical-600 font-bold text-xs uppercase tracking-wider block mb-2">{{ app()->getLocale() === 'ar' ? 'المجلة الطبية' : 'Health Blog' }}</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'نصائح ومقالات لصحة أسنانك' : 'Latest Articles & Tips' }}</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($blogPosts as $post)
                <article class="bg-slate-50 rounded-3xl overflow-hidden border border-slate-100 hover:shadow-xl transition-all duration-300 flex flex-col group">
                    <div class="h-44 overflow-hidden">
                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="text-xs text-medical-600 font-bold mb-2">{{ $post->published_at?->format('M d, Y') }}</div>
                            <h3 class="text-lg font-bold text-navy-900 mb-2 group-hover:text-medical-600 transition">{{ $post->title }}</h3>
                            <p class="text-slate-500 text-xs line-clamp-2">{{ $post->excerpt }}</p>
                        </div>
                        <div class="pt-4 border-t border-slate-200/60 mt-4">
                            <a href="{{ route('blog.show', $post->slug) }}" class="text-xs font-bold text-medical-600 hover:text-medical-700">
                                {{ app()->getLocale() === 'ar' ? 'اقرأ المقال بالكامل' : 'Read Article' }} &rarr;
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Call to Action Banner -->
<section class="py-16 bg-gradient-to-r from-medical-600 to-medical-500 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
        <h2 class="text-3xl sm:text-4xl font-extrabold">{{ app()->getLocale() === 'ar' ? 'هل أنت مستعد للحصول على ابتسامة أحلامك؟' : 'Ready for Your Healthiest Smile?' }}</h2>
        <p class="text-medical-100 max-w-xl mx-auto text-sm sm:text-base">{{ app()->getLocale() === 'ar' ? 'احجز موعدك الآن عبر نظامنا الإلكتروني المباشر في أقل من دقيقة واحدة.' : 'Book your consultation online in under a minute with real-time doctor availability.' }}</p>
        <div class="pt-2">
            <a href="{{ route('appointments.create') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-medical-700 hover:bg-slate-100 font-extrabold text-sm rounded-2xl shadow-xl transition">
                <svg class="w-5 h-5 text-medical-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>{{ __('app.appointments') }}</span>
            </a>
        </div>
    </div>
</section>
@endsection
