@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'إضافة سجل طبي جديد' : 'Create Medical Record')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'إضافة سجل طبي' : 'New Medical Record' }}</h1>
            <p class="text-xs text-slate-500 mt-1">{{ app()->getLocale() === 'ar' ? 'توثيق التشخيص والعلاج المتبع لمريض' : 'Document clinical diagnosis and treatment administered' }}</p>
        </div>
        <a href="{{ route('admin.medical-records.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
            &larr; {{ app()->getLocale() === 'ar' ? 'العودة' : 'Back' }}
        </a>
    </div>

    <form action="{{ route('admin.medical-records.store') }}" method="POST" class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 lg:p-8 space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'المريض' : 'Patient' }} *</label>
                <select name="patient_id" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    <option value="">{{ app()->getLocale() === 'ar' ? 'اختر المريض...' : 'Select Patient...' }}</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                            {{ $patient->name }} ({{ $patient->phone }})
                        </option>
                    @endforeach
                </select>
                @error('patient_id')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'الطبيب المعالج' : 'Doctor' }} *</label>
                <select name="doctor_id" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    <option value="">{{ app()->getLocale() === 'ar' ? 'اختر الطبيب...' : 'Select Doctor...' }}</option>
                    @foreach($doctors as $doc)
                        <option value="{{ $doc->id }}" {{ old('doctor_id') == $doc->id ? 'selected' : '' }}>
                            {{ $doc->user->name }} ({{ $doc->specialization }})
                        </option>
                    @endforeach
                </select>
                @error('doctor_id')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'الموعد المرتبط (اختياري)' : 'Linked Appointment (Optional)' }}</label>
                <select name="appointment_id" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    <option value="">{{ app()->getLocale() === 'ar' ? 'بدون ربط بموعد محدد' : 'No Specific Appointment' }}</option>
                    @foreach($appointments as $apt)
                        <option value="{{ $apt->id }}" {{ old('appointment_id') == $apt->id ? 'selected' : '' }}>
                            #{{ $apt->id }} - {{ $apt->patient->name }} ({{ \Carbon\Carbon::parse($apt->appointment_date)->format('Y-m-d') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'تاريخ العلاج' : 'Treatment Date' }} *</label>
                <input type="date" name="treatment_date" value="{{ old('treatment_date', date('Y-m-d')) }}" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                @error('treatment_date')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'التشخيص الطبي' : 'Clinical Diagnosis' }} *</label>
                <input type="text" name="diagnosis" value="{{ old('diagnosis') }}" placeholder="e.g. Deep dental caries on lower right molar #46" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                @error('diagnosis')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'الإجراء العلاجي المنفذ' : 'Treatment Provided' }} *</label>
                <textarea name="treatment" rows="3" placeholder="e.g. Root canal therapy, pulp extirpation, temporary filling placement." required class="w-full text-sm rounded-xl border border-slate-200 p-3.5 focus:outline-none focus:ring-2 focus:ring-medical-500">{{ old('treatment') }}</textarea>
                @error('treatment')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'ملاحظات وتوصيات إضافية' : 'Clinical Notes / Instructions' }}</label>
                <textarea name="notes" rows="2" placeholder="e.g. Prescribed Amoxicillin 500mg, review after 7 days." class="w-full text-sm rounded-xl border border-slate-200 p-3.5 focus:outline-none focus:ring-2 focus:ring-medical-500">{{ old('notes') }}</textarea>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.medical-records.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition">
                {{ app()->getLocale() === 'ar' ? 'إلغاء' : 'Cancel' }}
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-medical-600 hover:bg-medical-700 text-white font-bold text-sm shadow-md shadow-medical-600/20 transition">
                {{ app()->getLocale() === 'ar' ? 'حفظ السجل الطبي' : 'Save Medical Record' }}
            </button>
        </div>
    </form>
</div>
@endsection
