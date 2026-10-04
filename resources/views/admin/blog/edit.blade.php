@extends('layouts.admin')

@section('title', (app()->getLocale() === 'ar' ? 'تعديل المقال: ' : 'Edit Post: ') . (app()->getLocale() === 'ar' ? $blog->title_ar : $blog->title_en))

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'تعديل المقال' : 'Edit Article' }}</h1>
            <p class="text-xs text-slate-500 mt-1">{{ app()->getLocale() === 'ar' ? $blog->title_ar : $blog->title_en }}</p>
        </div>
        <a href="{{ route('admin.blog.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
            &larr; {{ app()->getLocale() === 'ar' ? 'العودة' : 'Back' }}
        </a>
    </div>

    <form action="{{ route('admin.blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 lg:p-8 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'العنوان (بالعربية)' : 'Title (Arabic)' }} *</label>
                <input type="text" name="title_ar" value="{{ old('title_ar', $blog->title_ar) }}" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                @error('title_ar')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'العنوان (بالإنجليزية)' : 'Title (English)' }} *</label>
                <input type="text" name="title_en" value="{{ old('title_en', $blog->title_en) }}" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                @error('title_en')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'الاسم اللطيف (Slug)' : 'Slug' }}</label>
                <input type="text" name="slug" value="{{ old('slug', $blog->slug) }}" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'التصنيفات' : 'Categories' }}</label>
                @php
                    $selectedCats = old('categories', $blog->categories->pluck('id')->toArray());
                @endphp
                <div class="flex flex-wrap gap-2 p-3 bg-slate-50 rounded-2xl border border-slate-100">
                    @foreach($categories as $category)
                        <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer p-2 rounded-xl hover:bg-white transition">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}" {{ in_array($category->id, $selectedCats) ? 'checked' : '' }} class="w-4 h-4 text-medical-600 rounded border-slate-300">
                            <span>{{ app()->getLocale() === 'ar' ? $category->name_ar : $category->name_en }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'موجز المقال (بالعربية)' : 'Excerpt (Arabic)' }}</label>
                <textarea name="excerpt_ar" rows="2" class="w-full text-sm rounded-xl border border-slate-200 p-3.5 focus:outline-none focus:ring-2 focus:ring-medical-500">{{ old('excerpt_ar', $blog->excerpt_ar) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'موجز المقال (بالإنجليزية)' : 'Excerpt (English)' }}</label>
                <textarea name="excerpt_en" rows="2" class="w-full text-sm rounded-xl border border-slate-200 p-3.5 focus:outline-none focus:ring-2 focus:ring-medical-500">{{ old('excerpt_en', $blog->excerpt_en) }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'المحتوى الكامل (بالعربية)' : 'Full Content (Arabic)' }} *</label>
                <textarea name="content_ar" rows="8" required class="w-full text-sm rounded-xl border border-slate-200 p-3.5 focus:outline-none focus:ring-2 focus:ring-medical-500">{{ old('content_ar', $blog->content_ar) }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'المحتوى الكامل (بالإنجليزية)' : 'Full Content (English)' }} *</label>
                <textarea name="content_en" rows="8" required class="w-full text-sm rounded-xl border border-slate-200 p-3.5 focus:outline-none focus:ring-2 focus:ring-medical-500">{{ old('content_en', $blog->content_en) }}</textarea>
            </div>

            <div class="flex items-center gap-4">
                <img src="{{ $blog->image_url }}" alt="" class="w-14 h-14 rounded-2xl object-cover border border-slate-200 shrink-0">
                <div class="w-full">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'تغيير الصورة' : 'Change Image' }}</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-medical-50 file:text-medical-700 hover:file:bg-medical-100">
                </div>
            </div>

            <div class="flex items-center gap-2 pt-6">
                <label class="flex items-center gap-2.5 cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', $blog->is_published) ? 'checked' : '' }} class="w-4 h-4 text-medical-600 rounded border-slate-300">
                    <span class="text-xs font-bold text-slate-700">{{ app()->getLocale() === 'ar' ? 'نشر المقال على الموقع العام' : 'Publish Article' }}</span>
                </label>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.blog.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition">
                {{ app()->getLocale() === 'ar' ? 'إلغاء' : 'Cancel' }}
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-medical-600 hover:bg-medical-700 text-white font-bold text-sm shadow-md shadow-medical-600/20 transition">
                {{ app()->getLocale() === 'ar' ? 'حفظ التعديلات' : 'Update Post' }}
            </button>
        </div>
    </form>
</div>
@endsection
