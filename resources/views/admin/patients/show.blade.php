@extends('layouts.admin')

@section('title', (app()->getLocale() === 'ar' ? 'الملف الطبي للمريض: ' : 'Patient File: ') . $patient->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <img src="{{ $patient->avatar_url }}" alt="{{ $patient->name }}" class="w-16 h-16 rounded-2xl object-cover border-2 border-white shadow-md">
            <div>
                <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">{{ $patient->name }}</h1>
                <p class="text-xs text-slate-400 mt-0.5">ID: #{{ $patient->id }} &bull; {{ $patient->email }} &bull; {{ $patient->phone }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.patients.edit', $patient->id) }}" class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-bold transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'تعديل البيانات' : 'Edit Patient' }}</span>
            </a>
            <a href="{{ route('admin.patients.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                &larr; {{ app()->getLocale() === 'ar' ? 'العودة' : 'Back' }}
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">{{ app()->getLocale() === 'ar' ? 'إجمالي المواعيد' : 'Total Bookings' }}</span>
            <span class="text-2xl font-extrabold text-navy-900 mt-1 block">{{ $patient->appointments->count() }}</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">{{ app()->getLocale() === 'ar' ? 'السجلات الطبية' : 'Medical Records' }}</span>
            <span class="text-2xl font-extrabold text-medical-600 mt-1 block">{{ $patient->medicalRecords->count() }}</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">{{ app()->getLocale() === 'ar' ? 'التقييمات المقدمة' : 'Submitted Reviews' }}</span>
            <span class="text-2xl font-extrabold text-amber-500 mt-1 block">{{ $patient->reviews->count() }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Medical Records Timeline -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h2 class="text-base font-bold text-navy-900">{{ app()->getLocale() === 'ar' ? 'السجل والتشخيص الطبي' : 'Medical Diagnosis & Treatments' }}</h2>
                <a href="{{ route('admin.medical-records.create') }}" class="text-xs font-bold text-medical-600 hover:underline">
                    + {{ app()->getLocale() === 'ar' ? 'إضافة سجل' : 'Add Record' }}
                </a>
            </div>

            <div class="space-y-4">
                @forelse($patient->medicalRecords as $record)
                    <div class="p-4 rounded-2xl bg-slate-50/70 border border-slate-100 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-navy-900">{{ $record->diagnosis }}</span>
                            <span class="text-[11px] text-slate-400">{{ \Carbon\Carbon::parse($record->treatment_date)->format('Y-m-d') }}</span>
                        </div>
                        <p class="text-xs text-slate-600 font-medium">{{ $record->treatment }}</p>
                        @if($record->notes)
                            <p class="text-[11px] text-slate-400 bg-white p-2.5 rounded-xl border border-slate-100">{{ $record->notes }}</p>
                        @endif
                        <div class="text-[10px] text-medical-700 font-semibold pt-1">
                            {{ app()->getLocale() === 'ar' ? 'المعالج:' : 'Doctor:' }} {{ $record->doctor->user->name }}
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-slate-400 text-xs">
                        {{ app()->getLocale() === 'ar' ? 'لا توجد سجلات طبية مسجلة بعد لهذا المريض.' : 'No medical records documented yet.' }}
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Appointments History -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h2 class="text-base font-bold text-navy-900">{{ app()->getLocale() === 'ar' ? 'تاريخ الحجوزات والمواعيد' : 'Appointments History' }}</h2>
                <span class="text-xs text-slate-400">{{ $patient->appointments->count() }} {{ app()->getLocale() === 'ar' ? 'زيارات' : 'visits' }}</span>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($patient->appointments as $apt)
                    <div class="py-3 flex items-center justify-between gap-3">
                        <div>
                            <div class="text-xs font-bold text-navy-900">
                                {{ app()->getLocale() === 'ar' ? $apt->service->name_ar : $apt->service->name_en }}
                            </div>
                            <div class="text-[11px] text-slate-400">
                                {{ \Carbon\Carbon::parse($apt->appointment_date)->format('Y-m-d') }} &bull; {{ \Carbon\Carbon::parse($apt->start_time)->format('h:i A') }} &bull; {{ $apt->doctor->user->name }}
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-full {{ $apt->status->badgeClass() }}">
                                {{ $apt->status->label() }}
                            </span>
                            <a href="{{ route('admin.appointments.show', $apt->id) }}" class="p-1.5 rounded-lg text-slate-400 hover:text-medical-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-slate-400 text-xs">
                        {{ app()->getLocale() === 'ar' ? 'لا توجد حجوزات مسجلة للمريض.' : 'No appointment history available.' }}
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
