@extends('layouts.app')

@section('title', __('app.login'))

@section('content')
<div class="py-16 sm:py-24">
    <div class="max-w-md mx-auto px-4 sm:px-6">
        <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-xl shadow-slate-200/60 border border-slate-100">
            <div class="text-center mb-8">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-medical-600 to-medical-400 flex items-center justify-center text-white mx-auto mb-4 shadow-lg shadow-medical-500/25">
                    <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18.8 4c-1.7-1.4-4-1.2-5.7.4-.6.6-1.6.6-2.2 0C9.2 2.8 6.9 2.6 5.2 4 2.8 6 2.2 9.5 3.3 12.3c.9 2.2 2.1 4.3 3.3 6.3 1.2 2.1 2.3 3.4 3.4 3.4.4 0 .9-.3 1.3-.9.9-1.3 1.4-2.8 1.7-4.4.1-.4.5-.7.9-.7s.8.3.9.7c.3 1.6.8 3.1 1.7 4.4.4.6.9.9 1.3.9 1.1 0 2.2-1.3 3.4-3.4 1.2-2 2.4-4.1 3.3-6.3 1.1-2.8.5-6.3-1.7-8.3z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'تسجيل الدخول' : 'Welcome Back' }}</h2>
                <p class="text-slate-500 text-sm mt-1.5">{{ app()->getLocale() === 'ar' ? 'أدخل بريدك الإلكتروني وكلمة المرور للمتابعة' : 'Enter your credentials to access your account' }}</p>
            </div>

            <!-- Demo Credentials Helper Banner for CV / Reviewers -->
            <div class="mb-6 p-3.5 rounded-2xl bg-medical-50 border border-medical-200 text-xs text-navy-900">
                <p class="font-bold text-medical-800 mb-1 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-medical-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ app()->getLocale() === 'ar' ? 'حسابات التجربة السريعة (Seeded Accounts):' : 'Demo Test Credentials:' }}</span>
                </p>
                <div class="space-y-0.5 text-slate-600 font-mono text-[11px]">
                    <div><strong>Admin:</strong> admin@dentcare.com / password</div>
                    <div><strong>Doctor:</strong> doctor1@dentcare.com / password</div>
                    <div><strong>Patient:</strong> patient1@dentcare.com / password</div>
                </div>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('app.email') }}</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500 text-sm transition"
                           placeholder="name@example.com">
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">{{ app()->getLocale() === 'ar' ? 'كلمة المرور' : 'Password' }}</label>
                    </div>
                    <input type="password" id="password" name="password" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500 text-sm transition"
                           placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded text-medical-600 focus:ring-medical-500 border-slate-300">
                        <span class="text-xs text-slate-600">{{ app()->getLocale() === 'ar' ? 'تذكرني' : 'Remember me' }}</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-3.5 px-4 rounded-xl bg-gradient-to-r from-medical-600 to-medical-500 hover:from-medical-700 hover:to-medical-600 text-white font-bold text-sm shadow-md shadow-medical-500/25 transition">
                    {{ __('app.login') }}
                </button>
            </form>

            <div class="mt-8 text-center text-xs text-slate-500 border-t border-slate-100 pt-6">
                <span>{{ app()->getLocale() === 'ar' ? 'ليس لديك حساب مريض؟' : "Don't have a patient account?" }}</span>
                <a href="{{ route('register') }}" class="text-medical-600 font-bold hover:underline {{ app()->getLocale() === 'ar' ? 'mr-1' : 'ml-1' }}">
                    {{ app()->getLocale() === 'ar' ? 'سجل الآن مجاناً' : 'Create an account' }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
