<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'DentCare')) — {{ __('app.clinic_name') }}</title>
    <meta name="description" content="@yield('meta_description', __('app.tagline'))">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (Tailwind Play CDN for zero build failures and maximum compatibility) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        medical: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        navy: {
                            800: '#1e293b',
                            900: '#0f172a',
                            950: '#020617',
                        }
                    },
                    fontFamily: {
                        sans: ['{{ app()->getLocale() === "ar" ? "Cairo" : "Plus Jakarta Sans" }}', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body {
            font-family: '{{ app()->getLocale() === "ar" ? "Cairo" : "Plus Jakarta Sans" }}', sans-serif;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col selection:bg-medical-500 selection:text-white">

    <!-- Top Announcement Bar -->
    <div class="bg-navy-900 text-slate-300 text-xs py-2 px-4 border-b border-navy-800">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center gap-2">
            <div class="flex items-center gap-4">
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-medical-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span dir="ltr">+966 12 345 6789</span>
                </span>
                <span class="hidden sm:flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-medical-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ app()->getLocale() === 'ar' ? 'السبت - الخميس: 9:00 ص - 9:00 م' : 'Sat - Thu: 9:00 AM - 9:00 PM' }}</span>
                </span>
            </div>
            <div class="flex items-center gap-3">
                <!-- Language Switcher -->
                @if(app()->getLocale() === 'ar')
                    <a href="{{ route('locale.switch', 'en') }}" class="hover:text-white font-medium flex items-center gap-1 transition">
                        <span>English</span>
                        <span class="text-slate-500">|</span>
                        <span class="text-medical-400 font-bold">العربية</span>
                    </a>
                @else
                    <a href="{{ route('locale.switch', 'ar') }}" class="hover:text-white font-medium flex items-center gap-1 transition">
                        <span class="text-medical-400 font-bold">English</span>
                        <span class="text-slate-500">|</span>
                        <span>العربية</span>
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="bg-white/95 backdrop-blur-md sticky top-0 z-50 shadow-sm border-b border-slate-100" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Clinic Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-medical-600 to-medical-400 flex items-center justify-center text-white shadow-md shadow-medical-500/20 group-hover:scale-105 transition duration-300">
                        <!-- Tooth Icon -->
                        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18.8 4c-1.7-1.4-4-1.2-5.7.4-.6.6-1.6.6-2.2 0C9.2 2.8 6.9 2.6 5.2 4 2.8 6 2.2 9.5 3.3 12.3c.9 2.2 2.1 4.3 3.3 6.3 1.2 2.1 2.3 3.4 3.4 3.4.4 0 .9-.3 1.3-.9.9-1.3 1.4-2.8 1.7-4.4.1-.4.5-.7.9-.7s.8.3.9.7c.3 1.6.8 3.1 1.7 4.4.4.6.9.9 1.3.9 1.1 0 2.2-1.3 3.4-3.4 1.2-2 2.4-4.1 3.3-6.3 1.1-2.8.5-6.3-1.7-8.3z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-2xl font-extrabold text-navy-900 tracking-tight block">Dent<span class="text-medical-600">Care</span></span>
                        <span class="text-[11px] text-slate-400 block -mt-1 font-medium">{{ app()->getLocale() === 'ar' ? 'عيادة طب وتجميل الأسنان' : 'Dental & Aesthetic Clinic' }}</span>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden md:flex items-center gap-1 lg:gap-2">
                    <a href="{{ route('home') }}" class="px-3.5 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('home') ? 'text-medical-600 bg-medical-50' : 'text-slate-600 hover:text-medical-600 hover:bg-slate-50' }} transition">
                        {{ __('app.home') }}
                    </a>
                    <a href="{{ route('about') }}" class="px-3.5 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('about') ? 'text-medical-600 bg-medical-50' : 'text-slate-600 hover:text-medical-600 hover:bg-slate-50' }} transition">
                        {{ __('app.about') }}
                    </a>
                    <a href="{{ route('services.index') }}" class="px-3.5 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('services.*') ? 'text-medical-600 bg-medical-50' : 'text-slate-600 hover:text-medical-600 hover:bg-slate-50' }} transition">
                        {{ __('app.services') }}
                    </a>
                    <a href="{{ route('doctors.index') }}" class="px-3.5 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('doctors.*') ? 'text-medical-600 bg-medical-50' : 'text-slate-600 hover:text-medical-600 hover:bg-slate-50' }} transition">
                        {{ __('app.doctors') }}
                    </a>
                    <a href="{{ route('blog.index') }}" class="px-3.5 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('blog.*') ? 'text-medical-600 bg-medical-50' : 'text-slate-600 hover:text-medical-600 hover:bg-slate-50' }} transition">
                        {{ __('app.blog') }}
                    </a>
                    <a href="{{ route('gallery') }}" class="px-3.5 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('gallery') ? 'text-medical-600 bg-medical-50' : 'text-slate-600 hover:text-medical-600 hover:bg-slate-50' }} transition">
                        {{ __('app.gallery') }}
                    </a>
                    <a href="{{ route('contact') }}" class="px-3.5 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('contact') ? 'text-medical-600 bg-medical-50' : 'text-slate-600 hover:text-medical-600 hover:bg-slate-50' }} transition">
                        {{ __('app.contact') }}
                    </a>
                </nav>

                <!-- Actions: Auth + Book CTA -->
                <div class="hidden lg:flex items-center gap-3">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-sm font-semibold text-white bg-navy-900 hover:bg-navy-800 rounded-xl transition shadow-sm">
                                {{ __('app.dashboard') }}
                            </a>
                        @elseif(auth()->user()->isDoctor())
                            <a href="{{ route('doctor.dashboard') }}" class="px-4 py-2 text-sm font-semibold text-white bg-navy-900 hover:bg-navy-800 rounded-xl transition shadow-sm">
                                {{ __('app.dashboard') }}
                            </a>
                        @else
                            <a href="{{ route('patient.dashboard') }}" class="px-4 py-2 text-sm font-semibold text-white bg-navy-900 hover:bg-navy-800 rounded-xl transition shadow-sm">
                                {{ __('app.dashboard') }}
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition" title="{{ __('app.logout') }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-medical-600 px-3 py-2 transition">
                            {{ __('app.login') }}
                        </a>
                    @endauth

                    <a href="{{ route('appointments.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-medical-600 to-medical-500 hover:from-medical-700 hover:to-medical-600 text-white font-bold text-sm shadow-md shadow-medical-500/25 hover:shadow-lg hover:shadow-medical-500/35 transition duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>{{ __('app.appointments') }}</span>
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex md:hidden items-center gap-2">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="p-2 rounded-xl text-slate-600 hover:bg-slate-100 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                            <path x-show="mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu Dropdown -->
        <div x-show="mobileMenuOpen" x-cloak class="md:hidden border-t border-slate-100 bg-white px-4 pt-3 pb-6 space-y-1 shadow-xl">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-medical-50 hover:text-medical-600">{{ __('app.home') }}</a>
            <a href="{{ route('about') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-medical-50 hover:text-medical-600">{{ __('app.about') }}</a>
            <a href="{{ route('services.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-medical-50 hover:text-medical-600">{{ __('app.services') }}</a>
            <a href="{{ route('doctors.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-medical-50 hover:text-medical-600">{{ __('app.doctors') }}</a>
            <a href="{{ route('blog.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-medical-50 hover:text-medical-600">{{ __('app.blog') }}</a>
            <a href="{{ route('gallery') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-medical-50 hover:text-medical-600">{{ __('app.gallery') }}</a>
            <a href="{{ route('faq') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-medical-50 hover:text-medical-600">{{ __('app.faq') }}</a>
            <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-medical-50 hover:text-medical-600">{{ __('app.contact') }}</a>
            <div class="pt-4 border-t border-slate-100 space-y-2">
                @auth
                    <a href="{{ route('patient.dashboard') }}" class="block w-full text-center px-4 py-2.5 bg-navy-900 text-white rounded-xl font-bold">{{ __('app.dashboard') }}</a>
                @else
                    <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2.5 border border-slate-200 text-slate-700 rounded-xl font-semibold">{{ __('app.login') }}</a>
                @endauth
                <a href="{{ route('appointments.create') }}" class="block w-full text-center px-4 py-2.5 bg-medical-600 text-white rounded-xl font-bold">{{ __('app.appointments') }}</a>
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="mb-4 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="font-medium text-sm">{{ session('success') }}</p>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </div>
                    <p class="font-medium text-sm">{{ session('error') }}</p>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">&times;</button>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 shadow-sm">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm mb-1">{{ app()->getLocale() === 'ar' ? 'يرجى مراجعة الأخطاء التالية:' : 'Please correct the following errors:' }}</h4>
                        <ul class="list-disc list-inside text-xs space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Main Content Slot -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Clinic Footer -->
    <footer class="bg-navy-950 text-slate-300 pt-16 pb-12 border-t border-navy-900 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
                <!-- Brand Info -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-medical-500 flex items-center justify-center text-white">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18.8 4c-1.7-1.4-4-1.2-5.7.4-.6.6-1.6.6-2.2 0C9.2 2.8 6.9 2.6 5.2 4 2.8 6 2.2 9.5 3.3 12.3c.9 2.2 2.1 4.3 3.3 6.3 1.2 2.1 2.3 3.4 3.4 3.4.4 0 .9-.3 1.3-.9.9-1.3 1.4-2.8 1.7-4.4.1-.4.5-.7.9-.7s.8.3.9.7c.3 1.6.8 3.1 1.7 4.4.4.6.9.9 1.3.9 1.1 0 2.2-1.3 3.4-3.4 1.2-2 2.4-4.1 3.3-6.3 1.1-2.8.5-6.3-1.7-8.3z"/>
                            </svg>
                        </div>
                        <span class="text-2xl font-extrabold text-white tracking-tight">Dent<span class="text-medical-400">Care</span></span>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        {{ app()->getLocale() === 'ar' ? 'عيادة أسنان متكاملة تقدم أحدث تقنيات طب وتجميل وزراعة الأسنان، لضمان صحة وجمال ابتسامتك في بيئة آمنة ومريحة.' : 'A premier dental clinic offering state-of-the-art restorative, aesthetic, and implant dentistry for your healthiest, brightest smile.' }}
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-white font-bold text-base mb-4">{{ app()->getLocale() === 'ar' ? 'روابط سريعة' : 'Quick Links' }}</h3>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('about') }}" class="hover:text-medical-400 transition">{{ __('app.about') }}</a></li>
                        <li><a href="{{ route('services.index') }}" class="hover:text-medical-400 transition">{{ __('app.services') }}</a></li>
                        <li><a href="{{ route('doctors.index') }}" class="hover:text-medical-400 transition">{{ __('app.doctors') }}</a></li>
                        <li><a href="{{ route('appointments.create') }}" class="hover:text-medical-400 transition">{{ __('app.appointments') }}</a></li>
                        <li><a href="{{ route('blog.index') }}" class="hover:text-medical-400 transition">{{ __('app.blog') }}</a></li>
                        <li><a href="{{ route('faq') }}" class="hover:text-medical-400 transition">{{ __('app.faq') }}</a></li>
                    </ul>
                </div>

                <!-- Working Hours -->
                <div>
                    <h3 class="text-white font-bold text-base mb-4">{{ __('app.working_hours') }}</h3>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li class="flex justify-between py-1 border-b border-navy-900">
                            <span>{{ app()->getLocale() === 'ar' ? 'السبت - الخميس' : 'Sat - Thu' }}</span>
                            <span class="font-semibold text-slate-200" dir="ltr">09:00 AM - 09:00 PM</span>
                        </li>
                        <li class="flex justify-between py-1 border-b border-navy-900">
                            <span>{{ app()->getLocale() === 'ar' ? 'الجمعة' : 'Friday' }}</span>
                            <span class="text-rose-400 font-semibold">{{ app()->getLocale() === 'ar' ? 'مغلق (طوارئ فقط)' : 'Closed (Emergency Only)' }}</span>
                        </li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-white font-bold text-base mb-4">{{ __('app.contact') }}</h3>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-medical-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>{{ app()->getLocale() === 'ar' ? 'طريق الملك فهد، الرياض، المملكة العربية السعودية' : 'King Fahd Road, Riyadh, Saudi Arabia' }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-medical-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span dir="ltr">+966 12 345 6789</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-medical-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>info@dentcare-clinic.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-navy-900 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} DentCare Clinic. {{ __('app.all_rights_reserved') }}</p>
                <div class="flex items-center gap-4">
                    <a href="{{ route('privacy') }}" class="hover:text-slate-400 transition">{{ app()->getLocale() === 'ar' ? 'سياسة الخصوصية' : 'Privacy Policy' }}</a>
                    <span>•</span>
                    <a href="{{ route('terms') }}" class="hover:text-slate-400 transition">{{ app()->getLocale() === 'ar' ? 'الشروط والأحكام' : 'Terms & Conditions' }}</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
