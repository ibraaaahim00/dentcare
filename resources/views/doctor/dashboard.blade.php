@extends('layouts.doctor')

@section('title', app()->getLocale() === 'ar' ? 'لوحة تحكم الطبيب' : 'Doctor Dashboard')
@section('page_title', app()->getLocale() === 'ar' ? 'لوحة المتابعة اليومية' : 'Doctor Schedule Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Doctor Header Card -->
    <div class="bg-gradient-to-r from-navy-950 to-navy-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col sm:flex-row justify-between items-center gap-6">
        <div class="flex items-center gap-5">
            <img src="{{ $doctor->image_url }}" alt="" class="w-16 h-16 rounded-2xl object-cover border-2 border-medical-500 shrink-0">
            <div>
                <h2 class="text-xl sm:text-2xl font-bold">{{ app()->getLocale() === 'ar' ? 'مرحباً، دكتور ' : 'Welcome, Dr. ' }} {{ $doctor->name }}</h2>
                <p class="text-medical-300 text-xs mt-0.5">{{ $doctor->specialization }} | {{ $doctor->experience_years }} {{ app()->getLocale() === 'ar' ? 'سنوات خبرة' : 'years exp.' }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('doctor.appointments.index') }}" class="px-5 py-2.5 bg-medical-600 hover:bg-medical-700 text-white font-bold text-xs rounded-xl shadow-md transition">
                {{ app()->getLocale() === 'ar' ? 'عرض جدول المواعيد' : 'View Schedule' }}
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
            <span class="text-xs text-slate-400 font-bold uppercase">{{ app()->getLocale() === 'ar' ? 'مواعيد اليوم' : "Today's Visits" }}</span>
            <div class="text-3xl font-black text-medical-600 mt-2">{{ $stats['today_count'] }}</div>
        </div>
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
            <span class="text-xs text-slate-400 font-bold uppercase">{{ app()->getLocale() === 'ar' ? 'بانتظار التأكيد' : 'Pending' }}</span>
            <div class="text-3xl font-black text-amber-500 mt-2">{{ $stats['pending_count'] }}</div>
        </div>
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
            <span class="text-xs text-slate-400 font-bold uppercase">{{ app()->getLocale() === 'ar' ? 'زيارات مكتملة' : 'Completed' }}</span>
            <div class="text-3xl font-black text-emerald-600 mt-2">{{ $stats['completed_count'] }}</div>
        </div>
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
            <span class="text-xs text-slate-400 font-bold uppercase">{{ app()->getLocale() === 'ar' ? 'سجلات طبية محررة' : 'Medical Records' }}</span>
            <div class="text-3xl font-black text-navy-900 mt-2">{{ $stats['medical_records_count'] }}</div>
        </div>
    </div>

    <!-- Today's Schedule -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm space-y-6">
        <h3 class="text-lg font-bold text-navy-900">{{ app()->getLocale() === 'ar' ? 'جدول مواعيد اليوم' : "Today's Appointments Schedule" }}</h3>

        @if($todayAppointments->count() > 0)
            <div class="divide-y divide-slate-100">
                @foreach($todayAppointments as $apt)
                    <div class="py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 hover:bg-slate-50/50 transition">
                        <div class="flex items-center gap-4">
                            <span class="px-3 py-1.5 rounded-xl bg-slate-100 font-bold text-navy-900 text-xs" dir="ltr">
                                {{ substr($apt->start_time, 0, 5) }} - {{ substr($apt->end_time, 0, 5) }}
                            </span>
                            <div>
                                <h4 class="font-bold text-navy-900 text-sm">{{ $apt->patient->name }}</h4>
                                <span class="text-xs text-medical-600">{{ $apt->service->name }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $apt->status->badgeClass() }}">
                                {{ $apt->status->label() }}
                            </span>
                            <a href="{{ route('doctor.appointments.show', $apt->id) }}" class="px-4 py-2 bg-slate-100 hover:bg-medical-50 text-slate-700 hover:text-medical-600 rounded-xl text-xs font-bold transition">
                                {{ __('app.view') }} &rarr;
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-8 text-center bg-slate-50 rounded-2xl">
                <p class="text-slate-400 text-xs">{{ app()->getLocale() === 'ar' ? 'لا توجد مواعيد مجدولة لليوم حتى الآن.' : 'No appointments scheduled for today.' }}</p>
            </div>
        @endif
    </div>
</div>
@endsection
