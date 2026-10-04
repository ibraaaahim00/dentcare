@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'إضافة بانر جديد' : 'Create Hero Banner')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'إضافة بانر واجهة جديد' : 'Create Hero Banner' }}</h1>
            <p class="text-xs text-slate-500 mt-1">{{ app()->getLocale() === 'ar' ? 'إضافة محتوى وعناصر تفاعلية للواجهة الرئيسية' : 'Add dynamic content, call-to-action buttons, and visuals for homepage' }}</p>
        </div>
        <a href="{{ route('admin.hero-banners.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition">
            {{ app()->getLocale() === 'ar' ? 'العودة للقائمة' : 'Back to List' }}
        </a>
    </div>

    <form action="{{ route('admin.hero-banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 space-y-6">
            <!-- Badges -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'الشارة العلوية (عربي)' : 'Badge Text (Arabic)' }}</label>
                    <input type="text" name="badge_ar" value="{{ old('badge_ar') }}" placeholder="عيادة الأسنان الرائدة الأولى" class="w-full text-xs rounded-xl border border-slate-200 p-3 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'الشارة العلوية (إنجليزي)' : 'Badge Text (English)' }}</label>
                    <input type="text" name="badge_en" value="{{ old('badge_en') }}" placeholder="Premier Dental Clinic" class="w-full text-xs rounded-xl border border-slate-200 p-3 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                </div>
            </div>

            <!-- Titles -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'العنوان الرئيسي (عربي) *' : 'Main Title (Arabic) *' }}</label>
                    <input type="text" name="title_ar" value="{{ old('title_ar') }}" required placeholder="ابتسامتك المثالية تبدأ برعاية طبية متطورة" class="w-full text-xs rounded-xl border border-slate-200 p-3 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                    @error('title_ar') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'العنوان الرئيسي (إنجليزي) *' : 'Main Title (English) *' }}</label>
                    <input type="text" name="title_en" value="{{ old('title_en') }}" required placeholder="Your Perfect Smile Starts With Advanced Dental Care" class="w-full text-xs rounded-xl border border-slate-200 p-3 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                    @error('title_en') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Descriptions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'الوصف التوضيحي (عربي)' : 'Description (Arabic)' }}</label>
                    <textarea name="description_ar" rows="3" class="w-full text-xs rounded-xl border border-slate-200 p-3 focus:ring-2 focus:ring-medical-500 focus:outline-none">{{ old('description_ar') }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'الوصف التوضيحي (إنجليزي)' : 'Description (English)' }}</label>
                    <textarea name="description_en" rows="3" class="w-full text-xs rounded-xl border border-slate-200 p-3 focus:ring-2 focus:ring-medical-500 focus:outline-none">{{ old('description_en') }}</textarea>
                </div>
            </div>

            <!-- Primary Button -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-4">
                <span class="block text-xs font-extrabold text-navy-900">{{ app()->getLocale() === 'ar' ? 'إعدادات الزر الرئيسي (Primary CTA)' : 'Primary Button Settings' }}</span>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">{{ app()->getLocale() === 'ar' ? 'نص الزر (عربي)' : 'Text (AR)' }}</label>
                        <input type="text" name="button_text_ar" value="{{ old('button_text_ar', 'احجز موعدك الآن') }}" class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">{{ app()->getLocale() === 'ar' ? 'نص الزر (إنجليزي)' : 'Text (EN)' }}</label>
                        <input type="text" name="button_text_en" value="{{ old('button_text_en', 'Book Appointment Now') }}" class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">{{ app()->getLocale() === 'ar' ? 'رابط الزر (URL)' : 'URL' }}</label>
                        <input type="text" name="button_url" value="{{ old('button_url', '/appointments/create') }}" class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                    </div>
                </div>
            </div>

            <!-- Secondary Button -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-4">
                <span class="block text-xs font-extrabold text-navy-900">{{ app()->getLocale() === 'ar' ? 'إعدادات الزر الثانوي (Secondary CTA)' : 'Secondary Button Settings' }}</span>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">{{ app()->getLocale() === 'ar' ? 'نص الزر (عربي)' : 'Text (AR)' }}</label>
                        <input type="text" name="secondary_button_text_ar" value="{{ old('secondary_button_text_ar', 'استكشف خدماتنا') }}" class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">{{ app()->getLocale() === 'ar' ? 'نص الزر (إنجليزي)' : 'Text (EN)' }}</label>
                        <input type="text" name="secondary_button_text_en" value="{{ old('secondary_button_text_en', 'Explore Services') }}" class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">{{ app()->getLocale() === 'ar' ? 'رابط الزر (URL)' : 'URL' }}</label>
                        <input type="text" name="secondary_button_url" value="{{ old('secondary_button_url', '/services') }}" class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                    </div>
                </div>
            </div>

            <!-- Images & Order -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'صورة البانر الرئيسية' : 'Main Banner Image' }}</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-xs rounded-xl border border-slate-200 p-2 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'ترتيب الظهور' : 'Sort Order' }}</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 1) }}" min="0" class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                </div>
                <div class="flex items-center pt-6">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-10 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-600"></div>
                        <span class="ms-2 text-xs font-bold text-slate-700">{{ app()->getLocale() === 'ar' ? 'تفعيل البانر' : 'Active Banner' }}</span>
                    </label>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-medical-600 hover:bg-medical-700 text-white font-bold text-sm shadow-md shadow-medical-600/20 transition">
                    {{ app()->getLocale() === 'ar' ? 'حفظ البانر' : 'Save Banner' }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
