@extends('layouts.patient')

@section('title', app()->getLocale() === 'ar' ? 'الملف الشخصي' : 'Profile Settings')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div>
        <h1 class="text-2xl font-extrabold text-navy-900">{{ app()->getLocale() === 'ar' ? 'الملف الشخصي' : 'Account Profile' }}</h1>
        <p class="text-xs text-slate-500 mt-1">{{ app()->getLocale() === 'ar' ? 'تعديل بيانات الاتصال وكلمة المرور' : 'Update your personal contact details and password' }}</p>
    </div>

    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm">
        <form method="POST" action="{{ route('patient.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Avatar -->
            <div class="flex items-center gap-6">
                <img src="{{ $user->avatar_url }}" alt="Avatar" class="w-20 h-20 rounded-full object-cover border-2 border-slate-200">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-2">{{ app()->getLocale() === 'ar' ? 'تغيير الصورة الشخصية' : 'Change Avatar' }}</label>
                    <input type="file" name="avatar" class="text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-medical-50 file:text-medical-700 hover:file:bg-medical-100">
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">{{ app()->getLocale() === 'ar' ? 'الاسم' : 'Name' }}</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">{{ __('app.email') }}</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500">
                    </div>
                    <div>
                        <label for="phone" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">{{ __('app.phone') }}</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required dir="ltr"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="gender" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">{{ app()->getLocale() === 'ar' ? 'الجنس' : 'Gender' }}</label>
                        <select id="gender" name="gender" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white">
                            <option value="">--</option>
                            <option value="male" {{ old('gender', $user->gender?->value) === 'male' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'ذكر' : 'Male' }}</option>
                            <option value="female" {{ old('gender', $user->gender?->value) === 'female' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'أنثى' : 'Female' }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="date_of_birth" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">{{ app()->getLocale() === 'ar' ? 'تاريخ الميلاد' : 'Date of Birth' }}</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white">
                    </div>
                </div>
            </div>

            <!-- Password Change Section -->
            <div class="pt-6 border-t border-slate-100 space-y-4">
                <h3 class="font-bold text-navy-900 text-sm">{{ app()->getLocale() === 'ar' ? 'تغيير كلمة المرور (اختياري)' : 'Change Password (Optional)' }}</h3>

                <div>
                    <label for="current_password" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">{{ app()->getLocale() === 'ar' ? 'كلمة المرور الحالية' : 'Current Password' }}</label>
                    <input type="password" id="current_password" name="current_password"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="new_password" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">{{ app()->getLocale() === 'ar' ? 'كلمة المرور الجديدة' : 'New Password' }}</label>
                        <input type="password" id="new_password" name="new_password"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
                    </div>
                    <div>
                        <label for="new_password_confirmation" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">{{ app()->getLocale() === 'ar' ? 'تأكيد الجديدة' : 'Confirm Password' }}</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
                    </div>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="px-6 py-3 bg-medical-600 hover:bg-medical-700 text-white font-bold text-xs rounded-xl shadow-md transition">
                    {{ __('app.save') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
