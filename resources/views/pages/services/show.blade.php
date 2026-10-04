@extends('layouts.app')

@section('title', $service->name)

@section('content')
<div class="bg-gradient-to-b from-medical-50 to-white py-12 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2 text-xs text-slate-500 mb-4">
            <a href="{{ route('home') }}" class="hover:text-medical-600">{{ __('app.home') }}</a>
            <span>/</span>
            <a href="{{ route('services.index') }}" class="hover:text-medical-600">{{ __('app.services') }}</a>
            <span>/</span>
            <span class="text-navy-900 font-semibold">{{ $service->name }}</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-navy-900 tracking-tight">{{ $service->name }}</h1>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <div class="lg:col-span-2 space-y-8">
            <div class="rounded-3xl overflow-hidden shadow-md border border-slate-100">
                <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="w-full h-[380px] object-cover">
            </div>

            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm space-y-4">
                <h3 class="text-xl font-bold text-navy-900">{{ app()->getLocale() === 'ar' ? 'عن هذه الخدمة الطبية' : 'About this Procedure' }}</h3>
                <div class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">
                    {{ $service->description }}
                </div>
            </div>

            <!-- Doctors performing this service -->
            @if($service->doctors->count() > 0)
                <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                    <h3 class="text-xl font-bold text-navy-900 mb-6">{{ app()->getLocale() === 'ar' ? 'الأطباء المتخصصون في هذه الخدمة' : 'Doctors Performing this Service' }}</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($service->doctors as $doc)
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                <img src="{{ $doc->image_url }}" alt="{{ $doc->name }}" class="w-14 h-14 rounded-full object-cover">
                                <div>
                                    <h4 class="font-bold text-navy-900 text-sm">{{ $doc->name }}</h4>
                                    <p class="text-xs text-medical-600">{{ $doc->specialization }}</p>
                                    <a href="{{ route('appointments.create', ['service_id' => $service->id, 'doctor_id' => $doc->id]) }}" class="inline-block text-xs font-bold text-medical-700 hover:underline mt-1">
                                        {{ app()->getLocale() === 'ar' ? 'احجز مع الطبيب' : 'Book with Doctor' }} &rarr;
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar Summary & Booking CTA -->
        <div class="space-y-6">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-lg space-y-6">
                <h3 class="text-lg font-bold text-navy-900 pb-4 border-b border-slate-100">{{ app()->getLocale() === 'ar' ? 'تفاصيل الخدمة' : 'Procedure Summary' }}</h3>
                <div class="space-y-4 text-sm">
                    <div class="flex justify-between items-center py-2 border-b border-slate-100">
                        <span class="text-slate-500">{{ app()->getLocale() === 'ar' ? 'مدة الجلسة التقريبية' : 'Estimated Duration' }}</span>
                        <span class="font-bold text-navy-900">{{ $service->duration }} {{ app()->getLocale() === 'ar' ? 'دقيقة' : 'minutes' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-100">
                        <span class="text-slate-500">{{ app()->getLocale() === 'ar' ? 'التكلفة الاسترشادية' : 'Consultation / Fee' }}</span>
                        <span class="text-2xl font-black text-medical-600">${{ number_format($service->price, 2) }}</span>
                    </div>
                </div>

                <a href="{{ route('appointments.create', ['service_id' => $service->id]) }}" class="w-full inline-flex items-center justify-center gap-2 py-4 px-6 rounded-2xl bg-gradient-to-r from-medical-600 to-medical-500 text-white font-extrabold text-sm shadow-xl shadow-medical-500/25 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>{{ __('app.appointments') }}</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
