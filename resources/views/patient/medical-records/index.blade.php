@extends('layouts.patient')

@section('title', app()->getLocale() === 'ar' ? 'سجلاتي الطبية' : 'My Medical Records')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-extrabold text-navy-900">{{ app()->getLocale() === 'ar' ? 'ملفي وسجلاتي الطبية' : 'Dental Medical Records' }}</h1>
        <p class="text-xs text-slate-500 mt-1">{{ app()->getLocale() === 'ar' ? 'سجل التشخيصات والإجراءات الطبية المسجلة من قبل أطبائك' : 'Historical clinical diagnoses, treatments and dentist notes' }}</p>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        @if($records->count() > 0)
            <div class="divide-y divide-slate-100">
                @foreach($records as $rec)
                    <div class="p-6 hover:bg-slate-50/50 transition space-y-3">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                            <div class="flex items-center gap-3">
                                <span class="px-3 py-1 rounded-full bg-medical-50 text-medical-700 font-bold text-xs">
                                    {{ $rec->treatment_date->format('Y-m-d') }}
                                </span>
                                <h3 class="font-bold text-navy-900 text-sm">{{ $rec->doctor->name }}</h3>
                            </div>
                            <span class="text-xs text-slate-400">{{ $rec->appointment?->service->name }}</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                            <div class="p-3 bg-slate-50 rounded-xl">
                                <span class="font-bold text-slate-400 block mb-1 uppercase">{{ app()->getLocale() === 'ar' ? 'التشخيص' : 'Diagnosis' }}</span>
                                <p class="text-slate-800 font-medium">{{ $rec->diagnosis }}</p>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-xl">
                                <span class="font-bold text-slate-400 block mb-1 uppercase">{{ app()->getLocale() === 'ar' ? 'العلاج المنجز' : 'Treatment' }}</span>
                                <p class="text-slate-800 font-medium">{{ $rec->treatment }}</p>
                            </div>
                        </div>

                        @if($rec->notes)
                            <div class="p-3 bg-medical-50/60 rounded-xl text-xs text-medical-900">
                                <span class="font-bold block mb-0.5">{{ app()->getLocale() === 'ar' ? 'توصيات الطبيب:' : 'Recommendations:' }}</span>
                                {{ $rec->notes }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="p-6 border-t border-slate-100">
                {{ $records->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <p class="text-slate-400 text-sm">{{ app()->getLocale() === 'ar' ? 'لا توجد سجلات طبية مسجلة حتى الآن.' : 'No medical records found.' }}</p>
            </div>
        @endif
    </div>
</div>
@endsection
