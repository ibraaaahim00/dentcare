@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'إدارة قسم الحث على اتخاذ إجراء (CTA)' : 'CTA Section CMS')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'إدارة قسم الحث على الحجز (CTA Section)' : 'Call To Action CMS' }}</h1>
            <p class="text-xs text-slate-500 mt-1">{{ app()->getLocale() === 'ar' ? 'تعديل قسم الدعوة للحجز والتواصل السريع المعروض قبل التذييل في جميع صفحات الموقع' : 'Manage banner headline, quick booking trigger, contact numbers, and background image' }}</p>
        </div>
    </div>

    <form action="{{ route('admin.cta-section.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 space-y-6">
            <!-- Badges -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'الشارة العلوية (عربي)' : 'Badge (Arabic)' }}</label>
                    <input type="text" name="badge_ar" value="{{ old('badge_ar', $cta?->badge_ar) }}" placeholder="هل أنت جاهز لابتسامة جديدة؟" class="w-full text-xs rounded-xl border border-slate-200 p-3 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'الشارة العلوية (إنجليزي)' : 'Badge (English)' }}</label>
                    <input type="text" name="badge_en" value="{{ old('badge_en', $cta?->badge_en) }}" placeholder="Ready for a Healthier Smile?" class="w-full text-xs rounded-xl border border-slate-200 p-3 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                </div>
            </div>

            <!-- Titles -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'العنوان الرئيسي (عربي) *' : 'Main Title (Arabic) *' }}</label>
                    <input type="text" name="title_ar" value="{{ old('title_ar', $cta?->title_ar ?? 'احجز استشارتك المجانية اليوم واستعد إشراقة ابتسامتك') }}" required class="w-full text-xs rounded-xl border border-slate-200 p-3 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'العنوان الرئيسي (إنجليزي) *' : 'Main Title (English) *' }}</label>
                    <input type="text" name="title_en" value="{{ old('title_en', $cta?->title_en ?? 'Book Your Consultation Today & Restore Your Confident Smile') }}" required class="w-full text-xs rounded-xl border border-slate-200 p-3 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                </div>
            </div>

            <!-- Descriptions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'الوصف (عربي) *' : 'Description (Arabic) *' }}</label>
                    <textarea name="description_ar" rows="3" required class="w-full text-xs rounded-xl border border-slate-200 p-3 focus:ring-2 focus:ring-medical-500 focus:outline-none">{{ old('description_ar', $cta?->description_ar ?? 'نحن هنا لمساعدتك على الحصول على أسنان صحية ومظهر جذاب مع أفضل أطباء الأسنان وأحدث الأجهزة الطبية.') }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'الوصف (إنجليزي) *' : 'Description (English) *' }}</label>
                    <textarea name="description_en" rows="3" required class="w-full text-xs rounded-xl border border-slate-200 p-3 focus:ring-2 focus:ring-medical-500 focus:outline-none">{{ old('description_en', $cta?->description_en ?? 'We are here to help you achieve optimal oral health and stunning aesthetics with state-of-the-art dental technology.') }}</textarea>
                </div>
            </div>

            <!-- Buttons -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-4">
                <span class="block text-xs font-extrabold text-navy-900">{{ app()->getLocale() === 'ar' ? 'الأزرار والهاتف' : 'Buttons & Phone Contact' }}</span>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">{{ app()->getLocale() === 'ar' ? 'نص الزر (عربي) *' : 'Button Text (AR) *' }}</label>
                        <input type="text" name="button_text_ar" value="{{ old('button_text_ar', $cta?->button_text_ar ?? 'احجز موعداً الآن') }}" required class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">{{ app()->getLocale() === 'ar' ? 'نص الزر (إنجليزي) *' : 'Button Text (EN) *' }}</label>
                        <input type="text" name="button_text_en" value="{{ old('button_text_en', $cta?->button_text_en ?? 'Book Appointment') }}" required class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">{{ app()->getLocale() === 'ar' ? 'رابط الزر *' : 'Button URL *' }}</label>
                        <input type="text" name="button_url" value="{{ old('button_url', $cta?->button_url ?? '/appointments/create') }}" required class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">{{ app()->getLocale() === 'ar' ? 'نص الزر الثانوي (عربي)' : 'Secondary Text (AR)' }}</label>
                        <input type="text" name="secondary_button_text_ar" value="{{ old('secondary_button_text_ar', $cta?->secondary_button_text_ar ?? 'اتصل بنا') }}" class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">{{ app()->getLocale() === 'ar' ? 'نص الزر الثانوي (إنجليزي)' : 'Secondary Text (EN)' }}</label>
                        <input type="text" name="secondary_button_text_en" value="{{ old('secondary_button_text_en', $cta?->secondary_button_text_en ?? 'Contact Us') }}" class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">{{ app()->getLocale() === 'ar' ? 'رقم الهاتف للتواصل المباشر' : 'Direct Phone' }}</label>
                        <input type="text" name="phone" value="{{ old('phone', $cta?->phone ?? '+966 11 234 5678') }}" class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:outline-none">
                    </div>
                </div>
            </div>

            <!-- Background Image & Active Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'صورة الخلفية (اختياري)' : 'Background Image (Optional)' }}</label>
                    <input type="file" name="background_image" accept="image/*" class="w-full text-xs rounded-xl border border-slate-200 p-2 focus:outline-none">
                    @if($cta?->background_image)
                        <img src="{{ $cta->background_image_url }}" alt="Background" class="mt-2 w-36 h-16 object-cover rounded-xl border border-slate-200">
                    @endif
                </div>
                <div class="flex items-center pt-6">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $cta?->is_active ?? true) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-10 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-600"></div>
                        <span class="ms-2 text-xs font-bold text-slate-700">{{ app()->getLocale() === 'ar' ? 'تفعيل ظهور القسم' : 'Active Section' }}</span>
                    </label>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-medical-600 hover:bg-medical-700 text-white font-bold text-sm shadow-md shadow-medical-600/20 transition">
                    {{ app()->getLocale() === 'ar' ? 'حفظ إعدادات القسم' : 'Save CTA Section' }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
