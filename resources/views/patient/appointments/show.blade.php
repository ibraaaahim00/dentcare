@extends('layouts.patient')

@section('title', 'تفاصيل الموعد #' . $appointment->id)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center gap-2 text-xs text-slate-500">
        <a href="{{ route('patient.appointments.index') }}" class="hover:text-medical-600">&larr; {{ app()->getLocale() === 'ar' ? 'العودة للمواعيد' : 'Back to Appointments' }}</a>
    </div>

    <!-- Appointment Header Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <h1 class="text-2xl font-extrabold text-navy-900">{{ app()->getLocale() === 'ar' ? 'موعد رقم' : 'Appointment' }} #{{ $appointment->id }}</h1>
                <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $appointment->status->badgeClass() }}">
                    {{ $appointment->status->label() }}
                </span>
            </div>
            <p class="text-xs text-slate-500">
                {{ app()->getLocale() === 'ar' ? 'تم الحجز في:' : 'Booked on:' }} {{ $appointment->created_at->format('Y-m-d H:i') }}
            </p>
        </div>

        <!-- Cancellation Action -->
        @if($appointment->canBeCancelledByPatient(4))
            <form method="POST" action="{{ route('patient.appointments.cancel', $appointment->id) }}" onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'هل أنت متأكد من رغبتك في إلغاء هذا الموعد؟' : 'Are you sure you want to cancel this appointment?' }}');">
                @csrf
                <button type="submit" class="px-4 py-2.5 rounded-xl border border-rose-200 bg-rose-50 text-rose-600 hover:bg-rose-100 text-xs font-bold transition">
                    {{ app()->getLocale() === 'ar' ? 'إلغاء الموعد' : 'Cancel Appointment' }}
                </button>
            </form>
        @endif
    </div>

    <!-- Appointment Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Date, Time, Service -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm space-y-4">
            <h3 class="font-bold text-navy-900 text-sm border-b border-slate-100 pb-3">{{ app()->getLocale() === 'ar' ? 'تفاصيل الموعد والخدمة' : 'Service & Schedule' }}</h3>
            
            <div class="space-y-3 text-xs">
                <div class="flex justify-between py-1 border-b border-slate-50">
                    <span class="text-slate-400">{{ __('app.services') }}</span>
                    <span class="font-bold text-navy-900">{{ $appointment->service->name }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-50">
                    <span class="text-slate-400">{{ __('app.date') }}</span>
                    <span class="font-bold text-navy-900">{{ $appointment->appointment_date->format('Y-m-d') }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-50">
                    <span class="text-slate-400">{{ __('app.time') }}</span>
                    <span class="font-bold text-navy-900" dir="ltr">{{ substr($appointment->start_time, 0, 5) }} - {{ substr($appointment->end_time, 0, 5) }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-50">
                    <span class="text-slate-400">{{ app()->getLocale() === 'ar' ? 'الرسوم' : 'Fee' }}</span>
                    <span class="font-bold text-medical-600 text-sm">${{ number_format($appointment->service->price, 2) }}</span>
                </div>
                @if($appointment->patient_notes)
                    <div class="pt-2">
                        <span class="text-slate-400 block mb-1">{{ app()->getLocale() === 'ar' ? 'ملاحظاتك أثناء الحجز:' : 'Your Notes:' }}</span>
                        <p class="text-slate-700 bg-slate-50 p-3 rounded-xl">{{ $appointment->patient_notes }}</p>
                    </div>
                @endif
                @if($appointment->cancellation_reason)
                    <div class="pt-2">
                        <span class="text-rose-500 font-bold block mb-1">{{ app()->getLocale() === 'ar' ? 'سبب الإلغاء:' : 'Cancellation Reason:' }}</span>
                        <p class="text-rose-700 bg-rose-50 p-3 rounded-xl">{{ $appointment->cancellation_reason }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Doctor Details Card -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm space-y-4">
            <h3 class="font-bold text-navy-900 text-sm border-b border-slate-100 pb-3">{{ app()->getLocale() === 'ar' ? 'الطبيب المعالج' : 'Doctor in Charge' }}</h3>
            
            <div class="flex items-center gap-4">
                <img src="{{ $appointment->doctor->image_url }}" alt="{{ $appointment->doctor->name }}" class="w-16 h-16 rounded-2xl object-cover">
                <div>
                    <h4 class="font-bold text-navy-900 text-base">{{ $appointment->doctor->name }}</h4>
                    <p class="text-xs text-medical-600 font-semibold">{{ $appointment->doctor->specialization }}</p>
                    <span class="text-xs text-slate-400">{{ $appointment->doctor->experience_years }} {{ app()->getLocale() === 'ar' ? 'سنوات خبرة' : 'years experience' }}</span>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 text-xs text-slate-500 leading-relaxed">
                {{ $appointment->doctor->bio }}
            </div>
        </div>
    </div>

    <!-- Linked Medical Record (if created) -->
    @if($appointment->medicalRecord)
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm space-y-4">
            <div class="flex justify-between items-center border-b border-slate-100 pb-4">
                <h3 class="font-bold text-navy-900 text-base">{{ app()->getLocale() === 'ar' ? 'تقرير العلاج والتشخيص الطبي' : 'Treatment & Diagnosis Report' }}</h3>
                <span class="text-xs text-slate-400">{{ $appointment->medicalRecord->treatment_date->format('Y-m-d') }}</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                <div>
                    <span class="text-xs font-bold text-slate-400 block mb-1 uppercase">{{ app()->getLocale() === 'ar' ? 'التشخيص الطبي' : 'Diagnosis' }}</span>
                    <p class="p-4 bg-slate-50 rounded-2xl text-slate-700 leading-relaxed">{{ $appointment->medicalRecord->diagnosis }}</p>
                </div>
                <div>
                    <span class="text-xs font-bold text-slate-400 block mb-1 uppercase">{{ app()->getLocale() === 'ar' ? 'الإجراء العلاجي' : 'Treatment Administered' }}</span>
                    <p class="p-4 bg-slate-50 rounded-2xl text-slate-700 leading-relaxed">{{ $appointment->medicalRecord->treatment }}</p>
                </div>
            </div>
            @if($appointment->medicalRecord->notes)
                <div class="pt-2">
                    <span class="text-xs font-bold text-slate-400 block mb-1 uppercase">{{ app()->getLocale() === 'ar' ? 'تعليمات الطبيب للمريض' : 'Doctor Recommendations & Notes' }}</span>
                    <p class="p-4 bg-medical-50 text-medical-900 rounded-2xl text-sm leading-relaxed">{{ $appointment->medicalRecord->notes }}</p>
                </div>
            @endif
        </div>
    @endif

    <!-- Review Section (if completed) -->
    @if($appointment->status === \App\Enums\AppointmentStatus::Completed)
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm space-y-4">
            <h3 class="font-bold text-navy-900 text-base border-b border-slate-100 pb-4">{{ app()->getLocale() === 'ar' ? 'تقييم زيارتك للعيادة' : 'Rate Your Visit' }}</h3>
            
            @if($appointment->review)
                <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl space-y-2">
                    <div class="flex items-center gap-1 text-amber-500">
                        @for($i = 1; $i <= 5; $i++)
                            <span>{{ $i <= $appointment->review->rating ? '★' : '☆' }}</span>
                        @endfor
                        <span class="text-xs font-bold text-slate-700 {{ app()->getLocale() === 'ar' ? 'mr-2' : 'ml-2' }}">({{ $appointment->review->rating }} / 5)</span>
                    </div>
                    <p class="text-slate-700 text-sm italic">"{{ $appointment->review->comment }}"</p>
                    <span class="text-[11px] text-emerald-700 block font-semibold">{{ app()->getLocale() === 'ar' ? 'شكراً لك، تم تسجيل تقييمك!' : 'Thank you, your review has been recorded!' }}</span>
                </div>
            @else
                <form method="POST" action="{{ route('patient.reviews.store') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">{{ app()->getLocale() === 'ar' ? 'التقييم (من 1 إلى 5 نجوم)' : 'Rating (1 to 5 stars)' }}</label>
                        <select name="rating" class="w-full sm:w-48 px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white" required>
                            <option value="5">★★★★★ (5/5) ممتاز</option>
                            <option value="4">★★★★☆ (4/5) جيد جداً</option>
                            <option value="3">★★★☆☆ (3/5) جيد</option>
                            <option value="2">★★☆☆☆ (2/5) مقبول</option>
                            <option value="1">★☆☆☆☆ (1/5) سيء</option>
                        </select>
                    </div>

                    <div>
                        <label for="comment" class="block text-xs font-bold text-slate-700 uppercase mb-2">{{ app()->getLocale() === 'ar' ? 'رأيك وتجربتك مع الطبيب والعيادة' : 'Your Review & Comments' }}</label>
                        <textarea id="comment" name="comment" rows="3" required
                                  class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500"
                                  placeholder="{{ app()->getLocale() === 'ar' ? 'كيف كانت تجربتك؟...' : 'Share your feedback...' }}"></textarea>
                    </div>

                    <button type="submit" class="px-6 py-2.5 bg-medical-600 hover:bg-medical-700 text-white font-bold text-xs rounded-xl shadow-md transition">
                        {{ app()->getLocale() === 'ar' ? 'إرسال التقييم' : 'Submit Review' }}
                    </button>
                </form>
            @endif
        </div>
    @endif
</div>
@endsection
