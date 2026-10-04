@extends('layouts.admin')

@section('title', (app()->getLocale() === 'ar' ? 'تعديل الخدمة: ' : 'Edit Service: ') . (app()->getLocale() === 'ar' ? $service->name_ar : $service->name_en))

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'تعديل الخدمة العلاجية' : 'Edit Dental Service' }}</h1>
            <p class="text-xs text-slate-500 mt-1">{{ app()->getLocale() === 'ar' ? $service->name_ar : $service->name_en }} &bull; ${{ number_format($service->price, 2) }}</p>
        </div>
        <a href="{{ route('admin.services.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
            &larr; {{ app()->getLocale() === 'ar' ? 'العودة' : 'Back' }}
        </a>
    </div>

    <form action="{{ route('admin.services.update', $service->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 lg:p-8 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'اسم الخدمة (بالعربية)' : 'Service Name (Arabic)' }} *</label>
                <input type="text" name="name_ar" value="{{ old('name_ar', $service->name_ar) }}" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                @error('name_ar')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'اسم الخدمة (بالإنجليزية)' : 'Service Name (English)' }} *</label>
                <input type="text" name="name_en" value="{{ old('name_en', $service->name_en) }}" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                @error('name_en')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'الاسم اللطيف (Slug)' : 'Slug' }}</label>
                <input type="text" name="slug" value="{{ old('slug', $service->slug) }}" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                @error('slug')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'مدة الجلسة (بالدقائق)' : 'Duration (Minutes)' }} *</label>
                <input type="number" name="duration" value="{{ old('duration', $service->duration) }}" min="10" step="5" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                @error('duration')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'السعر ($)' : 'Price ($)' }} *</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $service->price) }}" min="0" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                @error('price')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'الوصف (بالعربية)' : 'Description (Arabic)' }} *</label>
                <textarea name="description_ar" rows="3" required class="w-full text-sm rounded-xl border border-slate-200 p-3.5 focus:outline-none focus:ring-2 focus:ring-medical-500">{{ old('description_ar', $service->description_ar) }}</textarea>
                @error('description_ar')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'الوصف (بالإنجليزية)' : 'Description (English)' }} *</label>
                <textarea name="description_en" rows="3" required class="w-full text-sm rounded-xl border border-slate-200 p-3.5 focus:outline-none focus:ring-2 focus:ring-medical-500">{{ old('description_en', $service->description_en) }}</textarea>
                @error('description_en')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center gap-4">
                <img src="{{ $service->image_url }}" alt="" class="w-14 h-14 rounded-2xl object-cover border border-slate-200 shrink-0">
                <div class="w-full">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'تغيير الصورة' : 'Change Image' }}</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-medical-50 file:text-medical-700 hover:file:bg-medical-100">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'ترتيب الظهور' : 'Sort Order' }}</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $service->sort_order) }}" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
            </div>

            <div class="md:col-span-2 pt-2">
                <label class="flex items-center gap-2.5 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }} class="w-4 h-4 text-medical-600 rounded border-slate-300 focus:ring-medical-500">
                    <span class="text-xs font-bold text-slate-700">{{ app()->getLocale() === 'ar' ? 'الخدمة متاحة ونشطة للحجز المباشر' : 'Service is Active for Online Booking' }}</span>
                </label>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.services.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition">
                {{ app()->getLocale() === 'ar' ? 'إلغاء' : 'Cancel' }}
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-medical-600 hover:bg-medical-700 text-white font-bold text-sm shadow-md shadow-medical-600/20 transition">
                {{ app()->getLocale() === 'ar' ? 'حفظ التعديلات' : 'Update Service' }}
            </button>
        </div>
    </form>
</div>
@endsection
