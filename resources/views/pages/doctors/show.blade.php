@extends('layouts.app')

@section('title', $doctor->name)

@section('content')
<div class="bg-gradient-to-b from-medical-50 to-white py-12 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2 text-xs text-slate-500 mb-4">
            <a href="{{ route('home') }}" class="hover:text-medical-600">{{ __('app.home') }}</a>
            <span>/</span>
            <a href="{{ route('doctors.index') }}" class="hover:text-medical-600">{{ __('app.doctors') }}</a>
            <span>/</span>
            <span class="text-navy-900 font-semibold">{{ $doctor->name }}</span>
        </div>
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
            <img src="{{ $doctor->image_url }}" alt="{{ $doctor->name }}" class="w-32 h-32 rounded-3xl object-cover shadow-lg border-4 border-white">
            <div class="text-center sm:{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} space-y-2">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-navy-900">{{ $doctor->name }}</h1>
                <p class="text-base text-medical-600 font-bold">{{ $doctor->specialization }}</p>
                <div class="flex items-center justify-center sm:justify-start gap-3 text-xs text-slate-500">
                    <span>{{ $doctor->experience_years }} {{ app()->getLocale() === 'ar' ? 'سنوات خبرة سريرية' : 'Years Experience' }}</span>
                    <span>•</span>
                    <span class="text-amber-500 font-bold">★ {{ $doctor->average_rating }} ({{ $doctor->reviews_count }} {{ app()->getLocale() === 'ar' ? 'تقييم' : 'reviews' }})</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <div class="lg:col-span-2 space-y-8">
            <!-- Biography -->
            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm space-y-4">
                <h3 class="text-xl font-bold text-navy-900">{{ app()->getLocale() === 'ar' ? 'نبذة عن الطبيب' : 'About the Specialist' }}</h3>
                <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">{{ $doctor->bio }}</p>
            </div>

            <!-- Qualifications -->
            @if($doctor->qualifications)
                <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm space-y-4">
                    <h3 class="text-xl font-bold text-navy-900">{{ app()->getLocale() === 'ar' ? 'المؤهلات والشهادات العلمية' : 'Qualifications & Credentials' }}</h3>
                    <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">{{ $doctor->qualifications }}</p>
                </div>
            @endif

            <!-- Services Provided -->
            @if($doctor->services->count() > 0)
                <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                    <h3 class="text-xl font-bold text-navy-900 mb-4">{{ app()->getLocale() === 'ar' ? 'الخدمات الطبية التي يقدمها' : 'Provided Dental Procedures' }}</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($doctor->services as $srv)
                            <span class="px-3.5 py-1.5 rounded-full bg-medical-50 text-medical-700 text-xs font-semibold border border-medical-100">
                                {{ $srv->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Booking Sidebar Card -->
        <div>
            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-xl space-y-6 sticky top-28">
                <h3 class="text-lg font-bold text-navy-900 pb-4 border-b border-slate-100">{{ app()->getLocale() === 'ar' ? 'احجز استشارتك' : 'Book a Consultation' }}</h3>
                <div class="flex justify-between items-center py-2">
                    <span class="text-slate-500 text-sm">{{ app()->getLocale() === 'ar' ? 'رسوم الاستشارة' : 'Consultation Fee' }}</span>
                    <span class="text-2xl font-black text-medical-600">${{ number_format($doctor->consultation_fee, 2) }}</span>
                </div>
                <a href="{{ route('appointments.create', ['doctor_id' => $doctor->id]) }}" class="w-full inline-flex items-center justify-center gap-2 py-4 px-6 rounded-2xl bg-gradient-to-r from-medical-600 to-medical-500 text-white font-extrabold text-sm shadow-xl shadow-medical-500/25 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>{{ app()->getLocale() === 'ar' ? 'احجز موعداً مع هذا الطبيب' : 'Book Appointment' }}</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
