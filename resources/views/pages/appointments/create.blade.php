@extends('layouts.app')

@section('title', __('appointments.book_title'))

@section('content')
<div class="py-12 sm:py-16 bg-slate-50 min-h-[85vh]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-10">
            <span class="text-medical-600 font-bold text-xs uppercase tracking-wider block mb-2">{{ app()->getLocale() === 'ar' ? 'حجز موعد إلكتروني مباشر' : 'Online Appointment Engine' }}</span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-navy-900 tracking-tight">{{ __('appointments.book_title') }}</h1>
            <p class="text-slate-500 text-sm mt-2 max-w-xl mx-auto">{{ app()->getLocale() === 'ar' ? 'حدد الخدمة والطبيب والتاريخ لعرض الأوقات المتاحة فوراً والحجز المؤكد' : 'Select your desired service, specialist doctor, and date to view live available slots' }}</p>
        </div>

        <!-- Interactive Booking Wizard with Alpine.js -->
        <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-xl shadow-slate-200/50 border border-slate-100"
             x-data="{
                serviceId: '{{ old('service_id', $selectedServiceId ?? '') }}',
                doctorId: '{{ old('doctor_id', $selectedDoctorId ?? '') }}',
                appointmentDate: '{{ old('appointment_date', date('Y-m-d', strtotime('+1 day'))) }}',
                selectedSlot: '{{ old('start_time', '') }}',
                slots: [],
                loadingSlots: false,
                slotError: null,

                fetchSlots() {
                    if (!this.doctorId || !this.appointmentDate) {
                        this.slots = [];
                        return;
                    }
                    this.loadingSlots = true;
                    this.slotError = null;
                    this.selectedSlot = '';

                    let url = `/doctors/${this.doctorId}/available-slots?date=${this.appointmentDate}`;
                    if (this.serviceId) {
                        url += `&service_id=${this.serviceId}`;
                    }

                    fetch(url)
                        .then(res => res.json())
                        .then(res => {
                            this.loadingSlots = false;
                            if (res.success) {
                                this.slots = res.data;
                                if (this.slots.length === 0) {
                                    this.slotError = '{{ app()->getLocale() === 'ar' ? 'لا تتوفر فترات حجز في هذا اليوم أو أن العيادة مغلقة.' : 'No available slots on this date or clinic is closed.' }}';
                                }
                            } else {
                                this.slotError = res.message || 'Error fetching slots';
                            }
                        })
                        .catch(err => {
                            this.loadingSlots = false;
                            this.slotError = 'Network error fetching available slots.';
                        });
                },

                init() {
                    if (this.doctorId && this.appointmentDate) {
                        this.fetchSlots();
                    }
                }
             }">

            <form method="POST" action="{{ route('appointments.store') }}" class="space-y-8">
                @csrf

                <!-- 1. Select Service -->
                <div>
                    <label class="block text-sm font-bold text-navy-900 mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-medical-500 text-white flex items-center justify-center text-xs">1</span>
                        <span>{{ __('appointments.select_service') }}</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($services as $service)
                            <label class="relative flex flex-col p-4 rounded-2xl border-2 cursor-pointer transition"
                                   :class="serviceId == '{{ $service->id }}' ? 'border-medical-600 bg-medical-50/50' : 'border-slate-200 hover:border-slate-300'">
                                <input type="radio" name="service_id" value="{{ $service->id }}" class="sr-only"
                                       x-model="serviceId" @change="fetchSlots()" required>
                                <span class="font-bold text-sm text-navy-900 block mb-1">{{ $service->name }}</span>
                                <div class="mt-auto flex items-center justify-between text-xs text-slate-500 pt-2 border-t border-slate-100">
                                    <span>{{ $service->duration }} {{ app()->getLocale() === 'ar' ? 'دقيقة' : 'min' }}</span>
                                    <span class="font-bold text-medical-600">${{ number_format($service->price, 2) }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- 2. Select Doctor -->
                <div>
                    <label class="block text-sm font-bold text-navy-900 mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-medical-500 text-white flex items-center justify-center text-xs">2</span>
                        <span>{{ __('appointments.select_doctor') }}</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($doctors as $doctor)
                            <label class="relative flex items-center gap-3 p-3.5 rounded-2xl border-2 cursor-pointer transition"
                                   :class="doctorId == '{{ $doctor->id }}' ? 'border-medical-600 bg-medical-50/50' : 'border-slate-200 hover:border-slate-300'">
                                <input type="radio" name="doctor_id" value="{{ $doctor->id }}" class="sr-only"
                                       x-model="doctorId" @change="fetchSlots()" required>
                                <img src="{{ $doctor->image_url }}" alt="{{ $doctor->name }}" class="w-12 h-12 rounded-xl object-cover shrink-0">
                                <div class="overflow-hidden">
                                    <span class="font-bold text-sm text-navy-900 block truncate">{{ $doctor->name }}</span>
                                    <span class="text-xs text-medical-600 block truncate">{{ $doctor->specialization }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- 3. Choose Date & Time Slot -->
                <div>
                    <label class="block text-sm font-bold text-navy-900 mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-medical-500 text-white flex items-center justify-center text-xs">3</span>
                        <span>{{ __('appointments.select_date_time') }}</span>
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                        <div class="sm:col-span-1">
                            <label for="appointment_date" class="block text-xs font-bold text-slate-600 mb-1.5">{{ __('app.date') }}</label>
                            <input type="date" id="appointment_date" name="appointment_date"
                                   min="{{ date('Y-m-d') }}"
                                   max="{{ date('Y-m-d', strtotime('+30 days')) }}"
                                   x-model="appointmentDate" @change="fetchSlots()" required
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500 text-sm bg-white">
                        </div>

                        <div class="sm:col-span-2">
                            <span class="block text-xs font-bold text-slate-600 mb-1.5">{{ app()->getLocale() === 'ar' ? 'الفترات الزمنية المتاحة' : 'Available Time Slots' }}</span>
                            
                            <!-- Loading State -->
                            <div x-show="loadingSlots" class="p-6 text-center text-slate-400 text-xs flex items-center justify-center gap-2">
                                <svg class="animate-spin h-5 w-5 text-medical-600" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                </svg>
                                <span>{{ app()->getLocale() === 'ar' ? 'جاري التحقق من المواعيد المتاحة...' : 'Checking doctor schedule...' }}</span>
                            </div>

                            <!-- Error / Empty State -->
                            <div x-show="!loadingSlots && slotError" class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-medium" x-text="slotError"></div>

                            <!-- Slots Grid -->
                            <div x-show="!loadingSlots && !slotError && slots.length > 0" class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                                <template x-for="slot in slots" :key="slot.time">
                                    <button type="button"
                                            :disabled="!slot.available"
                                            @click="selectedSlot = slot.time"
                                            :class="{
                                                'bg-medical-600 text-white font-bold border-medical-600 shadow-md': selectedSlot === slot.time,
                                                'bg-white text-slate-700 border-slate-200 hover:border-medical-400': selectedSlot !== slot.time && slot.available,
                                                'bg-slate-100 text-slate-300 border-slate-100 cursor-not-allowed line-through': !slot.available
                                            }"
                                            class="py-2.5 px-3 rounded-xl border text-xs font-medium transition text-center flex flex-col items-center justify-center">
                                        <span x-text="slot.time"></span>
                                    </button>
                                </template>
                            </div>

                            <input type="hidden" name="start_time" x-model="selectedSlot" required>
                        </div>
                    </div>
                </div>

                <!-- 4. Patient Information (if guest) + Notes -->
                <div class="pt-6 border-t border-slate-100 space-y-4">
                    <label class="block text-sm font-bold text-navy-900 mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-medical-500 text-white flex items-center justify-center text-xs">4</span>
                        <span>{{ __('appointments.patient_details') }}</span>
                    </label>

                    @guest
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 mb-4 space-y-3">
                            <span class="text-xs font-bold text-navy-900 block">{{ app()->getLocale() === 'ar' ? 'بيانات المريض الجديد (سيتم إنشاء حساب تلقائياً):' : 'Patient Contact Info (Account will be created):' }}</span>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div>
                                    <input type="text" name="patient_name" value="{{ old('patient_name') }}" required
                                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500"
                                           placeholder="{{ app()->getLocale() === 'ar' ? 'اسم المريض' : 'Patient Name' }}">
                                </div>
                                <div>
                                    <input type="email" name="patient_email" value="{{ old('patient_email') }}" required
                                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500"
                                           placeholder="{{ __('app.email') }}">
                                </div>
                                <div>
                                    <input type="text" name="patient_phone" value="{{ old('patient_phone') }}" required dir="ltr"
                                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500"
                                           placeholder="{{ __('app.phone') }}">
                                </div>
                            </div>
                        </div>
                    @endguest

                    <div>
                        <label for="patient_notes" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ app()->getLocale() === 'ar' ? 'ملاحظات إضافية أو وصف الشكوى (اختياري)' : 'Additional Notes / Symptoms (Optional)' }}
                        </label>
                        <textarea id="patient_notes" name="patient_notes" rows="3"
                                  class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500 text-sm"
                                  placeholder="{{ app()->getLocale() === 'ar' ? 'اكتب أي معلومات ترغب في إطلاع الطبيب عليها قبل موعدك...' : 'Any details about your dental concern or pain...' }}">{{ old('patient_notes') }}</textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                            :disabled="!selectedSlot"
                            :class="!selectedSlot ? 'opacity-50 cursor-not-allowed' : 'hover:from-medical-700 hover:to-medical-600 shadow-xl shadow-medical-500/30'"
                            class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-medical-600 to-medical-500 text-white font-extrabold text-base transition duration-300">
                        {{ app()->getLocale() === 'ar' ? 'تأكيد حجز الموعد الآن' : 'Confirm Dental Appointment' }}
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
