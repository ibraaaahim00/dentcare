@extends('layouts.admin')

@section('title', (app()->getLocale() === 'ar' ? 'السجل الطبي #' : 'Medical Record #') . $medicalRecord->id)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'السجل الطبي رقم' : 'Medical Record' }} #{{ $medicalRecord->id }}</h1>
                <span class="text-xs text-slate-400">&bull; {{ \Carbon\Carbon::parse($medicalRecord->treatment_date)->format('Y-m-d') }}</span>
            </div>
            <p class="text-xs text-slate-500 mt-1">{{ app()->getLocale() === 'ar' ? 'المريض:' : 'Patient:' }} {{ $medicalRecord->patient->name }}</p>
        </div>
        <a href="{{ route('admin.medical-records.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
            &larr; {{ app()->getLocale() === 'ar' ? 'العودة' : 'Back' }}
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 lg:p-8 space-y-6">
        <!-- Patient & Doctor Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-5 rounded-2xl bg-slate-50">
            <div>
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">{{ app()->getLocale() === 'ar' ? 'المريض' : 'Patient' }}</span>
                <div class="font-bold text-navy-900 mt-1">{{ $medicalRecord->patient->name }}</div>
                <div class="text-xs text-slate-500">{{ $medicalRecord->patient->email }} &bull; {{ $medicalRecord->patient->phone }}</div>
            </div>
            <div>
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">{{ app()->getLocale() === 'ar' ? 'الطبيب المعالج' : 'Doctor' }}</span>
                <div class="font-bold text-navy-900 mt-1">{{ $medicalRecord->doctor->user->name }}</div>
                <div class="text-xs text-slate-500">{{ $medicalRecord->doctor->specialization }}</div>
            </div>
        </div>

        <div class="space-y-4">
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">{{ app()->getLocale() === 'ar' ? 'التشخيص الطبي' : 'Clinical Diagnosis' }}</span>
                <div class="p-4 rounded-2xl bg-medical-50/50 border border-medical-100 text-navy-900 font-bold text-sm">
                    {{ $medicalRecord->diagnosis }}
                </div>
            </div>

            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">{{ app()->getLocale() === 'ar' ? 'الإجراء وخطة العلاج' : 'Treatment & Procedures' }}</span>
                <div class="p-4 rounded-2xl bg-slate-50 text-slate-700 text-xs leading-relaxed font-medium">
                    {{ $medicalRecord->treatment }}
                </div>
            </div>

            @if($medicalRecord->notes)
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">{{ app()->getLocale() === 'ar' ? 'الملاحظات والتعليمات الطبية' : 'Notes & Instructions' }}</span>
                    <div class="p-4 rounded-2xl bg-slate-50 text-slate-600 text-xs leading-relaxed">
                        {{ $medicalRecord->notes }}
                    </div>
                </div>
            @endif

            @if($medicalRecord->appointment)
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-slate-400">{{ app()->getLocale() === 'ar' ? 'مرتبط بالموعد:' : 'Linked appointment:' }} #{{ $medicalRecord->appointment_id }} ({{ app()->getLocale() === 'ar' ? $medicalRecord->appointment->service->name_ar : $medicalRecord->appointment->service->name_en }})</span>
                    <a href="{{ route('admin.appointments.show', $medicalRecord->appointment_id) }}" class="font-bold text-medical-600 hover:underline">
                        {{ app()->getLocale() === 'ar' ? 'عرض الموعد' : 'View Appointment' }} &rarr;
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
