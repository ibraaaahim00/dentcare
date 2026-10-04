<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Doctor Portal') — DentCare</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: '{{ app()->getLocale() === "ar" ? "Cairo" : "Plus Jakarta Sans" }}', sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen flex" x-data="{ sidebarOpen: false }">

    <!-- Mobile Backdrop -->
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-navy-950/60 backdrop-blur-sm lg:hidden"></div>

    <!-- Doctor Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : ( '{{ app()->getLocale() }}' === 'ar' ? 'translate-x-full lg:translate-x-0' : '-translate-x-full lg:translate-x-0' )"
           class="fixed inset-y-0 {{ app()->getLocale() === 'ar' ? 'right-0' : 'left-0' }} z-50 w-64 bg-navy-950 text-slate-300 flex flex-col transition-transform duration-300 ease-in-out border-{{ app()->getLocale() === 'ar' ? 'l' : 'r' }} border-navy-900 shadow-xl">
        
        <div class="h-20 flex items-center px-6 gap-3 border-b border-navy-900/60 bg-navy-900/20">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-medical-600 to-medical-400 flex items-center justify-center text-white shadow-md shadow-medical-500/30">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18.8 4c-1.7-1.4-4-1.2-5.7.4-.6.6-1.6.6-2.2 0C9.2 2.8 6.9 2.6 5.2 4 2.8 6 2.2 9.5 3.3 12.3c.9 2.2 2.1 4.3 3.3 6.3 1.2 2.1 2.3 3.4 3.4 3.4.4 0 .9-.3 1.3-.9.9-1.3 1.4-2.8 1.7-4.4.1-.4.5-.7.9-.7s.8.3.9.7c.3 1.6.8 3.1 1.7 4.4.4.6.9.9 1.3.9 1.1 0 2.2-1.3 3.4-3.4 1.2-2 2.4-4.1 3.3-6.3 1.1-2.8.5-6.3-1.7-8.3z"/>
                </svg>
            </div>
            <div>
                <span class="text-xl font-extrabold text-white tracking-tight">Dent<span class="text-medical-400">Care</span></span>
                <span class="text-[10px] text-medical-300 font-bold block uppercase tracking-wider">{{ app()->getLocale() === 'ar' ? 'بوابة الطبيب' : 'Doctor Portal' }}</span>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto px-4 py-5 space-y-1 text-sm font-medium">
            <a href="{{ route('doctor.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('doctor.dashboard') ? 'bg-medical-600 text-white font-bold shadow-md shadow-medical-600/30' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'لوحة المتابعة' : 'Dashboard' }}</span>
            </a>

            <a href="{{ route('doctor.appointments.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('doctor.appointments.*') ? 'bg-medical-600 text-white font-bold shadow-md shadow-medical-600/30' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'مواعيدي' : 'My Appointments' }}</span>
            </a>

            <a href="{{ route('doctor.patients.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('doctor.patients.*') ? 'bg-medical-600 text-white font-bold shadow-md shadow-medical-600/30' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'سجل مرضاي' : 'My Patients' }}</span>
            </a>

            <a href="{{ route('doctor.profile.edit') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('doctor.profile.*') ? 'bg-medical-600 text-white font-bold shadow-md shadow-medical-600/30' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'الملف الطبي والشخصي' : 'Doctor Profile' }}</span>
            </a>
        </nav>

        <div class="p-4 border-t border-navy-900 bg-navy-900/40 flex items-center justify-between">
            <div class="flex items-center gap-3 overflow-hidden">
                <img src="{{ auth()->user()->doctor?->image_url ?? auth()->user()->avatar_url }}" alt="Avatar" class="w-9 h-9 rounded-full object-cover border border-slate-700">
                <div class="overflow-hidden">
                    <span class="block text-xs font-bold text-white truncate">{{ auth()->user()->name }}</span>
                    <span class="block text-[11px] text-medical-400 font-medium truncate">{{ auth()->user()->doctor?->specialization ?? 'Doctor' }}</span>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="p-2 text-slate-400 hover:text-rose-400 hover:bg-navy-900 rounded-lg transition" title="{{ __('app.logout') }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 {{ app()->getLocale() === 'ar' ? 'lg:mr-64' : 'lg:ml-64' }}">
        
        <!-- Topbar -->
        <header class="h-20 bg-white border-b border-slate-200 sticky top-0 z-30 flex items-center justify-between px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen" type="button" class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="text-xl font-bold text-navy-900">@yield('page_title', 'Doctor Portal')</h1>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-medical-600 bg-slate-100 hover:bg-medical-50 px-3 py-1.5 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span>{{ app()->getLocale() === 'ar' ? 'الموقع العام' : 'Public Site' }}</span>
                </a>

                @if(app()->getLocale() === 'ar')
                    <a href="{{ route('locale.switch', 'en') }}" class="text-xs font-bold px-3 py-1.5 bg-slate-100 hover:bg-slate-200 rounded-lg text-slate-700 transition">English</a>
                @else
                    <a href="{{ route('locale.switch', 'ar') }}" class="text-xs font-bold px-3 py-1.5 bg-slate-100 hover:bg-slate-200 rounded-lg text-slate-700 transition">العربية</a>
                @endif
            </div>
        </header>

        <!-- Flash Messages -->
        <div class="px-4 sm:px-6 lg:px-8 mt-6 w-full">
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

        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
