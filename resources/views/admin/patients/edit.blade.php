@extends('layouts.admin')

@section('title', (app()->getLocale() === 'ar' ? 'تعديل بيانات المريض: ' : 'Edit Patient: ') . $patient->name)

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'تعديل بيانات المريض' : 'Edit Patient Profile' }}</h1>
            <p class="text-xs text-slate-500 mt-1">{{ $patient->name }} &bull; ID: #{{ $patient->id }}</p>
        </div>
        <a href="{{ route('admin.patients.show', $patient->id) }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
            &larr; {{ app()->getLocale() === 'ar' ? 'العودة للملف' : 'Back' }}
        </a>
    </div>

    <form action="{{ route('admin.patients.update', $patient->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 lg:p-8 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'الاسم الكامل' : 'Full Name' }} *</label>
                <input type="text" name="name" value="{{ old('name', $patient->name) }}" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                @error('name')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني' : 'Email Address' }} *</label>
                <input type="email" name="email" value="{{ old('email', $patient->email) }}" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                @error('email')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'رقم الهاتف' : 'Phone Number' }} *</label>
                <input type="text" name="phone" value="{{ old('phone', $patient->phone) }}" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                @error('phone')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'الجنس' : 'Gender' }}</label>
                <select name="gender" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    <option value="">{{ app()->getLocale() === 'ar' ? 'غير محدد' : 'Not Specified' }}</option>
                    <option value="male" {{ old('gender', $patient->gender?->value) === 'male' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'ذكر' : 'Male' }}</option>
                    <option value="female" {{ old('gender', $patient->gender?->value) === 'female' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'أنثى' : 'Female' }}</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'تاريخ الميلاد' : 'Date of Birth' }}</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $patient->date_of_birth?->format('Y-m-d')) }}" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'كلمة المرور الجديدة (اختياري)' : 'New Password (Optional)' }}</label>
                <input type="password" name="password" placeholder="{{ app()->getLocale() === 'ar' ? 'اتركه فارغاً للحفاظ على كلمة المرور الحالية' : 'Leave empty to keep current password' }}" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                @error('password')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2 flex items-center gap-4 pt-2">
                <img src="{{ $patient->avatar_url }}" alt="{{ $patient->name }}" class="w-14 h-14 rounded-2xl object-cover border border-slate-200">
                <div class="flex-1">
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'تحديث الصورة الرمزية' : 'Update Avatar' }}</label>
                    <input type="file" name="avatar" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-medical-50 file:text-medical-700 hover:file:bg-medical-100">
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.patients.show', $patient->id) }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition">
                {{ app()->getLocale() === 'ar' ? 'إلغاء' : 'Cancel' }}
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-medical-600 hover:bg-medical-700 text-white font-bold text-sm shadow-md shadow-medical-600/20 transition">
                {{ app()->getLocale() === 'ar' ? 'حفظ التعديلات' : 'Update Profile' }}
            </button>
        </div>
    </form>
</div>
@endsection
