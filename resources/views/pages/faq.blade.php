@extends('layouts.app')

@section('title', __('app.faq'))

@section('content')
<div class="bg-gradient-to-b from-medical-50 to-white py-16 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="text-medical-600 font-bold text-xs uppercase tracking-wider block mb-2">{{ app()->getLocale() === 'ar' ? 'إجابات فورية' : 'Quick Answers' }}</span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-navy-900 tracking-tight">{{ __('app.faq') }}</h1>
        <p class="text-slate-500 text-sm sm:text-base mt-3 max-w-xl mx-auto">
            {{ app()->getLocale() === 'ar' ? 'أكثر الأسئلة تكراراً حول خدماتنا، أوقات العمل، وسياسة الحجز والتأمين.' : 'Frequently asked questions about our treatments, booking policies, and dental health.' }}
        </p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="space-y-4" x-data="{ active: null }">
        @foreach($faqs as $index => $faq)
            <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm transition">
                <button type="button" @click="active = (active === {{ $index }} ? null : {{ $index }})"
                        class="w-full p-5 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} flex items-center justify-between gap-4 font-bold text-navy-900 text-base hover:text-medical-600 transition">
                    <span>{{ $faq->question }}</span>
                    <svg class="w-5 h-5 text-medical-600 shrink-0 transition-transform duration-200"
                         :class="{ 'rotate-180': active === {{ $index }} }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="active === {{ $index }}" x-cloak class="px-5 pb-5 text-sm text-slate-600 leading-relaxed border-t border-slate-50 pt-3">
                    {{ $faq->answer }}
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
