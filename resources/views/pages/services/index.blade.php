@extends('layouts.app')

@section('title', __('app.services'))

@section('content')
<div class="bg-gradient-to-b from-medical-50 to-white py-16 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="text-medical-600 font-bold text-xs uppercase tracking-wider block mb-2">{{ app()->getLocale() === 'ar' ? 'خدمات احترافية' : 'Comprehensive Treatments' }}</span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-navy-900 tracking-tight">{{ __('app.services') }}</h1>
        <p class="text-slate-500 text-sm sm:text-base mt-3 max-w-xl mx-auto">
            {{ app()->getLocale() === 'ar' ? 'جميع خدمات طب وتجميل وجراحة الأسنان بأحدث التقنيات وأفضل الأسعار.' : 'Complete restorative, preventative, and cosmetic dental treatments.' }}
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($services as $service)
            <div class="bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group">
                <div class="h-52 overflow-hidden relative">
                    <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    <span class="absolute top-4 {{ app()->getLocale() === 'ar' ? 'left-4' : 'right-4' }} bg-navy-900/80 backdrop-blur-md text-white text-xs font-bold px-3 py-1 rounded-full">
                        {{ $service->duration }} {{ app()->getLocale() === 'ar' ? 'دقيقة' : 'min' }}
                    </span>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <a href="{{ route('services.show', $service->slug) }}">
                            <h3 class="text-xl font-bold text-navy-900 mb-2 group-hover:text-medical-600 transition">{{ $service->name }}</h3>
                        </a>
                        <p class="text-slate-500 text-sm line-clamp-3 leading-relaxed mb-6">{{ $service->description }}</p>
                    </div>
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-400 block">{{ app()->getLocale() === 'ar' ? 'السعر' : 'Price' }}</span>
                            <span class="text-lg font-black text-medical-600">${{ number_format($service->price, 2) }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('services.show', $service->slug) }}" class="px-3.5 py-2 border border-slate-200 text-slate-700 hover:bg-slate-50 rounded-xl text-xs font-bold transition">
                                {{ __('app.view') }}
                            </a>
                            <a href="{{ route('appointments.create', ['service_id' => $service->id]) }}" class="px-4 py-2 bg-medical-600 hover:bg-medical-700 text-white rounded-xl text-xs font-bold shadow-md shadow-medical-600/20 transition">
                                {{ __('app.appointments') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
