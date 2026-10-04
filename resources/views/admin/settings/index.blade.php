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
            <!-- Social Media & Location -->
            <div>
                <h2 class="text-sm font-bold text-navy-900 uppercase tracking-wider pb-3 border-b border-slate-100 mb-5 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-medical-50 text-medical-600 flex items-center justify-center text-xs">3</span>
                    <span>{{ app()->getLocale() === 'ar' ? 'وسائل التواصل والخريطة' : 'Social Media & Location' }}</span>
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'رقم الواتساب' : 'WhatsApp Number' }}</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp', $settings['whatsapp'] ?? '+966501234567') }}" placeholder="+966501234567" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'رابط فيسبوك' : 'Facebook URL' }}</label>
                        <input type="text" name="facebook_url" value="{{ old('facebook_url', $settings['facebook_url'] ?? 'https://facebook.com') }}" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'رابط تويتر (X)' : 'Twitter (X) URL' }}</label>
                        <input type="text" name="twitter_url" value="{{ old('twitter_url', $settings['twitter_url'] ?? 'https://x.com') }}" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'رابط انستقرام' : 'Instagram URL' }}</label>
                        <input type="text" name="instagram_url" value="{{ old('instagram_url', $settings['instagram_url'] ?? 'https://instagram.com') }}" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'رابط يوتيوب' : 'YouTube URL' }}</label>
                        <input type="text" name="youtube_url" value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'رابط لينكد إن' : 'LinkedIn URL' }}</label>
                        <input type="text" name="linkedin_url" value="{{ old('linkedin_url', $settings['linkedin_url'] ?? '') }}" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    </div>

                    <div class="md:col-span-2 lg:col-span-3">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'رابط خرائط جوجل المباشر' : 'Google Maps Link' }}</label>
                        <input type="text" name="google_map_link" value="{{ old('google_map_link', $settings['google_map_link'] ?? 'https://maps.google.com') }}" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    </div>

                    <div class="md:col-span-2 lg:col-span-3">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'كود تضمين الخريطة (Google Map Embed iframe or src)' : 'Google Maps Embed iframe / src' }}</label>
                        <textarea name="google_map_embed" rows="2" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">{{ old('google_map_embed', $settings['google_map_embed'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Header Announcement & Footer Texts -->
            <div>
                <h2 class="text-sm font-bold text-navy-900 uppercase tracking-wider pb-3 border-b border-slate-100 mb-5 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-medical-50 text-medical-600 flex items-center justify-center text-xs">4</span>
                    <span>{{ app()->getLocale() === 'ar' ? 'الشريط العلوي، التذييل، وحقوق النشر' : 'Topbar, Footer, and Copyright' }}</span>
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'إعلان الشريط العلوي (عربي)' : 'Topbar Announcement (AR)' }}</label>
                        <input type="text" name="header_topbar_announcement_ar" value="{{ old('header_topbar_announcement_ar', $settings['header_topbar_announcement_ar'] ?? 'خصم 20% على باقات تبييض وتجميل الأسنان هذا الشهر!') }}" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'إعلان الشريط العلوي (إنجليزي)' : 'Topbar Announcement (EN)' }}</label>
                        <input type="text" name="header_topbar_announcement_en" value="{{ old('header_topbar_announcement_en', $settings['header_topbar_announcement_en'] ?? '20% off on all cosmetic dentistry and teeth whitening packages this month!') }}" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'نص التذييل التعريفي (عربي)' : 'Footer About Paragraph (AR)' }}</label>
                        <textarea name="footer_text_ar" rows="3" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">{{ old('footer_text_ar', $settings['footer_text_ar'] ?? 'عيادة أسنان متكاملة تقدم أحدث حلول طب وجراحة وتجميل الأسنان بأحدث التقنيات وأعلى معايير التعقيم.') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'نص التذييل التعريفي (إنجليزي)' : 'Footer About Paragraph (EN)' }}</label>
                        <textarea name="footer_text_en" rows="3" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">{{ old('footer_text_en', $settings['footer_text_en'] ?? 'A comprehensive dental clinic providing cutting-edge oral healthcare, cosmetic dentistry, and dental surgery with maximum sterilization standards.') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'نص حقوق النشر (عربي)' : 'Copyright Text (AR)' }}</label>
                        <input type="text" name="copyright_text_ar" value="{{ old('copyright_text_ar', $settings['copyright_text_ar'] ?? 'جميع الحقوق محفوظة © DentCare مركز طب الأسنان') }}" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'نص حقوق النشر (إنجليزي)' : 'Copyright Text (EN)' }}</label>
                        <input type="text" name="copyright_text_en" value="{{ old('copyright_text_en', $settings['copyright_text_en'] ?? 'All rights reserved © DentCare Dental Clinic') }}" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    </div>
                </div>
            </div>

            <!-- SEO Meta Tags -->
            <div>
                <h2 class="text-sm font-bold text-navy-900 uppercase tracking-wider pb-3 border-b border-slate-100 mb-5 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-medical-50 text-medical-600 flex items-center justify-center text-xs">5</span>
                    <span>{{ app()->getLocale() === 'ar' ? 'تهيئة محركات البحث (SEO)' : 'Search Engine Optimization (SEO)' }}</span>
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'عنوان الموقع لمحركات البحث (عربي)' : 'Meta Title (AR)' }}</label>
                        <input type="text" name="meta_title_ar" value="{{ old('meta_title_ar', $settings['meta_title_ar'] ?? 'DentCare — أفضل عيادة أسنان وحجز مواعيد فوري') }}" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'عنوان الموقع لمحركات البحث (إنجليزي)' : 'Meta Title (EN)' }}</label>
                        <input type="text" name="meta_title_en" value="{{ old('meta_title_en', $settings['meta_title_en'] ?? 'DentCare — Premier Dental Care & Online Booking') }}" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'وصف الموقع لمحركات البحث (عربي)' : 'Meta Description (AR)' }}</label>
                        <textarea name="meta_description_ar" rows="2" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">{{ old('meta_description_ar', $settings['meta_description_ar'] ?? 'احجز موعدك الآن مع نخبة من أطباء واستشاريي الأسنان في DentCare.') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'وصف الموقع لمحركات البحث (إنجليزي)' : 'Meta Description (EN)' }}</label>
                        <textarea name="meta_description_en" rows="2" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">{{ old('meta_description_en', $settings['meta_description_en'] ?? 'Book your online dental appointment with top specialized dentists at DentCare.') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'الكلمات المفتاحية (عربي)' : 'Keywords (AR)' }}</label>
                        <input type="text" name="meta_keywords_ar" value="{{ old('meta_keywords_ar', $settings['meta_keywords_ar'] ?? 'طب أسنان, تبييض أسنان, زراعة أسنان, تقويم أسنان') }}" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'الكلمات المفتاحية (إنجليزي)' : 'Keywords (EN)' }}</label>
                        <input type="text" name="meta_keywords_en" value="{{ old('meta_keywords_en', $settings['meta_keywords_en'] ?? 'dentist, dental clinic, dental implants, teeth whitening, orthodontics') }}" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-medical-600 hover:bg-medical-700 text-white font-bold text-sm shadow-md shadow-medical-600/20 transition">
                    {{ app()->getLocale() === 'ar' ? 'حفظ كافة إعدادات العيادة' : 'Save All Settings' }}
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
