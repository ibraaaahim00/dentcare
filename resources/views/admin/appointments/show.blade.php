@extends('layouts.admin')

@section('title', (app()->getLocale() === 'ar' ? 'تفاصيل الحجز #' : 'Booking Details #') . $appointment->id)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'حجز موعد رقم' : 'Appointment' }} #{{ $appointment->id }}</h1>
                <span class="px-3 py-1 text-xs font-bold rounded-full {{ $appointment->status->badgeClass() }}">
                    {{ $appointment->status->label() }}
                </span>
            </div>
            <p class="text-xs text-slate-400 mt-1">
                {{ app()->getLocale() === 'ar' ? 'تم إنشاء الحجز في' : 'Booked on' }} {{ $appointment->created_at->format('Y-m-d h:i A') }}
            </p>
        </div>
        <a href="{{ route('admin.appointments.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
            &larr; {{ app()->getLocale() === 'ar' ? 'العودة للمواعيد' : 'Back to List' }}
        </a>
    </div>

    <!-- Appointment Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <!-- Patient Card -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-3">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">{{ app()->getLocale() === 'ar' ? 'بيانات المريض' : 'Patient Info' }}</span>
            <div class="flex items-center gap-3">
                <img src="{{ $appointment->patient->avatar_url }}" alt="" class="w-12 h-12 rounded-2xl object-cover border border-slate-100">
                <div>
                    <h3 class="font-bold text-navy-900">{{ $appointment->patient->name }}</h3>
                    <p class="text-xs text-slate-400">{{ $appointment->patient->phone }}</p>
                </div>
            </div>
            <div class="text-xs text-slate-500 pt-2 border-t border-slate-100">
                <a href="{{ route('admin.patients.show', $appointment->patient_id) }}" class="text-medical-600 font-bold hover:underline">
                    {{ app()->getLocale() === 'ar' ? 'فتح الملف الطبي الكامل' : 'Open Patient Record' }} &rarr;
                </a>
            </div>
        </div>

        <!-- Doctor Card -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-3">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">{{ app()->getLocale() === 'ar' ? 'الطبيب المعالج' : 'Assigned Doctor' }}</span>
            <div class="flex items-center gap-3">
                <img src="{{ $appointment->doctor->image_url }}" alt="" class="w-12 h-12 rounded-2xl object-cover border border-slate-100">
                <div>
                    <h3 class="font-bold text-navy-900">{{ $appointment->doctor->user->name }}</h3>
                    <p class="text-xs text-slate-400">{{ $appointment->doctor->specialization }}</p>
                </div>
            </div>
            <div class="text-xs text-slate-500 pt-2 border-t border-slate-100">
                <span class="font-bold text-navy-900">${{ number_format($appointment->doctor->consultation_fee, 2) }}</span>
                <span class="text-slate-400">{{ app()->getLocale() === 'ar' ? ' / رسوم الكشف' : ' / consultation' }}</span>
            </div>
        </div>

        <!-- Service & Timing -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-3">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">{{ app()->getLocale() === 'ar' ? 'الخدمة والتوقيت' : 'Service & Time' }}</span>
            <div>
                <h3 class="font-bold text-medical-600">{{ app()->getLocale() === 'ar' ? $appointment->service->name_ar : $appointment->service->name_en }}</h3>
                <p class="text-xs text-slate-500 mt-1">
                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, d M Y') }}
                </p>
                <p class="text-xs font-bold text-navy-900 mt-0.5">
                    {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}
                </p>
            </div>
            <div class="text-xs text-slate-500 pt-2 border-t border-slate-100">
                <span class="font-bold text-emerald-600">${{ number_format($appointment->service->price, 2) }}</span>
                <span class="text-slate-400">({{ $appointment->service->duration }} {{ app()->getLocale() === 'ar' ? 'دقيقة' : 'min' }})</span>
            </div>
        </div>
    </div>

    <!-- Notes & Remarks -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">{{ app()->getLocale() === 'ar' ? 'ملاحظات المريض عند الحجز' : 'Patient Notes' }}</h3>
            <p class="text-xs text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-2xl">
                {{ $appointment->patient_notes ?: (app()->getLocale() === 'ar' ? 'لا توجد ملاحظات مرفقة من المريض.' : 'No notes provided by patient.') }}
            </p>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">{{ app()->getLocale() === 'ar' ? 'ملاحظات الطبيب / العيادة' : 'Clinical Notes' }}</h3>
            <p class="text-xs text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-2xl">
                {{ $appointment->doctor_notes ?: (app()->getLocale() === 'ar' ? 'لا توجد ملاحظات طبية مسجلة بعد.' : 'No clinical notes recorded.') }}
            </p>
        </div>
    </div>

    @if($appointment->cancellation_reason)
        <div class="bg-rose-50 border border-rose-200 p-5 rounded-3xl text-rose-800 text-xs">
            <h4 class="font-bold text-rose-900 mb-1">{{ app()->getLocale() === 'ar' ? 'سبب الإلغاء:' : 'Cancellation Reason:' }}</h4>
            <p>{{ $appointment->cancellation_reason }}</p>
        </div>
    @endif

    <!-- Update Status Action Panel -->
    <div class="bg-white p-6 lg:p-8 rounded-3xl border border-slate-100 shadow-sm space-y-6">
        <div class="border-b border-slate-100 pb-3">
            <h2 class="text-base font-bold text-navy-900">{{ app()->getLocale() === 'ar' ? 'تحديث حالة الموعد' : 'Update Appointment Lifecycle Status' }}</h2>
            <p class="text-xs text-slate-400">{{ app()->getLocale() === 'ar' ? 'تعديل الحالة مع إرسال إشعار فوري للمريض عبر المنظومة' : 'Transition appointment stage with automatic patient in-app notification' }}</p>
        </div>

        <form action="{{ route('admin.appointments.update-status', $appointment->id) }}" method="POST" class="space-y-5" x-data="{ selectedStatus: '{{ $appointment->status->value }}' }">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                @foreach(\App\Enums\AppointmentStatus::cases() as $statusOption)
                    <label class="relative flex flex-col p-4 rounded-2xl border-2 cursor-pointer transition text-center"
                           :class="selectedStatus === '{{ $statusOption->value }}' ? 'border-medical-500 bg-medical-50/50 shadow-sm' : 'border-slate-200 hover:border-slate-300'">
                        <input type="radio" name="status" value="{{ $statusOption->value }}" x-model="selectedStatus" class="sr-only">
                        <span class="text-xs font-bold text-navy-900">{{ $statusOption->label() }}</span>
                        <span class="text-[10px] text-slate-400 mt-1 capitalize">{{ $statusOption->value }}</span>
                    </label>
                @endforeach
            </div>

            <!-- Conditional Cancellation Reason -->
            <div x-show="selectedStatus === 'cancelled'" x-cloak class="space-y-1.5">
                <label class="block text-xs font-bold text-rose-700">{{ app()->getLocale() === 'ar' ? 'سبب الإلغاء (يظهر للمريض)' : 'Cancellation Reason' }} *</label>
                <textarea name="cancellation_reason" rows="2" class="w-full text-xs rounded-xl border border-rose-200 p-3 focus:outline-none focus:ring-2 focus:ring-rose-400" placeholder="{{ app()->getLocale() === 'ar' ? 'وضح سبب إلغاء الحجز...' : 'Enter explanation for cancellation...' }}">{{ old('cancellation_reason', $appointment->cancellation_reason) }}</textarea>
            </div>

            <!-- Doctor Notes -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">{{ app()->getLocale() === 'ar' ? 'تحديث ملاحظات الطبيب / الزيارة' : 'Update Doctor / Visit Notes' }}</label>
                <textarea name="doctor_notes" rows="2" class="w-full text-xs rounded-xl border border-slate-200 p-3 focus:outline-none focus:ring-2 focus:ring-medical-500" placeholder="{{ app()->getLocale() === 'ar' ? 'أضف أي ملاحظات إضافية...' : 'Add any clinical notes...' }}">{{ old('doctor_notes', $appointment->doctor_notes) }}</textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="submit" class="px-6 py-2.5 bg-medical-600 hover:bg-medical-700 text-white font-bold text-xs rounded-xl shadow-md shadow-medical-600/20 transition">
                    {{ app()->getLocale() === 'ar' ? 'حفظ وتحديث الحالة' : 'Save & Update Status' }}
                </button>
            </div>
        </form>
    </div>

    <!-- Linked Medical Record or Review -->
    @if($appointment->medicalRecord || $appointment->review)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @if($appointment->medicalRecord)
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-2">
                    <h3 class="text-xs font-bold text-navy-900 uppercase tracking-wider">{{ app()->getLocale() === 'ar' ? 'السجل الطبي المرتبط' : 'Linked Medical Record' }}</h3>
                    <p class="text-xs font-bold text-medical-600">{{ $appointment->medicalRecord->diagnosis }}</p>
                    <p class="text-xs text-slate-600">{{ $appointment->medicalRecord->treatment }}</p>
                </div>
            @endif

            @if($appointment->review)
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-2">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xs font-bold text-navy-900 uppercase tracking-wider">{{ app()->getLocale() === 'ar' ? 'تقييم المريض للزيارة' : 'Patient Review' }}</h3>
                        <div class="flex text-amber-400 text-xs">
                            @for($i = 1; $i <= 5; $i++)
                                <span>{{ $i <= $appointment->review->rating ? '★' : '☆' }}</span>
                            @endfor
                        </div>
                    </div>
                    <p class="text-xs text-slate-600 italic">"{{ $appointment->review->comment }}"</p>
                </div>
            @endif
        </div>
    @endif
</div>
@endsection
