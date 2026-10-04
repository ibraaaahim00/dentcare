@extends('layouts.app')

@section('title', __('app.contact'))

@section('content')
<div class="bg-gradient-to-b from-medical-50 to-white py-16 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="text-medical-600 font-bold text-xs uppercase tracking-wider block mb-2">{{ app()->getLocale() === 'ar' ? 'يسعدنا تواصلكم' : 'Get In Touch' }}</span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-navy-900 tracking-tight">{{ __('app.contact') }}</h1>
        <p class="text-slate-500 text-sm sm:text-base mt-3 max-w-xl mx-auto">
            {{ app()->getLocale() === 'ar' ? 'فريق خدمة العملاء متواجد دائماً للإجابة على استفساراتكم ومساعدتكم.' : 'Have a question or inquiry? Reach out and our team will get back promptly.' }}
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Contact Information Cards -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm space-y-6">
                <h3 class="text-xl font-bold text-navy-900">{{ app()->getLocale() === 'ar' ? 'معلومات الاتصال المباشر' : 'Direct Contact Info' }}</h3>
                
                <div class="space-y-5 text-sm">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-medical-50 text-medical-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase">{{ __('app.address') }}</span>
                            <span class="font-semibold text-navy-900">{{ app()->getLocale() === 'ar' ? 'طريق الملك فهد، الرياض، المملكة العربية السعودية' : 'King Fahd Road, Riyadh, Saudi Arabia' }}</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-medical-50 text-medical-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase">{{ __('app.phone') }}</span>
                            <span class="font-semibold text-navy-900" dir="ltr">+966 12 345 6789</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-medical-50 text-medical-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase">{{ __('app.email') }}</span>
                            <span class="font-semibold text-navy-900">contact@dentcare-clinic.com</span>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100">
                    <h4 class="font-bold text-navy-900 text-sm mb-3">{{ __('app.working_hours') }}</h4>
                    <div class="space-y-1.5 text-xs text-slate-500">
                        @foreach($workingHours as $wh)
                            <div class="flex justify-between py-1">
                                <span>{{ $wh->localized_day_name }}</span>
                                @if($wh->is_closed)
                                    <span class="text-rose-500 font-bold">{{ app()->getLocale() === 'ar' ? 'مغلق' : 'Closed' }}</span>
                                @else
                                    <span class="font-semibold text-navy-900" dir="ltr">{{ substr($wh->start_time, 0, 5) }} - {{ substr($wh->end_time, 0, 5) }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="lg:col-span-7">
            <div class="bg-white rounded-3xl p-8 sm:p-10 border border-slate-100 shadow-xl shadow-slate-200/50">
                <h3 class="text-2xl font-bold text-navy-900 mb-6">{{ app()->getLocale() === 'ar' ? 'أرسل لنا رسالة مباشرة' : 'Send us a Message' }}</h3>

                <form method="POST" action="{{ route('contact.store') }}" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ app()->getLocale() === 'ar' ? 'الاسم بالكامل' : 'Your Name' }}</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500 transition">
                        </div>
                        <div>
                            <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('app.email') }}</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500 transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('app.phone') }}</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" dir="ltr"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500 transition">
                        </div>
                        <div>
                            <label for="subject" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ app()->getLocale() === 'ar' ? 'موضوع الرسالة' : 'Subject' }}</label>
                            <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500 transition">
                        </div>
                    </div>

                    <div>
                        <label for="message" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ app()->getLocale() === 'ar' ? 'نص الرسالة' : 'Your Message' }}</label>
                        <textarea id="message" name="message" rows="5" required
                                  class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500 transition"
                                  placeholder="{{ app()->getLocale() === 'ar' ? 'اكتب تفاصيل استفسارك هنا...' : 'Write your question or request here...' }}">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-medical-600 to-medical-500 hover:from-medical-700 hover:to-medical-600 text-white font-bold text-sm shadow-xl shadow-medical-500/25 transition">
                        {{ app()->getLocale() === 'ar' ? 'إرسال الرسالة الآن' : 'Send Message' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
