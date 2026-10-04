@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'إعدادات العيادة ومواعيد العمل' : 'Clinic Settings')

@section('content')
<div class="space-y-8" x-data="{ activeTab: 'general' }">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'إعدادات العيادة ومحرك الحجز' : 'Clinic Settings & Engine' }}</h1>
            <p class="text-xs text-slate-500 mt-1">{{ app()->getLocale() === 'ar' ? 'إدارة البيانات العامة، ساعات العمل الأسبوعية، وقواعد حجز المواعيد' : 'Configure contact info, weekly working hours, and booking constraints' }}</p>
        </div>
        <!-- Tab Switcher -->
        <div class="flex items-center p-1 bg-white rounded-2xl border border-slate-200 shadow-sm">
            <button type="button" @click="activeTab = 'general'" :class="activeTab === 'general' ? 'bg-medical-600 text-white font-bold' : 'text-slate-600 hover:text-navy-900'" class="px-4 py-2 rounded-xl text-xs transition">
                {{ app()->getLocale() === 'ar' ? 'بيانات العيادة ومحرك الحجز' : 'Clinic & Booking Rules' }}
            </button>
            <button type="button" @click="activeTab = 'hours'" :class="activeTab === 'hours' ? 'bg-medical-600 text-white font-bold' : 'text-slate-600 hover:text-navy-900'" class="px-4 py-2 rounded-xl text-xs transition">
                {{ app()->getLocale() === 'ar' ? 'أيام وساعات العمل' : 'Working Hours' }}
            </button>
        </div>
    </div>

    <!-- Tab 1: Clinic General & Booking Configuration -->
    <div x-show="activeTab === 'general'" class="space-y-6">
        <form action="{{ route('admin.settings.update-clinic') }}" method="POST" class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 lg:p-8 space-y-8">
            @csrf

            <!-- Clinic General Information -->
            <div>
                <h2 class="text-sm font-bold text-navy-900 uppercase tracking-wider pb-3 border-b border-slate-100 mb-5 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-medical-50 text-medical-600 flex items-center justify-center text-xs">1</span>
                    <span>{{ app()->getLocale() === 'ar' ? 'معلومات العيادة العامة' : 'General Clinic Details' }}</span>
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'اسم العيادة (بالعربية)' : 'Clinic Name (Arabic)' }} *</label>
                        <input type="text" name="clinic_name_ar" value="{{ old('clinic_name_ar', $settings['clinic_name_ar'] ?? 'DentCare مركز طب الأسنان') }}" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'اسم العيادة (بالإنجليزية)' : 'Clinic Name (English)' }} *</label>
                        <input type="text" name="clinic_name_en" value="{{ old('clinic_name_en', $settings['clinic_name_en'] ?? 'DentCare Dental Clinic') }}" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني للعيادة' : 'Clinic Email' }} *</label>
                        <input type="email" name="email" value="{{ old('email', $settings['email'] ?? 'contact@dentcare.com') }}" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'رقم الهاتف الرئيسي' : 'Primary Phone' }} *</label>
                        <input type="text" name="phone" value="{{ old('phone', $settings['phone'] ?? '+966 11 234 5678') }}" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'رقم طوارئ الأسنان' : 'Emergency Dental Phone' }}</label>
                        <input type="text" name="emergency_phone" value="{{ old('emergency_phone', $settings['emergency_phone'] ?? '+966 50 123 4567') }}" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'العنوان (بالعربية)' : 'Address (Arabic)' }} *</label>
                        <input type="text" name="address_ar" value="{{ old('address_ar', $settings['address_ar'] ?? 'الرياض، طريق الملك فهد') }}" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'العنوان (بالإنجليزية)' : 'Address (English)' }} *</label>
                        <input type="text" name="address_en" value="{{ old('address_en', $settings['address_en'] ?? 'King Fahd Road, Riyadh, Saudi Arabia') }}" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    </div>
                </div>
            </div>

            <!-- Booking Engine Rules -->
            <div>
                <h2 class="text-sm font-bold text-navy-900 uppercase tracking-wider pb-3 border-b border-slate-100 mb-5 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-medical-50 text-medical-600 flex items-center justify-center text-xs">2</span>
                    <span>{{ app()->getLocale() === 'ar' ? 'قواعد محرك الحجز الآلي' : 'Appointment Booking Constraints' }}</span>
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'فاصل فترات الحجز (دقيقة)' : 'Booking Slot Interval (Min)' }} *</label>
                        <input type="number" name="booking_interval" value="{{ old('booking_interval', $appointmentSettings->booking_interval ?? 30) }}" min="15" step="5" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                        <span class="text-[10px] text-slate-400 mt-1 block">{{ app()->getLocale() === 'ar' ? 'المدة بين كل فتحة موعد وأخرى' : 'Slot increment step' }}</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'الحد الأدنى للإشعار (ساعات)' : 'Min Notice Hours' }} *</label>
                        <input type="number" name="minimum_notice_hours" value="{{ old('minimum_notice_hours', $appointmentSettings->minimum_notice_hours ?? 2) }}" min="0" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                        <span class="text-[10px] text-slate-400 mt-1 block">{{ app()->getLocale() === 'ar' ? 'يمنع الحجز قبل أقل من هذه المدة' : 'Prevents last-minute walk-ins' }}</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'نافذة الحجز المستقبلية (أيام)' : 'Max Days Ahead' }} *</label>
                        <input type="number" name="maximum_days_ahead" value="{{ old('maximum_days_ahead', $appointmentSettings->maximum_days_ahead ?? 30) }}" min="1" max="180" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                        <span class="text-[10px] text-slate-400 mt-1 block">{{ app()->getLocale() === 'ar' ? 'أقصى مدى تقويم يمكن فتحه' : 'Calendar booking window limit' }}</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'مهلة الإلغاء للمريض (ساعات)' : 'Cancellation Notice (Hours)' }} *</label>
                        <input type="number" name="cancellation_hours" value="{{ old('cancellation_hours', $appointmentSettings->cancellation_hours ?? 12) }}" min="0" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                        <span class="text-[10px] text-slate-400 mt-1 block">{{ app()->getLocale() === 'ar' ? 'فترة السماح بإلغاء الحجز الذاتي' : 'Patient self-cancellation cutoff' }}</span>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-medical-600 hover:bg-medical-700 text-white font-bold text-sm shadow-md shadow-medical-600/20 transition">
                    {{ app()->getLocale() === 'ar' ? 'حفظ إعدادات العيادة والمحرك' : 'Save Settings' }}
                </button>
            </div>
        </form>
    </div>

    <!-- Tab 2: Working Hours Configuration -->
    <div x-show="activeTab === 'hours'" x-cloak class="space-y-6">
        @php
            $dayNamesAr = ['الأحد', 'الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'];
            $dayNamesEn = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        @endphp

        <form action="{{ route('admin.settings.update-working-hours') }}" method="POST" class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 lg:p-8 space-y-6">
            @csrf

            <div class="border-b border-slate-100 pb-3">
                <h2 class="text-base font-bold text-navy-900">{{ app()->getLocale() === 'ar' ? 'جدول أوقات العمل الأسبوعي للعيادة' : 'Weekly Clinic Operating Schedule' }}</h2>
                <p class="text-xs text-slate-400 mt-0.5">{{ app()->getLocale() === 'ar' ? 'يتم احتساب فترات الحجز المتاحة للمرضى تلقائياً بناءً على هذه الساعات' : 'Engine automatically derives booking slots from these active hours' }}</p>
            </div>

            <div class="space-y-4">
                @foreach(range(0, 6) as $day)
                    @php
                        $hourObj = $workingHours->firstWhere('day_of_week', $day);
                        $startTime = $hourObj ? \Carbon\Carbon::parse($hourObj->start_time)->format('H:i') : '09:00';
                        $endTime = $hourObj ? \Carbon\Carbon::parse($hourObj->end_time)->format('H:i') : '21:00';
                        $isClosed = $hourObj ? $hourObj->is_closed : ($day === 5); // Friday closed by default
                    @endphp
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4" x-data="{ closed: {{ $isClosed ? 'true' : 'false' }} }">
                        <input type="hidden" name="hours[{{ $day }}][day_of_week]" value="{{ $day }}">

                        <div class="w-36">
                            <span class="font-bold text-navy-900 text-sm block">
                                {{ app()->getLocale() === 'ar' ? $dayNamesAr[$day] : $dayNamesEn[$day] }}
                            </span>
                            <span class="text-[10px] text-slate-400">Day {{ $day }}</span>
                        </div>

                        <div class="flex items-center gap-4 flex-1">
                            <div class="flex items-center gap-2">
                                <label class="text-xs text-slate-500">{{ app()->getLocale() === 'ar' ? 'من:' : 'From:' }}</label>
                                <input type="time" name="hours[{{ $day }}][start_time]" value="{{ $startTime }}" :disabled="closed" class="text-xs rounded-xl border border-slate-200 px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-medical-500 disabled:bg-slate-200 disabled:text-slate-400">
                            </div>

                            <div class="flex items-center gap-2">
                                <label class="text-xs text-slate-500">{{ app()->getLocale() === 'ar' ? 'إلى:' : 'To:' }}</label>
                                <input type="time" name="hours[{{ $day }}][end_time]" value="{{ $endTime }}" :disabled="closed" class="text-xs rounded-xl border border-slate-200 px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-medical-500 disabled:bg-slate-200 disabled:text-slate-400">
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <label class="flex items-center gap-2 cursor-pointer p-2 rounded-xl hover:bg-white transition">
                                <input type="checkbox" name="hours[{{ $day }}][is_closed]" value="1" x-model="closed" class="w-4 h-4 text-rose-600 rounded border-slate-300">
                                <span class="text-xs font-bold" :class="closed ? 'text-rose-600' : 'text-slate-600'">{{ app()->getLocale() === 'ar' ? 'عطلة / مغلق' : 'Closed / Off' }}</span>
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-medical-600 hover:bg-medical-700 text-white font-bold text-sm shadow-md shadow-medical-600/20 transition">
                    {{ app()->getLocale() === 'ar' ? 'حفظ جدول ساعات العمل' : 'Save Working Hours' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
