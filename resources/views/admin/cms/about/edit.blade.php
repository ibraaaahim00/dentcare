@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'إدارة قسم من نحن' : 'About Section CMS')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'إدارة قسم من نحن (About Section CMS)' : 'About Section Management' }}</h1>
            <p class="text-xs text-slate-500 mt-1">{{ app()->getLocale() === 'ar' ? 'تعديل النبذة التعريفية، الرؤية والرسالة، وسنوات الخبرة، والصور المعروضة في الصفحة الرئيسية وصفحة من نحن' : 'Manage clinic story, mission, vision, experience metrics, and imagery' }}</p>
        </div>
    </div>

    <form action="{{ route('admin.about-section.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 space-y-6">
            <!-- Badges -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'الشارة العلوية (عربي)' : 'Badge Text (Arabic)' }}</label>
                    <input type="text" name="badge_ar" value="{{ old('badge_ar', $about?->badge_ar) }}" placeholder="عن DentCare" class="w-full text-xs rounded-xl border border-slate-200 p-3 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'الشارة العلوية (إنجليزي)' : 'Badge Text (English)' }}</label>
                    <input type="text" name="badge_en" value="{{ old('badge_en', $about?->badge_en) }}" placeholder="About DentCare" class="w-full text-xs rounded-xl border border-slate-200 p-3 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                </div>
            </div>

            <!-- Titles -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'العنوان الرئيسي (عربي) *' : 'Main Title (Arabic) *' }}</label>
                    <input type="text" name="title_ar" value="{{ old('title_ar', $about?->title_ar) }}" required class="w-full text-xs rounded-xl border border-slate-200 p-3 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'العنوان الرئيسي (إنجليزي) *' : 'Main Title (English) *' }}</label>
                    <input type="text" name="title_en" value="{{ old('title_en', $about?->title_en) }}" required class="w-full text-xs rounded-xl border border-slate-200 p-3 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                </div>
            </div>

            <!-- Subtitles -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'العنوان الفرعي (عربي)' : 'Subtitle (Arabic)' }}</label>
                    <input type="text" name="subtitle_ar" value="{{ old('subtitle_ar', $about?->subtitle_ar) }}" class="w-full text-xs rounded-xl border border-slate-200 p-3 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'العنوان الفرعي (إنجليزي)' : 'Subtitle (English)' }}</label>
                    <input type="text" name="subtitle_en" value="{{ old('subtitle_en', $about?->subtitle_en) }}" class="w-full text-xs rounded-xl border border-slate-200 p-3 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                </div>
            </div>

            <!-- Descriptions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'الوصف المفصل (عربي) *' : 'Detailed Description (Arabic) *' }}</label>
                    <textarea name="description_ar" rows="4" required class="w-full text-xs rounded-xl border border-slate-200 p-3 focus:ring-2 focus:ring-medical-500 focus:outline-none">{{ old('description_ar', $about?->description_ar) }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'الوصف المفصل (إنجليزي) *' : 'Detailed Description (English) *' }}</label>
                    <textarea name="description_en" rows="4" required class="w-full text-xs rounded-xl border border-slate-200 p-3 focus:ring-2 focus:ring-medical-500 focus:outline-none">{{ old('description_en', $about?->description_en) }}</textarea>
                </div>
            </div>

            <!-- Vision & Mission -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-4">
                <span class="block text-xs font-extrabold text-navy-900">{{ app()->getLocale() === 'ar' ? 'الرؤية والرسالة' : 'Vision & Mission' }}</span>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">{{ app()->getLocale() === 'ar' ? 'الرسالة (عربي)' : 'Mission (Arabic)' }}</label>
                        <textarea name="mission_ar" rows="2" class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:outline-none">{{ old('mission_ar', $about?->mission_ar) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">{{ app()->getLocale() === 'ar' ? 'الرسالة (إنجليزي)' : 'Mission (English)' }}</label>
                        <textarea name="mission_en" rows="2" class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:outline-none">{{ old('mission_en', $about?->mission_en) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">{{ app()->getLocale() === 'ar' ? 'الرؤية (عربي)' : 'Vision (Arabic)' }}</label>
                        <textarea name="vision_ar" rows="2" class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:outline-none">{{ old('vision_ar', $about?->vision_ar) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">{{ app()->getLocale() === 'ar' ? 'الرؤية (إنجليزي)' : 'Vision (English)' }}</label>
                        <textarea name="vision_en" rows="2" class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:outline-none">{{ old('vision_en', $about?->vision_en) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Experience Badge & Action Button -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'سنوات الخبرة (رقم)' : 'Years of Experience' }}</label>
                    <input type="number" name="experience_years" value="{{ old('experience_years', $about?->experience_years ?? 12) }}" class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'نص الخبرة (عربي)' : 'Experience Text (AR)' }}</label>
                    <input type="text" name="experience_text_ar" value="{{ old('experience_text_ar', $about?->experience_text_ar ?? 'عاماً من التميز والابتكار') }}" class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'نص الخبرة (إنجليزي)' : 'Experience Text (EN)' }}</label>
                    <input type="text" name="experience_text_en" value="{{ old('experience_text_en', $about?->experience_text_en ?? 'Years of Excellence') }}" class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:outline-none">
                </div>
            </div>

            <!-- Images & Active Switch -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'الصورة الرئيسية' : 'Primary Image' }}</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-xs rounded-xl border border-slate-200 p-2 focus:outline-none">
                    @if($about?->image)
                        <img src="{{ $about->image_url }}" alt="Primary" class="mt-2 w-28 h-20 object-cover rounded-xl border border-slate-200">
                    @endif
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'الصورة الثانوية' : 'Secondary Image' }}</label>
                    <input type="file" name="secondary_image" accept="image/*" class="w-full text-xs rounded-xl border border-slate-200 p-2 focus:outline-none">
                    @if($about?->secondary_image)
                        <img src="{{ $about->secondary_image_url }}" alt="Secondary" class="mt-2 w-28 h-20 object-cover rounded-xl border border-slate-200">
                    @endif
                </div>
            </div>

            <div class="flex items-center pt-2">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $about?->is_active ?? true) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-10 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-600"></div>
                    <span class="ms-2 text-xs font-bold text-slate-700">{{ app()->getLocale() === 'ar' ? 'تفعيل ظهور قسم من نحن' : 'Active Section' }}</span>
                </label>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-medical-600 hover:bg-medical-700 text-white font-bold text-sm shadow-md shadow-medical-600/20 transition">
                    {{ app()->getLocale() === 'ar' ? 'حفظ إعدادات قسم من نحن' : 'Save About Section' }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
