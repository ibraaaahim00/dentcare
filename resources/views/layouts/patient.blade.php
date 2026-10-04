<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Patient Portal') — DentCare</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: '{{ app()->getLocale() === "ar" ? "Cairo" : "Plus Jakarta Sans" }}', sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Header Navbar -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-6">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-medical-600 to-medical-400 flex items-center justify-center text-white shadow-md shadow-medical-500/30">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18.8 4c-1.7-1.4-4-1.2-5.7.4-.6.6-1.6.6-2.2 0C9.2 2.8 6.9 2.6 5.2 4 2.8 6 2.2 9.5 3.3 12.3c.9 2.2 2.1 4.3 3.3 6.3 1.2 2.1 2.3 3.4 3.4 3.4.4 0 .9-.3 1.3-.9.9-1.3 1.4-2.8 1.7-4.4.1-.4.5-.7.9-.7s.8.3.9.7c.3 1.6.8 3.1 1.7 4.4.4.6.9.9 1.3.9 1.1 0 2.2-1.3 3.4-3.4 1.2-2 2.4-4.1 3.3-6.3 1.1-2.8.5-6.3-1.7-8.3z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-xl font-extrabold text-navy-900 tracking-tight">Dent<span class="text-medical-600">Care</span></span>
                            <span class="text-[10px] text-slate-400 font-bold block uppercase tracking-wider">{{ app()->getLocale() === 'ar' ? 'بوابة المريض' : 'Patient Portal' }}</span>
                        </div>
                    </a>

                    <!-- Nav Links -->
                    <nav class="hidden md:flex items-center gap-1">
                        <a href="{{ route('patient.dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('patient.dashboard') ? 'text-medical-600 bg-medical-50' : 'text-slate-600 hover:text-medical-600 hover:bg-slate-50' }}">
                            {{ app()->getLocale() === 'ar' ? 'نظرة عامة' : 'Dashboard' }}
                        </a>
                        <a href="{{ route('patient.appointments.index') }}" class="px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('patient.appointments.*') ? 'text-medical-600 bg-medical-50' : 'text-slate-600 hover:text-medical-600 hover:bg-slate-50' }}">
                            {{ app()->getLocale() === 'ar' ? 'مواعيدي' : 'Appointments' }}
                        </a>
                        <a href="{{ route('patient.medical-records.index') }}" class="px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('patient.medical-records.*') ? 'text-medical-600 bg-medical-50' : 'text-slate-600 hover:text-medical-600 hover:bg-slate-50' }}">
                            {{ app()->getLocale() === 'ar' ? 'سجلاتي الطبية' : 'Medical Records' }}
                        </a>
                        <a href="{{ route('patient.profile.edit') }}" class="px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('patient.profile.*') ? 'text-medical-600 bg-medical-50' : 'text-slate-600 hover:text-medical-600 hover:bg-slate-50' }}">
                            {{ app()->getLocale() === 'ar' ? 'بياناتي' : 'Profile' }}
                        </a>
                    </nav>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('appointments.create') }}" class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2 bg-medical-600 hover:bg-medical-700 text-white font-bold text-xs rounded-xl shadow-md shadow-medical-600/25 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>{{ app()->getLocale() === 'ar' ? 'حجز موعد جديد' : 'New Appointment' }}</span>
                    </a>

                    <!-- Notifications Badge -->
                    <a href="{{ route('patient.notifications.index') }}" class="p-2 text-slate-500 hover:text-medical-600 hover:bg-slate-100 rounded-xl relative transition" title="Notifications">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        @php $unreadNotifs = auth()->user()->unreadNotifications->count(); @endphp
                        @if($unreadNotifs > 0)
                            <span class="absolute top-1.5 {{ app()->getLocale() === 'ar' ? 'left-1.5' : 'right-1.5' }} w-2 h-2 rounded-full bg-rose-500"></span>
                        @endif
                    </a>

                    <!-- Language Switch -->
                    @if(app()->getLocale() === 'ar')
                        <a href="{{ route('locale.switch', 'en') }}" class="text-xs font-bold px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 rounded-lg text-slate-700 transition">EN</a>
                    @else
                        <a href="{{ route('locale.switch', 'ar') }}" class="text-xs font-bold px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 rounded-lg text-slate-700 transition">عربي</a>
                    @endif

                    <div class="flex items-center gap-2 border-{{ app()->getLocale() === 'ar' ? 'r' : 'l' }} border-slate-200 {{ app()->getLocale() === 'ar' ? 'pr-3 mr-1' : 'pl-3 ml-1' }}">
                        <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover">
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition" title="{{ __('app.logout') }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Nav Bar Tabs -->
    <div class="md:hidden bg-white border-b border-slate-200 flex justify-around py-2 px-1 text-xs font-semibold text-slate-600">
        <a href="{{ route('patient.dashboard') }}" class="py-1 px-2 rounded {{ request()->routeIs('patient.dashboard') ? 'text-medical-600 font-bold' : '' }}">{{ app()->getLocale() === 'ar' ? 'الرئيسية' : 'Home' }}</a>
        <a href="{{ route('patient.appointments.index') }}" class="py-1 px-2 rounded {{ request()->routeIs('patient.appointments.*') ? 'text-medical-600 font-bold' : '' }}">{{ app()->getLocale() === 'ar' ? 'المواعيد' : 'Appointments' }}</a>
        <a href="{{ route('patient.medical-records.index') }}" class="py-1 px-2 rounded {{ request()->routeIs('patient.medical-records.*') ? 'text-medical-600 font-bold' : '' }}">{{ app()->getLocale() === 'ar' ? 'السجلات' : 'Records' }}</a>
        <a href="{{ route('patient.profile.edit') }}" class="py-1 px-2 rounded {{ request()->routeIs('patient.profile.*') ? 'text-medical-600 font-bold' : '' }}">{{ app()->getLocale() === 'ar' ? 'الملف' : 'Profile' }}</a>
    </div>

    <!-- Flash Alerts -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 w-full">
        @if(session('success'))
            <div class="mb-4 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <p class="font-medium text-sm">{{ session('success') }}</p>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    <p class="font-medium text-sm">{{ session('error') }}</p>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">&times;</button>
            </div>
        @endif
    </div>

    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-500 mt-auto">
        &copy; {{ date('Y') }} DentCare Dental Clinic. All Rights Reserved.
    </footer>

    @stack('scripts')
</body>
</html>
