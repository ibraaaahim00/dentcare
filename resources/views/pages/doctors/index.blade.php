@extends('layouts.app')

@section('title', __('app.doctors'))

@section('content')
<div class="bg-gradient-to-b from-medical-50 to-white py-16 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="text-medical-600 font-bold text-xs uppercase tracking-wider block mb-2">{{ app()->getLocale() === 'ar' ? 'فريقنا الطبي' : 'Certified Specialists' }}</span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-navy-900 tracking-tight">{{ __('app.doctors') }}</h1>
        <p class="text-slate-500 text-sm sm:text-base mt-3 max-w-xl mx-auto">
            {{ app()->getLocale() === 'ar' ? 'تعرف على كفاءات وخبرات أطباء عيادة دنت كير واحجز موعدك مع الطبيب المناسب.' : 'Discover our experienced doctors, dentists, and oral surgeons.' }}
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($doctors as $doctor)
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                <div>
                    <div class="w-32 h-32 mx-auto rounded-full overflow-hidden mb-5 border-4 border-slate-50 shadow-md">
                        <img src="{{ $doctor->image_url }}" alt="{{ $doctor->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    </div>
                    <div class="text-center">
                        <h3 class="text-xl font-bold text-navy-900 mb-1">{{ $doctor->name }}</h3>
                        <p class="text-xs font-bold text-medical-600 mb-2">{{ $doctor->specialization }}</p>
                        <div class="flex items-center justify-center gap-1 text-amber-400 text-xs mb-3">
                            <span>★</span>
                            <span class="font-bold text-slate-700">{{ $doctor->average_rating }}</span>
                            <span class="text-slate-400">({{ $doctor->reviews_count }})</span>
                        </div>
                        <p class="text-slate-500 text-xs line-clamp-3 leading-relaxed mb-4">{{ $doctor->bio }}</p>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <span class="text-[11px] text-slate-400 block">{{ app()->getLocale() === 'ar' ? 'كشفية الاستشارة' : 'Consultation' }}</span>
                        <span class="text-base font-bold text-navy-900">${{ number_format($doctor->consultation_fee, 2) }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('doctors.show', $doctor->id) }}" class="px-3 py-2 border border-slate-200 text-slate-700 hover:bg-slate-50 rounded-xl text-xs font-bold transition">
                            {{ __('app.view') }}
                        </a>
                        <a href="{{ route('appointments.create', ['doctor_id' => $doctor->id]) }}" class="px-3.5 py-2 bg-medical-600 hover:bg-medical-700 text-white rounded-xl text-xs font-bold shadow-md shadow-medical-600/20 transition">
                            {{ __('app.appointments') }}
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
