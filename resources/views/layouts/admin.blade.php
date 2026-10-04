<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') — {{ clinic_setting(app()->getLocale() === 'ar' ? 'clinic_name_ar' : 'clinic_name_en', config('app.name', 'DentCare')) }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen flex" x-data="{ sidebarOpen: false }">

    <!-- Mobile Backdrop -->
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-navy-950/60 backdrop-blur-sm lg:hidden"></div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : ( '{{ app()->getLocale() }}' === 'ar' ? 'translate-x-full lg:translate-x-0' : '-translate-x-full lg:translate-x-0' )"
           class="fixed inset-y-0 {{ app()->getLocale() === 'ar' ? 'right-0' : 'left-0' }} z-50 w-64 bg-navy-950 text-slate-300 flex flex-col transition-transform duration-300 ease-in-out border-{{ app()->getLocale() === 'ar' ? 'l' : 'r' }} border-navy-900 shadow-xl">
        
        <!-- Logo Header -->
        <div class="h-20 flex items-center px-6 gap-3 border-b border-navy-900/60 bg-navy-900/20">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-medical-600 to-medical-400 flex items-center justify-center text-white shadow-md shadow-medical-500/30">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18.8 4c-1.7-1.4-4-1.2-5.7.4-.6.6-1.6.6-2.2 0C9.2 2.8 6.9 2.6 5.2 4 2.8 6 2.2 9.5 3.3 12.3c.9 2.2 2.1 4.3 3.3 6.3 1.2 2.1 2.3 3.4 3.4 3.4.4 0 .9-.3 1.3-.9.9-1.3 1.4-2.8 1.7-4.4.1-.4.5-.7.9-.7s.8.3.9.7c.3 1.6.8 3.1 1.7 4.4.4.6.9.9 1.3.9 1.1 0 2.2-1.3 3.4-3.4 1.2-2 2.4-4.1 3.3-6.3 1.1-2.8.5-6.3-1.7-8.3z"/>
                </svg>
            </div>
            <div>
                <span class="text-xl font-extrabold text-white tracking-tight">{{ clinic_setting(app()->getLocale() === 'ar' ? 'clinic_name_ar' : 'clinic_name_en', config('app.name', 'DentCare')) }}</span>
                <span class="text-[10px] text-slate-400 font-bold block uppercase tracking-wider">{{ app()->getLocale() === 'ar' ? 'لوحة تحكم الإدارة' : 'Admin Console' }}</span>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 overflow-y-auto px-4 py-5 space-y-1 text-sm font-medium">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-medical-600 text-white font-bold shadow-md shadow-medical-600/30' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'الرئيسية والإحصائيات' : 'Dashboard' }}</span>
            </a>

            <div class="pt-4 pb-1 text-[11px] font-bold text-slate-500 uppercase tracking-wider px-3">{{ app()->getLocale() === 'ar' ? 'إدارة العيادة' : 'Clinic Core' }}</div>

            <a href="{{ route('admin.appointments.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.appointments.*') ? 'bg-medical-600 text-white font-bold shadow-md shadow-medical-600/30' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'المواعيد والحجوزات' : 'Appointments' }}</span>
            </a>

            <a href="{{ route('admin.doctors.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.doctors.*') ? 'bg-medical-600 text-white font-bold shadow-md shadow-medical-600/30' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'الأطباء والاستشاريون' : 'Doctors' }}</span>
            </a>

            <a href="{{ route('admin.patients.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.patients.*') ? 'bg-medical-600 text-white font-bold shadow-md shadow-medical-600/30' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'المرضى والمراجعين' : 'Patients' }}</span>
            </a>

            <a href="{{ route('admin.services.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.services.*') ? 'bg-medical-600 text-white font-bold shadow-md shadow-medical-600/30' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'الخدمات الطبية' : 'Dental Services' }}</span>
            </a>

            <a href="{{ route('admin.medical-records.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.medical-records.*') ? 'bg-medical-600 text-white font-bold shadow-md shadow-medical-600/30' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'السجلات الطبية' : 'Medical Records' }}</span>
            </a>

            <a href="{{ route('admin.reviews.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.reviews.*') ? 'bg-medical-600 text-white font-bold shadow-md shadow-medical-600/30' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'التقييمات والمراجعات' : 'Reviews' }}</span>
            </a>

            <div class="pt-4 pb-1 text-[11px] font-bold text-slate-500 uppercase tracking-wider px-3">{{ app()->getLocale() === 'ar' ? 'محتوى الموقع (CMS)' : 'Website CMS' }}</div>

            <a href="{{ route('admin.hero-banners.index') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl transition {{ request()->routeIs('admin.hero-banners.*') ? 'bg-medical-600 text-white font-bold shadow-md shadow-medical-600/30' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'بانرات الواجهة (Hero)' : 'Hero Banners' }}</span>
            </a>

            <a href="{{ route('admin.about-section.edit') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl transition {{ request()->routeIs('admin.about-section.*') ? 'bg-medical-600 text-white font-bold shadow-md shadow-medical-600/30' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'قسم من نحن (About)' : 'About Section' }}</span>
            </a>

            <a href="{{ route('admin.statistics.index') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl transition {{ request()->routeIs('admin.statistics.*') ? 'bg-medical-600 text-white font-bold shadow-md shadow-medical-600/30' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'إحصائيات العيادة' : 'Statistics' }}</span>
            </a>

            <a href="{{ route('admin.features.index') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl transition {{ request()->routeIs('admin.features.*') ? 'bg-medical-600 text-white font-bold shadow-md shadow-medical-600/30' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'لماذا تختارنا' : 'Why Choose Us' }}</span>
            </a>

            <a href="{{ route('admin.how-it-works.index') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl transition {{ request()->routeIs('admin.how-it-works.*') ? 'bg-medical-600 text-white font-bold shadow-md shadow-medical-600/30' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'كيف يعمل الحجز' : 'How It Works' }}</span>
            </a>

            <a href="{{ route('admin.cta-section.edit') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl transition {{ request()->routeIs('admin.cta-section.*') ? 'bg-medical-600 text-white font-bold shadow-md shadow-medical-600/30' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'قسم الحث (CTA)' : 'CTA Section' }}</span>
            </a>

            <div class="pt-4 pb-1 text-[11px] font-bold text-slate-500 uppercase tracking-wider px-3">{{ app()->getLocale() === 'ar' ? 'المدونة والمعرض' : 'Media & Content' }}</div>

            <a href="{{ route('admin.blog.index') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl transition {{ request()->routeIs('admin.blog.*') ? 'bg-medical-600 text-white font-bold shadow-md shadow-medical-600/30' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'المقالات والأخبار' : 'Articles & Blog' }}</span>
            </a>

            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl transition {{ request()->routeIs('admin.categories.*') ? 'bg-medical-600 text-white font-bold shadow-md shadow-medical-600/30' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'تصنيفات المقالات' : 'Categories' }}</span>
            </a>

            <a href="{{ route('admin.gallery.index') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl transition {{ request()->routeIs('admin.gallery.*') ? 'bg-medical-600 text-white font-bold shadow-md shadow-medical-600/30' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'معرض الحالات والصور' : 'Gallery' }}</span>
            </a>

            <a href="{{ route('admin.faqs.index') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl transition {{ request()->routeIs('admin.faqs.*') ? 'bg-medical-600 text-white font-bold shadow-md shadow-medical-600/30' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'الأسئلة الشائعة' : 'FAQs' }}</span>
            </a>

            <a href="{{ route('admin.contact-messages.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.contact-messages.*') ? 'bg-medical-600 text-white font-bold shadow-md shadow-medical-600/30' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span>{{ app()->getLocale() === 'ar' ? 'رسائل التواصل' : 'Messages' }}</span>
                </div>
                @php $unreadCount = \App\Models\ContactMessage::where('status', 'unread')->count(); @endphp
                @if($unreadCount > 0)
                    <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-rose-500 text-white">{{ $unreadCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.settings.*') ? 'bg-medical-600 text-white font-bold shadow-md shadow-medical-600/30' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'إعدادات العيادة' : 'Clinic Settings' }}</span>
            </a>
        </nav>

        <!-- Current User Profile & Logout -->
        <div class="p-4 border-t border-navy-900 bg-navy-900/40 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="w-9 h-9 rounded-full object-cover border border-slate-700">
                <div class="overflow-hidden">
                    <span class="block text-xs font-bold text-white truncate">{{ auth()->user()->name }}</span>
                    <span class="block text-[11px] text-medical-400 font-semibold">{{ app()->getLocale() === 'ar' ? 'المدير العام' : 'System Admin' }}</span>
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
                <h1 class="text-xl font-bold text-navy-900">@yield('page_title', 'Dashboard')</h1>
            </div>

            <div class="flex items-center gap-3 sm:gap-4">
                <!-- Live Site Link -->
                <a href="{{ route('home') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-medical-600 bg-slate-100 hover:bg-medical-50 px-3 py-1.5 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span>{{ app()->getLocale() === 'ar' ? 'عرض الموقع' : 'View Public Site' }}</span>
                </a>

                <!-- Language Switch -->
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

            @if($errors->any())
                <div class="mb-4 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 shadow-sm">
                    <ul class="list-disc list-inside text-xs space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Main Body -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
