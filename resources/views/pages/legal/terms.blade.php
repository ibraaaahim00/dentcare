@extends('layouts.app')

@section('title', app()->getLocale() === 'ar' ? 'الشروط والأحكام' : 'Terms & Conditions')

@section('content')
<div class="py-16 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-100 shadow-sm space-y-6">
        <h1 class="text-3xl font-extrabold text-navy-900">{{ app()->getLocale() === 'ar' ? 'الشروط والأحكام وسياسة المواعيد' : 'Terms & Booking Policies' }}</h1>
        <div class="text-slate-600 text-sm leading-relaxed space-y-4">
            <h3 class="text-base font-bold text-navy-900">{{ app()->getLocale() === 'ar' ? 'سياسة الحجز والإلغاء' : 'Booking & Cancellation Policy' }}</h3>
            <p>{{ app()->getLocale() === 'ar' ? 'يتاح للمريض إلغاء أو تعديل الموعد عبر حسابه الشخصي في المنصة قبل 4 ساعات على الأقل من موعد الزيارة المحدد لتمكين مرضى آخرين من الاستفادة من الموعد.' : 'Patients can cancel or reschedule appointments up to 4 hours before the scheduled time via the Patient Portal.' }}</p>
        </div>
    </div>
</div>
@endsection
