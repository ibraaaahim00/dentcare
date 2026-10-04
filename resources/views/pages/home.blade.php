@extends('layouts.app')

@section('title', clinic_setting(app()->getLocale() === 'ar' ? 'meta_title_ar' : 'meta_title_en', __('app.home')))

@section('content')

<!-- ============================================================ -->
<!-- 1. HERO / BANNERS SECTION (Dynamic CMS)                      -->
<!-- ============================================================ -->
@if($heroBanners->count() > 0)
    <section class="relative bg-gradient-to-b from-medical-50/70 via-white to-white overflow-hidden py-14 lg:py-20 border-b border-slate-100" 
             x-data="{ activeIndex: 0, total: {{ $heroBanners->count() }} }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            @foreach($heroBanners as $index => $banner)
                <div x-show="activeIndex === {{ $index }}" 
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center"
                     {{ $index > 0 ? 'x-cloak' : '' }}>
                    
                    <!-- Text Content -->
                    <div class="lg:col-span-7 space-y-6 text-center lg:{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                        @if($banner->badge)
                            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-medical-100/80 text-medical-800 text-xs font-bold tracking-wide">
                                <span class="w-2 h-2 rounded-full bg-medical-500 animate-pulse"></span>
                                <span>{{ $banner->badge }}</span>
                            </div>
                        @endif
                        
                        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-navy-900 tracking-tight leading-[1.18]">
                            {{ $banner->title }}
                        </h1>
                        
                        @if($banner->description)
                            <p class="text-slate-600 text-base sm:text-lg leading-relaxed max-w-2xl mx-auto lg:mx-0">
                                {{ $banner->description }}
                            </p>
                        @endif

                        <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                            @if($banner->button_text && $banner->button_url)
                                <a href="{{ $banner->button_url }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl bg-gradient-to-r from-medical-600 to-medical-500 hover:from-medical-700 hover:to-medical-600 text-white font-bold text-base shadow-xl shadow-medical-500/25 transition duration-300 transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span>{{ $banner->button_text }}</span>
                                </a>
                            @endif

                            @if($banner->secondary_button_text && $banner->secondary_button_url)
                                <a href="{{ $banner->secondary_button_url }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl bg-white hover:bg-slate-50 text-slate-700 font-bold text-base border border-slate-200 transition duration-300">
                                    <span>{{ $banner->secondary_button_text }}</span>
                                    <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Banner Visual -->
                    <div class="lg:col-span-5 relative">
                        <div class="relative mx-auto max-w-md lg:max-w-none">
                            <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white">
                                <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}" class="w-full h-[420px] object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-navy-950/60 via-transparent to-transparent"></div>
                                <div class="absolute bottom-5 left-5 right-5 text-white">
                                    <span class="text-xs uppercase tracking-wider text-medical-300 font-bold block mb-1">
                                        {{ clinic_setting(app()->getLocale() === 'ar' ? 'clinic_name_ar' : 'clinic_name_en', 'DentCare') }}
                                    </span>
                                    <h3 class="text-base font-bold leading-tight">{{ $banner->title }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach

            <!-- Slider Dots if multiple banners -->
            @if($heroBanners->count() > 1)
                <div class="flex items-center justify-center gap-2 mt-8">
                    @foreach($heroBanners as $i => $b)
                        <button @click="activeIndex = {{ $i }}" 
                                :class="activeIndex === {{ $i }} ? 'w-8 bg-medical-600' : 'w-2.5 bg-slate-300 hover:bg-slate-400'" 
                                class="h-2.5 rounded-full transition-all duration-300" 
                                aria-label="Slide {{ $i + 1 }}"></button>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endif

<!-- ============================================================ -->
<!-- 2. STATISTICS SECTION (Dynamic CMS)                          -->
<!-- ============================================================ -->
@if($statistics->count() > 0)
    <section class="bg-navy-900 text-white py-12 border-b border-navy-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-{{ min(4, $statistics->count()) }} gap-8 text-center">
                @foreach($statistics as $stat)
                    <div>
                        <div class="text-3xl sm:text-4xl font-black text-medical-400 mb-1 tracking-tight">{{ $stat->value }}</div>
                        <div class="text-xs sm:text-sm text-slate-300 font-medium">{{ $stat->title }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

<!-- ============================================================ -->
<!-- 3. ABOUT SECTION (Dynamic CMS)                               -->
<!-- ============================================================ -->
@if($aboutSection && $aboutSection->is_active)
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Images -->
                <div class="lg:col-span-6 relative">
                    <div class="relative">
                        <img src="{{ $aboutSection->image_url }}" alt="{{ $aboutSection->title }}" class="rounded-3xl shadow-xl border-4 border-white object-cover w-full h-[400px]">
                        @if($aboutSection->secondary_image)
                            <div class="hidden sm:block absolute -bottom-8 {{ app()->getLocale() === 'ar' ? '-left-6' : '-right-6' }} w-52 h-44 rounded-2xl overflow-hidden shadow-2xl border-4 border-white">
                                <img src="{{ $aboutSection->secondary_image_url }}" alt="Secondary" class="w-full h-full object-cover">
                            </div>
                        @endif
                        @if($aboutSection->experience_years)
                            <div class="absolute -top-4 {{ app()->getLocale() === 'ar' ? '-right-4' : '-left-4' }} bg-medical-600 text-white p-4 rounded-2xl shadow-xl flex items-center gap-3">
                                <span class="text-3xl font-black">{{ $aboutSection->experience_years }}+</span>
                                <span class="text-xs font-semibold max-w-[100px] leading-tight">{{ $aboutSection->experience_text }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Text -->
                <div class="lg:col-span-6 space-y-6">
                    @if($aboutSection->badge)
                        <span class="text-medical-600 font-bold text-xs uppercase tracking-wider block">{{ $aboutSection->badge }}</span>
                    @endif
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-navy-900 tracking-tight leading-snug">
                        {{ $aboutSection->title }}
                    </h2>
                    @if($aboutSection->subtitle)
                        <p class="text-medical-700 font-semibold text-sm">{{ $aboutSection->subtitle }}</p>
                    @endif
                    <p class="text-slate-600 text-sm leading-relaxed">
                        {{ $aboutSection->description }}
                    </p>

                    @if($aboutSection->mission || $aboutSection->vision)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                            @if($aboutSection->mission)
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                    <h4 class="text-xs font-bold text-navy-900 mb-1">{{ app()->getLocale() === 'ar' ? 'رسالتنا' : 'Our Mission' }}</h4>
                                    <p class="text-xs text-slate-500 leading-relaxed">{{ $aboutSection->mission }}</p>
                                </div>
                            @endif
                            @if($aboutSection->vision)
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                    <h4 class="text-xs font-bold text-navy-900 mb-1">{{ app()->getLocale() === 'ar' ? 'رؤيتنا' : 'Our Vision' }}</h4>
                                    <p class="text-xs text-slate-500 leading-relaxed">{{ $aboutSection->vision }}</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="pt-2">
                        <a href="{{ route('about') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-medical-600 hover:bg-medical-700 text-white font-bold text-xs shadow-md shadow-medical-600/20 transition">
                            <span>{{ app()->getLocale() === 'ar' ? 'المزيد عن العيادة' : 'Learn More About Us' }}</span>
                            <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

<!-- ============================================================ -->
<!-- 4. SERVICES CATALOG SECTION                                  -->
<!-- ============================================================ -->
<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-medical-600 font-bold text-xs uppercase tracking-wider block mb-2">{{ app()->getLocale() === 'ar' ? 'رعاية طبية متكاملة' : 'Specialized Care' }}</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'خدماتنا الطبية التخصصية' : 'Our Dental Services' }}</h2>
            <p class="text-slate-500 text-sm mt-3">{{ app()->getLocale() === 'ar' ? 'حلول علاجية وتجميلية متطورة تلبي احتياجاتك وأسرتك' : 'Comprehensive solutions from cosmetic whitening to advanced implants' }}</p>
        </div>

        @if($services->count() > 0)
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
                                <p class="text-slate-500 text-sm line-clamp-2 leading-relaxed mb-4">{{ $service->short_description }}</p>
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
        @else
            <div class="py-12 text-center text-slate-400 text-sm">
                {{ app()->getLocale() === 'ar' ? 'لا توجد خدمات مضافة حالياً.' : 'No dental services available at the moment.' }}
            </div>
        @endif
    </div>
</section>

<!-- ============================================================ -->
<!-- 5. WHY CHOOSE US (Dynamic CMS)                               -->
<!-- ============================================================ -->
@if($features->count() > 0)
    <section class="py-20 bg-gradient-to-br from-navy-950 via-navy-900 to-navy-950 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-medical-400 font-bold text-xs uppercase tracking-wider block mb-2">{{ app()->getLocale() === 'ar' ? 'لماذا تختارنا؟' : 'Why Choose Us' }}</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight leading-snug">
                    {{ app()->getLocale() === 'ar' ? 'معايير طبية متقدمة وراحة تدوم' : 'Exceptional Standards & Lasting Care' }}
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($features as $feat)
                    <div class="p-6 rounded-3xl bg-navy-900/60 border border-navy-800 hover:border-medical-500/40 transition duration-300 space-y-3">
                        <div class="w-12 h-12 rounded-2xl bg-medical-500/20 text-medical-400 flex items-center justify-center font-bold text-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <h4 class="text-lg font-bold text-white">{{ $feat->title }}</h4>
                        <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">{{ $feat->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

<!-- ============================================================ -->
<!-- 6. HOW IT WORKS (Dynamic CMS)                                -->
<!-- ============================================================ -->
@if($howItWorks->count() > 0)
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-medical-600 font-bold text-xs uppercase tracking-wider block mb-2">{{ app()->getLocale() === 'ar' ? 'تجربة حجز سلسة' : 'Simple 3-Step Flow' }}</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'كيف يعمل نظام الحجز؟' : 'How Online Booking Works' }}</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-{{ min(4, $howItWorks->count()) }} gap-8">
                @foreach($howItWorks as $step)
                    <div class="relative p-6 rounded-3xl bg-slate-50 border border-slate-100 text-center hover:shadow-lg transition">
                        <div class="w-14 h-14 mx-auto rounded-2xl bg-medical-600 text-white font-black text-xl flex items-center justify-center mb-4 shadow-md shadow-medical-600/30">
                            0{{ $step->step_number }}
                        </div>
                        <h3 class="text-lg font-bold text-navy-900 mb-2">{{ $step->title }}</h3>
                        <p class="text-slate-500 text-xs leading-relaxed">{{ $step->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

<!-- ============================================================ -->
<!-- 7. MEDICAL TEAM / DOCTORS                                    -->
<!-- ============================================================ -->
@if($doctors->count() > 0)
    <section class="py-20 bg-slate-50 border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-medical-600 font-bold text-xs uppercase tracking-wider block mb-2">{{ app()->getLocale() === 'ar' ? 'الطاقم الطبي' : 'Medical Staff' }}</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'نخبة أطباء واستشاريي الأسنان' : 'Meet Our Specialists' }}</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($doctors as $doctor)
                    <div class="bg-white rounded-3xl p-6 border border-slate-100 text-center hover:shadow-xl transition-all duration-300 group">
                        <div class="w-28 h-28 mx-auto rounded-full overflow-hidden mb-4 border-4 border-slate-50 shadow-md">
                            <img src="{{ $doctor->image_url }}" alt="{{ $doctor->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        </div>
                        <h3 class="text-lg font-bold text-navy-900 mb-1">{{ $doctor->name }}</h3>
                        <p class="text-xs font-semibold text-medical-600 mb-2">{{ $doctor->specialization }}</p>
                        <p class="text-slate-400 text-xs line-clamp-2 mb-4">{{ $doctor->bio }}</p>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
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
@endif

<!-- ============================================================ -->
<!-- 8. GALLERY / SMILE TRANSFORMATIONS (Dynamic CMS)             -->
<!-- ============================================================ -->
@if($galleryItems->count() > 0)
    <section class="py-20 bg-white border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-medical-600 font-bold text-xs uppercase tracking-wider block mb-2">{{ app()->getLocale() === 'ar' ? 'معرض الحالات' : 'Before & After' }}</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'تحولات الابتسامة ونتائج العلاج' : 'Smile Transformations' }}</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($galleryItems as $item)
                    <div class="rounded-3xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition group bg-slate-50">
                        <div class="h-56 overflow-hidden relative">
                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @if($item->category)
                                <span class="absolute top-4 {{ app()->getLocale() === 'ar' ? 'right-4' : 'left-4' }} bg-navy-900/80 backdrop-blur-md text-white text-[11px] font-bold px-3 py-1 rounded-full">
                                    {{ $item->category }}
                                </span>
                            @endif
                        </div>
                        <div class="p-4 text-center">
                            <h3 class="font-bold text-navy-900 text-sm">{{ $item->title }}</h3>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

<!-- ============================================================ -->
<!-- 9. REVIEWS / TESTIMONIALS                                    -->
<!-- ============================================================ -->
@if($reviews->count() > 0)
    <section class="py-20 bg-slate-50 border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-medical-600 font-bold text-xs uppercase tracking-wider block mb-2">{{ app()->getLocale() === 'ar' ? 'آراء المرضى' : 'Patient Reviews' }}</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'قصص نجاح وابتسامات راضية' : 'Real Patients, Real Smiles' }}</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($reviews as $review)
                    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex flex-col justify-between">
                        <div>
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
@endif

<!-- ============================================================ -->
<!-- 10. FAQS SECTION (Dynamic)                                   -->
<!-- ============================================================ -->
@if($faqs->count() > 0)
    <section class="py-20 bg-white border-t border-slate-100" x-data="{ openFaq: null }">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-medical-600 font-bold text-xs uppercase tracking-wider block mb-2">{{ app()->getLocale() === 'ar' ? 'إجابات واضحة' : 'Common Inquiries' }}</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'الأسئلة الشائعة حول العلاج والمواعيد' : 'Frequently Asked Questions' }}</h2>
            </div>

            <div class="space-y-4">
                @foreach($faqs as $idx => $faq)
                    <div class="border border-slate-200 rounded-2xl p-5 transition bg-white shadow-xs">
                        <button type="button" @click="openFaq = (openFaq === {{ $idx }} ? null : {{ $idx }})" class="w-full flex items-center justify-between text-start font-bold text-navy-900 text-sm gap-4">
                            <span>{{ $faq->question }}</span>
                            <span class="text-medical-600 text-lg transition-transform duration-300" :class="openFaq === {{ $idx }} ? 'rotate-180' : ''">&darr;</span>
                        </button>
                        <div x-show="openFaq === {{ $idx }}" x-cloak class="mt-3 text-xs sm:text-sm text-slate-500 leading-relaxed border-t border-slate-100 pt-3">
                            {{ $faq->answer }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

<!-- ============================================================ -->
<!-- 11. BLOG POSTS SECTION                                       -->
<!-- ============================================================ -->
@if($blogPosts->count() > 0)
    <section class="py-20 bg-slate-50 border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-medical-600 font-bold text-xs uppercase tracking-wider block mb-2">{{ app()->getLocale() === 'ar' ? 'المجلة الطبية' : 'Health Blog' }}</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'أحدث مقالات ونصائح العناية بالأسنان' : 'Articles & Dental Tips' }}</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($blogPosts as $post)
                    <article class="bg-white rounded-3xl overflow-hidden border border-slate-100 hover:shadow-xl transition-all duration-300 flex flex-col group">
                        <div class="h-44 overflow-hidden">
                            <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="text-xs text-medical-600 font-bold mb-2">{{ $post->published_at?->format('M d, Y') }}</div>
                                <h3 class="text-lg font-bold text-navy-900 mb-2 group-hover:text-medical-600 transition">{{ $post->title }}</h3>
                                <p class="text-slate-500 text-xs line-clamp-2 leading-relaxed">{{ $post->excerpt }}</p>
                            </div>
                            <div class="pt-4 border-t border-slate-100 mt-4">
                                <a href="{{ route('blog.show', $post->slug) }}" class="text-xs font-bold text-medical-600 hover:text-medical-700">
                                    {{ app()->getLocale() === 'ar' ? 'اقرأ المقال' : 'Read Article' }} &rarr;
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif

<!-- ============================================================ -->
<!-- 12. CALL TO ACTION (CTA CMS)                                 -->
<!-- ============================================================ -->
@if($ctaSection && $ctaSection->is_active)
    <section class="py-16 bg-gradient-to-r from-medical-600 to-medical-500 text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6 relative z-10">
            @if($ctaSection->badge)
                <span class="inline-block px-3 py-1 rounded-full bg-white/20 text-white text-xs font-bold">{{ $ctaSection->badge }}</span>
            @endif
            <h2 class="text-3xl sm:text-4xl font-extrabold">{{ $ctaSection->title }}</h2>
            <p class="text-medical-100 max-w-xl mx-auto text-sm sm:text-base leading-relaxed">{{ $ctaSection->description }}</p>
            <div class="pt-2 flex flex-wrap items-center justify-center gap-4">
                <a href="{{ $ctaSection->button_url }}" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-medical-700 hover:bg-slate-100 font-extrabold text-sm rounded-2xl shadow-xl transition">
                    <svg class="w-5 h-5 text-medical-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>{{ $ctaSection->button_text }}</span>
                </a>
                @if($ctaSection->phone)
                    <a href="tel:{{ preg_replace('/\s+/', '', $ctaSection->phone) }}" class="inline-flex items-center gap-2 px-6 py-4 bg-navy-950/40 hover:bg-navy-950/60 text-white font-bold text-sm rounded-2xl backdrop-blur-sm transition">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span dir="ltr">{{ $ctaSection->phone }}</span>
                    </a>
                @endif
            </div>
        </div>
    </section>
@endif

@endsection
