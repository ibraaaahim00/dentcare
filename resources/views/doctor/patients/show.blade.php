@extends('layouts.doctor')

@section('title', 'الملف الطبي للمريض: ' . $patient->name)
@section('page_title', 'الملف الطبي للمريض: ' . $patient->name)

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-2 text-xs text-slate-500">
        <a href="{{ route('doctor.patients.index') }}" class="hover:text-medical-600">&larr; {{ app()->getLocale() === 'ar' ? 'العودة لقائمة المرضى' : 'Back to Patients' }}</a>
    </div>

    <!-- Patient Header Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm flex items-center gap-5">
        <img src="{{ $patient->avatar_url }}" alt="" class="w-16 h-16 rounded-2xl object-cover border-2 border-slate-100">
        <div>
            <h2 class="text-xl font-bold text-navy-900">{{ $patient->name }}</h2>
            <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500 mt-1">
                <span dir="ltr">{{ $patient->phone }}</span>
                <span>•</span>
                <span>{{ $patient->email }}</span>
                <span>•</span>
                <span>{{ $patient->gender?->label() ?? 'Gender N/A' }}</span>
                <span>•</span>
                <span>{{ $patient->date_of_birth?->format('Y-m-d') ?? 'DOB N/A' }}</span>
            </div>
        </div>
    </div>

    <!-- Medical Records List -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm space-y-6">
        <div class="flex justify-between items-center">
            <h3 class="font-bold text-navy-900 text-lg">{{ app()->getLocale() === 'ar' ? 'السجلات والتقارير الطبية المحررة' : 'Clinical Medical History' }}</h3>
        </div>

        @if($medicalRecords->count() > 0)
            <div class="space-y-4">
                @foreach($medicalRecords as $record)
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="px-3 py-1 rounded-full bg-medical-100 text-medical-800 text-xs font-bold">
                                {{ $record->treatment_date->format('Y-m-d') }}
                            </span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                            <div>
                                <span class="text-slate-400 block font-bold mb-1 uppercase">{{ app()->getLocale() === 'ar' ? 'التشخيص الطبي' : 'Diagnosis' }}</span>
                                <p class="text-slate-800 font-medium bg-white p-3 rounded-xl border border-slate-100">{{ $record->diagnosis }}</p>
                            </div>
                            <div>
                                <span class="text-slate-400 block font-bold mb-1 uppercase">{{ app()->getLocale() === 'ar' ? 'الإجراء العلاجي' : 'Treatment' }}</span>
                                <p class="text-slate-800 font-medium bg-white p-3 rounded-xl border border-slate-100">{{ $record->treatment }}</p>
                            </div>
                        </div>
                        @if($record->notes)
                            <div class="text-xs bg-medical-50/60 p-3 rounded-xl text-medical-900">
                                <span class="font-bold block mb-0.5">{{ app()->getLocale() === 'ar' ? 'الملاحظات:' : 'Notes:' }}</span>
                                {{ $record->notes }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-8 text-center bg-slate-50 rounded-2xl text-xs text-slate-400">
                {{ app()->getLocale() === 'ar' ? 'لم يتم تحرير سجلات طبية لهذا المريض حتى الآن.' : 'No medical records documented yet.' }}
            </div>
        @endif
    </div>
</div>
@endsection
