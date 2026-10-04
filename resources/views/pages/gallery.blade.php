@extends('layouts.app')

@section('title', __('app.gallery'))

@section('content')
<div class="bg-gradient-to-b from-medical-50 to-white py-16 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="text-medical-600 font-bold text-xs uppercase tracking-wider block mb-2">{{ app()->getLocale() === 'ar' ? 'جولة بصرية' : 'Visual Tour' }}</span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-navy-900 tracking-tight">{{ __('app.gallery') }}</h1>
        <p class="text-slate-500 text-sm sm:text-base mt-3 max-w-xl mx-auto">
            {{ app()->getLocale() === 'ar' ? 'صور من داخل العيادة، غرف العلاج، وأحدث التجهيزات الطبية والنتائج.' : 'Explore our high-tech treatment suites, clinic amenities, and smile transformations.' }}
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    @if($galleryItems->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($galleryItems as $item)
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group border border-slate-100">
                    <div class="h-64 overflow-hidden relative">
                        <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-navy-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                            <span class="text-white text-sm font-bold">{{ $item->title }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="p-12 text-center bg-white rounded-3xl border border-slate-100">
            <p class="text-slate-400 text-sm">{{ app()->getLocale() === 'ar' ? 'لا توجد صور في المعرض حالياً.' : 'No gallery items available.' }}</p>
        </div>
    @endif
</div>
@endsection
