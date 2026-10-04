@extends('layouts.doctor')

@section('title', app()->getLocale() === 'ar' ? 'إضافة تقرير طبي' : 'Add Medical Record')
@section('page_title', app()->getLocale() === 'ar' ? 'تحرير تقرير طبي وتشخيص جديد' : 'New Medical Record')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm">
        @if($appointment)
            <div class="p-4 bg-medical-50 rounded-2xl border border-medical-100 mb-6 flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-medical-800 block">{{ app()->getLocale() === 'ar' ? 'المريض:' : 'Patient:' }} {{ $appointment->patient->name }}</span>
                    <span class="text-xs text-slate-500">{{ $appointment->service->name }} ({{ $appointment->appointment_date->format('Y-m-d') }})</span>
                </div>
                <span class="text-xs font-bold text-navy-900">#{{ $appointment->id }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('doctor.medical-records.store') }}" class="space-y-5">
            @csrf

            @if($appointment)
                <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                <input type="hidden" name="patient_id" value="{{ $appointment->patient_id }}">
            @else
                <div>
                    <label for="patient_id" class="block text-xs font-bold text-slate-700 uppercase mb-2">{{ app()->getLocale() === 'ar' ? 'اختر المريض' : 'Select Patient' }}</label>
                    <select id="patient_id" name="patient_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white" required>
                        @foreach(\App\Models\User::where('role', 'patient')->get() as $p)
                            <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->phone }})</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div>
                <label for="treatment_date" class="block text-xs font-bold text-slate-700 uppercase mb-2">{{ app()->getLocale() === 'ar' ? 'تاريخ الإجراء / الجلسة' : 'Treatment Date' }}</label>
                <input type="date" id="treatment_date" name="treatment_date" value="{{ old('treatment_date', date('Y-m-d')) }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white">
            </div>

            <div>
                <label for="diagnosis" class="block text-xs font-bold text-slate-700 uppercase mb-2">{{ app()->getLocale() === 'ar' ? 'التشخيص الطبي السريري' : 'Clinical Diagnosis' }}</label>
                <textarea id="diagnosis" name="diagnosis" rows="3" required
                          class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500"
                          placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: تسوس عميق في الضرس السفلي الأيمن مع التهاب العصب...' : 'e.g. Deep dental caries in lower right molar with acute pulpitis...' }}">{{ old('diagnosis') }}</textarea>
            </div>

            <div>
                <label for="treatment" class="block text-xs font-bold text-slate-700 uppercase mb-2">{{ app()->getLocale() === 'ar' ? 'الإجراء العلاجي المنفذ' : 'Treatment Performed' }}</label>
                <textarea id="treatment" name="treatment" rows="3" required
                          class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500"
                          placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: تنظيف القنوات الجذرية ووضع حشوة عصب تجميلية...' : 'e.g. Root canal therapy completed and composite restoration placed...' }}">{{ old('treatment') }}</textarea>
            </div>

            <div>
                <label for="notes" class="block text-xs font-bold text-slate-700 uppercase mb-2">{{ app()->getLocale() === 'ar' ? 'توصيات وتعليمات للمريض' : 'Post-Treatment Recommendations' }}</label>
                <textarea id="notes" name="notes" rows="2"
                          class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500"
                          placeholder="{{ app()->getLocale() === 'ar' ? 'تعليمات العناية، الأدوية الموصوفة، أو موعد المتابعة...' : 'Medication instructions or follow-up notice...' }}">{{ old('notes') }}</textarea>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full py-3.5 px-4 rounded-xl bg-medical-600 hover:bg-medical-700 text-white font-bold text-xs shadow-md transition">
                    {{ app()->getLocale() === 'ar' ? 'حفظ السجل الطبي في ملف المريض' : 'Save Medical Record' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
