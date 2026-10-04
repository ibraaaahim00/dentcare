@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'لوحة التحكم الرئيسية' : 'Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Top Welcome Banner -->
    <div class="bg-gradient-to-r from-medical-700 via-medical-600 to-navy-900 rounded-3xl p-6 lg:p-8 text-white shadow-xl shadow-medical-900/10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
        <div class="space-y-2 relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-xs font-semibold text-medical-200">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
            </div>
            <h1 class="text-2xl lg:text-3xl font-extrabold tracking-tight">
                {{ app()->getLocale() === 'ar' ? 'مرحباً بك، دكتور' : 'Welcome back,' }} {{ auth()->user()->name }} 👋
            </h1>
            <p class="text-sm text-medical-100 max-w-xl">
                {{ app()->getLocale() === 'ar' ? 'إليك نظرة عامة على أداء عيادة DentCare والمواعيد المجدولة لليوم والمرضى الجدد.' : 'Here is an overview of DentCare clinic performance, today\'s appointments, and patients.' }}
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-3 relative z-10">
            <a href="{{ route('admin.appointments.index') }}" class="px-5 py-2.5 rounded-xl bg-white text-navy-900 hover:bg-slate-100 font-bold text-sm shadow transition flex items-center gap-2">
                <svg class="w-4 h-4 text-medical-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'إدارة المواعيد' : 'Appointments' }}</span>
            </a>
            <a href="{{ route('admin.doctors.create') }}" class="px-5 py-2.5 rounded-xl bg-medical-500 hover:bg-medical-400 text-white font-bold text-sm shadow transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'إضافة طبيب' : 'Add Doctor' }}</span>
            </a>
        </div>
    </div>

    <!-- Metrics Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Today Appointments -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">{{ app()->getLocale() === 'ar' ? 'مواعيد اليوم' : 'Today Appointments' }}</p>
                    <h3 class="text-3xl font-extrabold text-navy-900 mt-2">{{ $stats['today_appointments'] }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-medical-50 text-medical-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-xs">
                <span class="inline-flex items-center gap-1 font-semibold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full">
                    {{ $stats['pending_appointments'] }} {{ app()->getLocale() === 'ar' ? 'بانتظار التأكيد' : 'pending' }}
                </span>
            </div>
        </div>

        <!-- Total Patients -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">{{ app()->getLocale() === 'ar' ? 'إجمالي المرضى' : 'Total Patients' }}</p>
                    <h3 class="text-3xl font-extrabold text-navy-900 mt-2">{{ $stats['total_patients'] }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-xs text-slate-500">
                <span>{{ app()->getLocale() === 'ar' ? 'ملفات مسجلة في المنظومة' : 'Registered patient profiles' }}</span>
            </div>
        </div>

        <!-- Total Doctors & Services -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">{{ app()->getLocale() === 'ar' ? 'الكادر الطبي والخدمات' : 'Medical Staff & Services' }}</p>
                    <h3 class="text-3xl font-extrabold text-navy-900 mt-2">{{ $stats['total_doctors'] }} <span class="text-sm font-semibold text-slate-400">/ {{ $stats['total_services'] }} {{ app()->getLocale() === 'ar' ? 'خدمة' : 'svcs' }}</span></h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-xs text-slate-500">
                <span>{{ app()->getLocale() === 'ar' ? 'أطباء معتمدون واستشاريون' : 'Active practicing specialists' }}</span>
            </div>
        </div>

        <!-- Total Reviews & Pending Messages -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">{{ app()->getLocale() === 'ar' ? 'تقييمات المرضى والرسائل' : 'Reviews & Inquiries' }}</p>
                    <h3 class="text-3xl font-extrabold text-navy-900 mt-2">{{ $stats['total_reviews'] }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-xs">
                @if($stats['unread_messages'] > 0)
                    <span class="inline-flex items-center gap-1 font-semibold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-full">
                        {{ $stats['unread_messages'] }} {{ app()->getLocale() === 'ar' ? 'رسالة غير مقروءة' : 'unread' }}
                    </span>
                @else
                    <span class="text-slate-500">{{ app()->getLocale() === 'ar' ? 'جميع الرسائل مقروءة' : 'All messages read' }}</span>
                @endif
            </div>
        </div>
    </div>

    <!-- 7-Day Appointments Visual Breakdown & Today's Schedule -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- 7-Day Chart Activity (Pure CSS / Responsive Bar Visualization) -->
        <div class="lg:col-span-1 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-bold text-navy-900">{{ app()->getLocale() === 'ar' ? 'نشاط المواعيد (آخر 7 أيام)' : '7-Day Booking Trends' }}</h2>
                    <span class="text-xs font-semibold text-slate-400">{{ app()->getLocale() === 'ar' ? 'حسب التاريخ' : 'Daily Count' }}</span>
                </div>
                <p class="text-xs text-slate-500 mb-6">
                    {{ app()->getLocale() === 'ar' ? 'معدل الحجوزات اليومية المؤكدة والمجدولة في العيادة.' : 'Daily volume of incoming and confirmed patient bookings.' }}
                </p>

                <!-- Bar Graph Bars -->
                <div class="h-44 flex items-end justify-between gap-2 pt-6 pb-2 border-b border-slate-100">
                    @php
                        $maxVal = max(array_merge($chartCounts, [1]));
                    @endphp
                    @foreach($chartCounts as $index => $count)
                        @php
                            $heightPercent = max(8, round(($count / $maxVal) * 100));
                        @endphp
                        <div class="flex-1 flex flex-col items-center gap-2 group relative">
                            <span class="text-[10px] font-bold text-slate-500 opacity-0 group-hover:opacity-100 transition absolute -top-5">{{ $count }}</span>
                            <div class="w-full bg-medical-100 rounded-t-lg group-hover:bg-medical-500 transition-all duration-300" style="height: {{ $heightPercent }}%;"></div>
                            <span class="text-[10px] font-medium text-slate-400 truncate">{{ $chartDates[$index] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Quick Status Summary -->
            <div class="grid grid-cols-3 gap-2 pt-4 text-center">
                <div class="p-2.5 rounded-xl bg-slate-50">
                    <span class="block text-[11px] text-slate-400 font-semibold">{{ app()->getLocale() === 'ar' ? 'مكتملة' : 'Done' }}</span>
                    <span class="text-sm font-extrabold text-emerald-600">{{ $stats['completed_appointments'] }}</span>
                </div>
                <div class="p-2.5 rounded-xl bg-slate-50">
                    <span class="block text-[11px] text-slate-400 font-semibold">{{ app()->getLocale() === 'ar' ? 'قيد الانتظار' : 'Pending' }}</span>
                    <span class="text-sm font-extrabold text-amber-600">{{ $stats['pending_appointments'] }}</span>
                </div>
                <div class="p-2.5 rounded-xl bg-slate-50">
                    <span class="block text-[11px] text-slate-400 font-semibold">{{ app()->getLocale() === 'ar' ? 'ملغاة' : 'Cancelled' }}</span>
                    <span class="text-sm font-extrabold text-rose-600">{{ $stats['cancelled_appointments'] }}</span>
                </div>
            </div>
        </div>

        <!-- Today's Scheduled Appointments -->
        <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-base font-bold text-navy-900">{{ app()->getLocale() === 'ar' ? 'جدول مواعيد اليوم' : 'Today\'s Schedule' }}</h2>
                        <span class="text-xs text-slate-400">{{ $todayAppointmentsList->count() }} {{ app()->getLocale() === 'ar' ? 'مواعيد مسجلة اليوم' : 'appointments listed today' }}</span>
                    </div>
                    <a href="{{ route('admin.appointments.index') }}" class="text-xs font-bold text-medical-600 hover:text-medical-700">
                        {{ app()->getLocale() === 'ar' ? 'عرض الكل' : 'View all' }} &rarr;
                    </a>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($todayAppointmentsList as $appItem)
                        <div class="py-3.5 flex items-center justify-between gap-4 hover:bg-slate-50/50 rounded-xl px-2 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-medical-50 text-medical-700 flex flex-col items-center justify-center font-bold shrink-0">
                                    <span class="text-xs leading-none">{{ \Carbon\Carbon::parse($appItem->start_time)->format('h:i') }}</span>
                                    <span class="text-[9px] uppercase text-medical-500">{{ \Carbon\Carbon::parse($appItem->start_time)->format('A') }}</span>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-navy-900">{{ $appItem->patient->name }}</h4>
                                    <p class="text-xs text-slate-400">
                                        {{ app()->getLocale() === 'ar' ? $appItem->service->name_ar : $appItem->service->name_en }} &bull; {{ $appItem->doctor->user->name }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="px-2.5 py-1 text-xs font-bold rounded-full {{ $appItem->status->badgeClass() }}">
                                    {{ $appItem->status->label() }}
                                </span>
                                <a href="{{ route('admin.appointments.show', $appItem->id) }}" class="p-2 rounded-lg text-slate-400 hover:text-medical-600 hover:bg-white transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center text-slate-400">
                            <svg class="w-12 h-12 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p class="text-sm font-semibold">{{ app()->getLocale() === 'ar' ? 'لا توجد مواعيد متبقية لليوم.' : 'No appointments scheduled for today.' }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Appointments Table & Contact Inquiries -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Appointments (2 cols) -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-100 shadow-sm p-6 overflow-hidden">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-base font-bold text-navy-900">{{ app()->getLocale() === 'ar' ? 'أحدث الحجوزات المسجلة' : 'Recent Bookings' }}</h2>
                    <p class="text-xs text-slate-400">{{ app()->getLocale() === 'ar' ? 'آخر العمليات التي تمت على منصة الحجز' : 'Latest activities from booking engine' }}</p>
                </div>
                <a href="{{ route('admin.appointments.index') }}" class="text-xs font-bold text-medical-600 hover:text-medical-700">
                    {{ app()->getLocale() === 'ar' ? 'كل المواعيد' : 'All Appointments' }} &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-start text-sm">
                    <thead>
                        <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                            <th class="pb-3 text-start">{{ app()->getLocale() === 'ar' ? 'المريض' : 'Patient' }}</th>
                            <th class="pb-3 text-start">{{ app()->getLocale() === 'ar' ? 'الخدمة' : 'Service' }}</th>
                            <th class="pb-3 text-start">{{ app()->getLocale() === 'ar' ? 'التاريخ والوقت' : 'Date & Time' }}</th>
                            <th class="pb-3 text-start">{{ app()->getLocale() === 'ar' ? 'الحالة' : 'Status' }}</th>
                            <th class="pb-3 text-end">{{ app()->getLocale() === 'ar' ? 'الإجراء' : 'Action' }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentAppointments as $app)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-3 font-semibold text-navy-900">{{ $app->patient->name }}</td>
                                <td class="py-3 text-slate-600 text-xs">{{ app()->getLocale() === 'ar' ? $app->service->name_ar : $app->service->name_en }}</td>
                                <td class="py-3 text-slate-500 text-xs">
                                    {{ \Carbon\Carbon::parse($app->appointment_date)->format('Y-m-d') }} &bull; {{ \Carbon\Carbon::parse($app->start_time)->format('h:i A') }}
                                </td>
                                <td class="py-3">
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-full {{ $app->status->badgeClass() }}">
                                        {{ $app->status->label() }}
                                    </span>
                                </td>
                                <td class="py-3 text-end">
                                    <a href="{{ route('admin.appointments.show', $app->id) }}" class="text-xs font-bold text-medical-600 hover:text-medical-800">
                                        {{ app()->getLocale() === 'ar' ? 'تفاصيل' : 'Details' }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-slate-400 text-xs">{{ app()->getLocale() === 'ar' ? 'لا توجد حجوزات مسجلة حتى الآن.' : 'No bookings found.' }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Contact Inquiries (1 col) -->
        <div class="lg:col-span-1 bg-white rounded-3xl border border-slate-100 shadow-sm p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-bold text-navy-900">{{ app()->getLocale() === 'ar' ? 'رسائل واستفسارات الزوار' : 'Recent Inquiries' }}</h2>
                    <a href="{{ route('admin.contact-messages.index') }}" class="text-xs font-bold text-medical-600 hover:text-medical-700">
                        {{ app()->getLocale() === 'ar' ? 'عرض الكل' : 'View all' }} &rarr;
                    </a>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($recentMessages as $msg)
                        <div class="py-3.5 space-y-1">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-navy-900">{{ $msg->name }}</span>
                                <span class="text-[10px] text-slate-400">{{ $msg->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs font-medium text-slate-700 line-clamp-1">{{ $msg->subject }}</p>
                            <p class="text-[11px] text-slate-500 line-clamp-2">{{ $msg->message }}</p>
                            <div class="pt-1 flex items-center justify-between">
                                <span class="text-[10px] px-2 py-0.5 rounded-full {{ $msg->status->value === 'unread' ? 'bg-rose-50 text-rose-600 font-bold' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $msg->status->value === 'unread' ? (app()->getLocale() === 'ar' ? 'جديدة' : 'Unread') : (app()->getLocale() === 'ar' ? 'مقروءة' : 'Read') }}
                                </span>
                                <a href="{{ route('admin.contact-messages.show', $msg->id) }}" class="text-[11px] font-bold text-medical-600 hover:underline">
                                    {{ app()->getLocale() === 'ar' ? 'قراءة الرسالة' : 'Read' }}
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="py-8 text-center text-slate-400 text-xs">
                            {{ app()->getLocale() === 'ar' ? 'لا توجد رسائل جديدة.' : 'No contact messages yet.' }}
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
