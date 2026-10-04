@extends('layouts.app')

@section('title', __('app.about'))

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-b from-medical-50 to-white py-16 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="text-medical-600 font-bold text-xs uppercase tracking-wider block mb-2">{{ app()->getLocale() === 'ar' ? 'تعرف علينا' : 'About DentCare' }}</span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-navy-900 tracking-tight">{{ __('app.about') }}</h1>
        <p class="text-slate-500 text-sm sm:text-base mt-3 max-w-2xl mx-auto leading-relaxed">
            {{ app()->getLocale() === 'ar' ? 'رؤيتنا ورسالتنا في تقديم أفضل معايير الرعاية الصحية للفم والأسنان لجميع أفراد الأسرة.' : 'Committed to delivering world-class dental care with compassion, artistry, and cutting-edge technology.' }}
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-20">
    <!-- Story & Mission -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div class="space-y-6">
            <span class="text-xs font-bold text-medical-600 uppercase tracking-wider block">{{ app()->getLocale() === 'ar' ? 'قصتنا ورسالتنا' : 'Our Story' }}</span>
            <h2 class="text-3xl font-extrabold text-navy-900 leading-snug">
                {{ app()->getLocale() === 'ar' ? 'نبني الابتسامات بثقة، خبرة، وتقنيات لا تضاهى' : 'Building Confident Smiles with Clinical Precision' }}
            </h2>
            <p class="text-slate-600 text-sm leading-relaxed">
                {{ app()->getLocale() === 'ar' ? 'تأسست عيادة دنت كير بهدف تقديم تجربة علاجية فريدة تقضي على هاجس الخوف من عيادات الأسنان، من خلال الجمع بين أرقى الكفاءات الطبية والتقنيات الرقمية ثلاثية الأبعاد والليزر المتقدم.' : 'DentCare was founded on a simple philosophy: dental care should be gentle, transparent, and built around each patient’s unique health and aesthetic goals.' }}
            </p>
            <div class="grid grid-cols-2 gap-6 pt-4 border-t border-slate-100">
                <div>
                    <h4 class="font-bold text-navy-900 text-base mb-1">{{ app()->getLocale() === 'ar' ? 'رؤيتنا' : 'Our Vision' }}</h4>
                    <p class="text-slate-500 text-xs leading-relaxed">{{ app()->getLocale() === 'ar' ? 'أن نكون المركز الرائد والأكثر ثقة لطب وتجميل الأسنان إقليمياً.' : 'To be the most trusted and forward-thinking dental center in the region.' }}</p>
                </div>
                <div>
                    <h4 class="font-bold text-navy-900 text-base mb-1">{{ app()->getLocale() === 'ar' ? 'رسالتنا' : 'Our Mission' }}</h4>
                    <p class="text-slate-500 text-xs leading-relaxed">{{ app()->getLocale() === 'ar' ? 'توفير رعاية وقائية وعلاجية مريحة تلبي أعلى معايير الجودة العالمية.' : 'Delivering preventative and aesthetic dentistry using the most hygienic practices.' }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-3xl overflow-hidden shadow-2xl border-4 border-white">
            <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?w=800&auto=format&fit=crop&q=80" alt="Clinic Team" class="w-full h-[400px] object-cover">
        </div>
    </div>

    <!-- Doctors Preview -->
    <div>
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h2 class="text-3xl font-extrabold text-navy-900">{{ app()->getLocale() === 'ar' ? 'الفريق الاستشاري المتخصص' : 'Our Specialists' }}</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($doctors as $doctor)
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm text-center">
                    <img src="{{ $doctor->image_url }}" alt="{{ $doctor->name }}" class="w-24 h-24 rounded-full mx-auto mb-4 object-cover">
                    <h3 class="font-bold text-navy-900 text-base">{{ $doctor->name }}</h3>
                    <p class="text-xs text-medical-600 font-semibold mb-3">{{ $doctor->specialization }}</p>
                    <a href="{{ route('doctors.show', $doctor->id) }}" class="inline-block text-xs font-bold text-slate-700 hover:text-medical-600 underline">
                        {{ __('app.view') }} &rarr;
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
