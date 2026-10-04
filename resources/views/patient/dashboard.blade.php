@extends('layouts.patient')

@section('title', app()->getLocale() === 'ar' ? 'لوحة المريض' : 'Patient Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Welcome Header & Book CTA -->
    <div class="bg-gradient-to-r from-navy-950 to-navy-900 rounded-3xl p-6 sm:p-10 text-white shadow-xl flex flex-col sm:flex-row justify-between items-center gap-6">
        <div class="space-y-2 text-center sm:{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
            <h1 class="text-2xl sm:text-3xl font-extrabold">{{ app()->getLocale() === 'ar' ? 'مرحباً بك، ' : 'Welcome, ' }} {{ auth()->user()->name }} 👋</h1>
            <p class="text-slate-300 text-xs sm:text-sm">{{ app()->getLocale() === 'ar' ? 'يمكنك متابعة مواعيدك القادمة، مراجعة ملفك الطبي وسجل العلاجات بسهولة.' : 'Manage your upcoming consultations and access confidential dental medical records.' }}</p>
        </div>
        <a href="{{ route('appointments.create') }}" class="px-6 py-3.5 bg-gradient-to-r from-medical-600 to-medical-500 hover:from-medical-700 hover:to-medical-600 text-white font-extrabold text-sm rounded-2xl shadow-lg shadow-medical-500/30 shrink-0 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>{{ app()->getLocale() === 'ar' ? 'حجز موعد جديد' : 'Book Appointment' }}</span>
        </a>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
            <span class="text-xs text-slate-400 font-bold uppercase">{{ app()->getLocale() === 'ar' ? 'المواعيد القادمة' : 'Upcoming' }}</span>
            <div class="text-2xl sm:text-3xl font-black text-navy-900 mt-2">{{ $stats['upcoming_count'] }}</div>
        </div>
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
            <span class="text-xs text-slate-400 font-bold uppercase">{{ app()->getLocale() === 'ar' ? 'المواعيد المكتملة' : 'Completed' }}</span>
            <div class="text-2xl sm:text-3xl font-black text-emerald-600 mt-2">{{ $stats['completed_appointments'] }}</div>
        </div>
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
            <span class="text-xs text-slate-400 font-bold uppercase">{{ app()->getLocale() === 'ar' ? 'إجمالي المواعيد' : 'Total Visits' }}</span>
            <div class="text-2xl sm:text-3xl font-black text-medical-600 mt-2">{{ $stats['total_appointments'] }}</div>
        </div>
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
            <span class="text-xs text-slate-400 font-bold uppercase">{{ app()->getLocale() === 'ar' ? 'السجلات الطبية' : 'Medical Records' }}</span>
            <div class="text-2xl sm:text-3xl font-black text-navy-900 mt-2">{{ $stats['medical_records_count'] }}</div>
        </div>
    </div>

    <!-- Upcoming Appointments -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-bold text-navy-900">{{ app()->getLocale() === 'ar' ? 'مواعيدك القادمة والمؤكدة' : 'Upcoming Appointments' }}</h2>
            <a href="{{ route('patient.appointments.index') }}" class="text-xs font-bold text-medical-600 hover:underline">{{ __('app.view') }} &rarr;</a>
        </div>

        @if($upcomingAppointments->count() > 0)
            <div class="space-y-4">
                @foreach($upcomingAppointments as $apt)
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-5 rounded-2xl bg-slate-50 border border-slate-200/70 gap-4">
                        <div class="flex items-center gap-4">
                            <img src="{{ $apt->doctor->image_url }}" alt="{{ $apt->doctor->name }}" class="w-12 h-12 rounded-xl object-cover">
                            <div>
                                <h4 class="font-bold text-navy-900 text-sm">{{ $apt->doctor->name }}</h4>
                                <p class="text-xs text-medical-600 font-semibold">{{ $apt->service->name }}</p>
                                <span class="text-xs text-slate-400 block mt-0.5">
                                    {{ $apt->appointment_date->format('Y-m-d') }} | {{ substr($apt->start_time, 0, 5) }} - {{ substr($apt->end_time, 0, 5) }}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 w-full sm:w-auto justify-between sm:justify-end">
                            <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $apt->status->badgeClass() }}">
                                {{ $apt->status->label() }}
                            </span>
                            <a href="{{ route('patient.appointments.show', $apt->id) }}" class="px-4 py-2 bg-white text-navy-900 border border-slate-200 hover:bg-slate-100 rounded-xl text-xs font-bold transition">
                                {{ __('app.view') }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-8 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                <p class="text-slate-400 text-xs">{{ app()->getLocale() === 'ar' ? 'لا توجد مواعيد قادمة مجدولة حالياً.' : 'No upcoming appointments scheduled.' }}</p>
                <a href="{{ route('appointments.create') }}" class="inline-block mt-3 text-xs font-bold text-medical-600 hover:underline">
                    {{ app()->getLocale() === 'ar' ? 'احجز موعدك الآن' : 'Book a visit now' }} &rarr;
                </a>
            </div>
        @endif
    </div>

    <!-- Recent History -->
    @if($recentAppointments->count() > 0)
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm space-y-4">
            <h2 class="text-lg font-bold text-navy-900">{{ app()->getLocale() === 'ar' ? 'سجل الزيارات السابقة' : 'Recent Visit History' }}</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
                    <thead class="text-xs text-slate-400 uppercase bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 rounded-{{ app()->getLocale() === 'ar' ? 'r' : 'l' }}-xl">{{ __('app.date') }}</th>
                            <th class="px-4 py-3">{{ __('app.doctors') }}</th>
                            <th class="px-4 py-3">{{ __('app.services') }}</th>
                            <th class="px-4 py-3">{{ __('app.status') }}</th>
                            <th class="px-4 py-3 text-center rounded-{{ app()->getLocale() === 'ar' ? 'l' : 'r' }}-xl">{{ __('app.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentAppointments as $apt)
                            <tr class="hover:bg-slate-50/50">
                                <td class="px-4 py-3.5 font-medium text-navy-900">{{ $apt->appointment_date->format('Y-m-d') }}</td>
                                <td class="px-4 py-3.5">{{ $apt->doctor->name }}</td>
                                <td class="px-4 py-3.5 text-slate-500">{{ $apt->service->name }}</td>
                                <td class="px-4 py-3.5">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $apt->status->badgeClass() }}">
                                        {{ $apt->status->label() }}
                                    </span>
                                </td>
                                <td class="px-4 py-3.5 text-center">
                                    <a href="{{ route('patient.appointments.show', $apt->id) }}" class="text-medical-600 font-bold text-xs hover:underline">
                                        {{ __('app.view') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
