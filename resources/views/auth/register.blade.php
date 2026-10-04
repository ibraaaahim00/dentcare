@extends('layouts.app')

@section('title', __('app.register'))

@section('content')
<div class="py-16 sm:py-24">
    <div class="max-w-lg mx-auto px-4 sm:px-6">
        <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-xl shadow-slate-200/60 border border-slate-100">
            <div class="text-center mb-8">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-medical-600 to-medical-400 flex items-center justify-center text-white mx-auto mb-4 shadow-lg shadow-medical-500/25">
                    <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18.8 4c-1.7-1.4-4-1.2-5.7.4-.6.6-1.6.6-2.2 0C9.2 2.8 6.9 2.6 5.2 4 2.8 6 2.2 9.5 3.3 12.3c.9 2.2 2.1 4.3 3.3 6.3 1.2 2.1 2.3 3.4 3.4 3.4.4 0 .9-.3 1.3-.9.9-1.3 1.4-2.8 1.7-4.4.1-.4.5-.7.9-.7s.8.3.9.7c.3 1.6.8 3.1 1.7 4.4.4.6.9.9 1.3.9 1.1 0 2.2-1.3 3.4-3.4 1.2-2 2.4-4.1 3.3-6.3 1.1-2.8.5-6.3-1.7-8.3z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'إنشاء حساب مريض جديد' : 'New Patient Registration' }}</h2>
                <p class="text-slate-500 text-sm mt-1.5">{{ app()->getLocale() === 'ar' ? 'سجل لتتمكن من حجز المواعيد ومتابعة ملفك الطبي' : 'Register to easily book and manage your dental appointments' }}</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">{{ app()->getLocale() === 'ar' ? 'الاسم بالكامل' : 'Full Name' }}</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500 text-sm transition"
                           placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: محمد أحمد' : 'e.g. John Doe' }}">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">{{ __('app.email') }}</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500 text-sm transition"
                               placeholder="name@example.com">
                    </div>
                    <div>
                        <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">{{ __('app.phone') }}</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500 text-sm transition"
                               placeholder="+966 50 000 0000" dir="ltr">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="gender" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">{{ app()->getLocale() === 'ar' ? 'الجنس' : 'Gender' }}</label>
                        <select id="gender" name="gender" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500 text-sm transition bg-white">
                            <option value="">--</option>
                            <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'ذكر' : 'Male' }}</option>
                            <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'أنثى' : 'Female' }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="date_of_birth" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">{{ app()->getLocale() === 'ar' ? 'تاريخ الميلاد' : 'Date of Birth' }}</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500 text-sm transition bg-white">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">{{ app()->getLocale() === 'ar' ? 'كلمة المرور' : 'Password' }}</label>
                        <input type="password" id="password" name="password" required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500 text-sm transition"
                               placeholder="••••••••">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">{{ app()->getLocale() === 'ar' ? 'تأكيد كلمة المرور' : 'Confirm Password' }}</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500 text-sm transition"
                               placeholder="••••••••">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3.5 px-4 rounded-xl bg-gradient-to-r from-medical-600 to-medical-500 hover:from-medical-700 hover:to-medical-600 text-white font-bold text-sm shadow-md shadow-medical-500/25 transition">
                        {{ __('app.register') }}
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center text-xs text-slate-500 border-t border-slate-100 pt-6">
                <span>{{ app()->getLocale() === 'ar' ? 'لديك حساب بالفعل؟' : 'Already have an account?' }}</span>
                <a href="{{ route('login') }}" class="text-medical-600 font-bold hover:underline {{ app()->getLocale() === 'ar' ? 'mr-1' : 'ml-1' }}">
                    {{ __('app.login') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
