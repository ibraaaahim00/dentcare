@extends('layouts.doctor')

@section('title', 'تفاصيل الموعد #' . $appointment->id)
@section('page_title', 'تفاصيل الموعد #' . $appointment->id)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center gap-2 text-xs text-slate-500">
        <a href="{{ route('doctor.appointments.index') }}" class="hover:text-medical-600">&larr; {{ app()->getLocale() === 'ar' ? 'العودة للمواعيد' : 'Back to Schedule' }}</a>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <h1 class="text-2xl font-bold text-navy-900">{{ app()->getLocale() === 'ar' ? 'موعد الزيارة' : 'Appointment' }} #{{ $appointment->id }}</h1>
                <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $appointment->status->badgeClass() }}">
                    {{ $appointment->status->label() }}
                </span>
            </div>
            <p class="text-xs text-slate-500">{{ $appointment->appointment_date->format('Y-m-d') }} | {{ substr($appointment->start_time, 0, 5) }} - {{ substr($appointment->end_time, 0, 5) }}</p>
        </div>

        <div class="flex items-center gap-3">
            @if($appointment->medicalRecord)
                <span class="px-4 py-2 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-xl border border-emerald-200">
                    {{ app()->getLocale() === 'ar' ? 'تم تسجيل التقرير الطبي' : 'Medical Record Filed' }}
                </span>
            @else
                <a href="{{ route('doctor.medical-records.create', ['appointment_id' => $appointment->id]) }}" class="px-4 py-2 bg-medical-600 hover:bg-medical-700 text-white rounded-xl text-xs font-bold shadow-md transition">
                    + {{ app()->getLocale() === 'ar' ? 'إضافة تقرير طبي للموعد' : 'Add Medical Record' }}
                </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Patient Details -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm space-y-4">
            <h3 class="font-bold text-navy-900 text-sm border-b border-slate-100 pb-3">{{ app()->getLocale() === 'ar' ? 'بيانات المريض' : 'Patient Information' }}</h3>
            
            <div class="flex items-center gap-4">
                <img src="{{ $appointment->patient->avatar_url }}" alt="" class="w-14 h-14 rounded-2xl object-cover">
                <div>
                    <h4 class="font-bold text-navy-900 text-base">{{ $appointment->patient->name }}</h4>
                    <span class="text-xs text-slate-500 block" dir="ltr">{{ $appointment->patient->phone }}</span>
                    <span class="text-xs text-slate-400 block">{{ $appointment->patient->email }}</span>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 space-y-2 text-xs">
                <div class="flex justify-between">
                    <span class="text-slate-400">{{ app()->getLocale() === 'ar' ? 'الجنس' : 'Gender' }}:</span>
                    <span class="font-semibold text-navy-900">{{ $appointment->patient->gender?->label() ?? '--' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400">{{ app()->getLocale() === 'ar' ? 'تاريخ الميلاد' : 'DOB' }}:</span>
                    <span class="font-semibold text-navy-900">{{ $appointment->patient->date_of_birth?->format('Y-m-d') ?? '--' }}</span>
                </div>
            </div>

            @if($appointment->patient_notes)
                <div class="pt-3 border-t border-slate-100">
                    <span class="text-xs font-bold text-slate-500 block mb-1">{{ app()->getLocale() === 'ar' ? 'ملاحظات المريض:' : 'Patient Notes:' }}</span>
                    <p class="text-xs bg-slate-50 p-3 rounded-xl text-slate-700">{{ $appointment->patient_notes }}</p>
                </div>
            @endif
        </div>

        <!-- Update Status Action Card -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm space-y-4">
            <h3 class="font-bold text-navy-900 text-sm border-b border-slate-100 pb-3">{{ app()->getLocale() === 'ar' ? 'تحديث حالة الموعد' : 'Update Status & Doctor Notes' }}</h3>

            <form method="POST" action="{{ route('doctor.appointments.update-status', $appointment->id) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="status" class="block text-xs font-bold text-slate-700 uppercase mb-2">{{ app()->getLocale() === 'ar' ? 'الحالة الجديدة' : 'New Status' }}</label>
                    <select id="status" name="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white" required>
                        @foreach(\App\Enums\AppointmentStatus::cases() as $st)
                            <option value="{{ $st->value }}" {{ $appointment->status === $st ? 'selected' : '' }}>
                                {{ $st->label() }} ({{ $st->labelAr() }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="doctor_notes" class="block text-xs font-bold text-slate-700 uppercase mb-2">{{ app()->getLocale() === 'ar' ? 'ملاحظات الطبيب السريرية' : 'Doctor Notes' }}</label>
                    <textarea id="doctor_notes" name="doctor_notes" rows="3"
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500"
                              placeholder="{{ app()->getLocale() === 'ar' ? 'سجل أي ملاحظات خاصة بالزيارة هنا...' : 'Add clinical visit observations...' }}">{{ old('doctor_notes', $appointment->doctor_notes) }}</textarea>
                </div>

                <button type="submit" class="w-full py-3 bg-navy-900 hover:bg-navy-800 text-white font-bold text-xs rounded-xl shadow-md transition">
                    {{ app()->getLocale() === 'ar' ? 'حفظ التحديث' : 'Save Status Update' }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
