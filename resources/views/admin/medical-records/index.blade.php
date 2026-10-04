@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'السجلات الطبية' : 'Medical Records')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'السجلات الطبية والتشخيصات' : 'Medical Records' }}</h1>
            <p class="text-xs text-slate-500 mt-1">{{ app()->getLocale() === 'ar' ? 'أرشيف التشخيصات الطبية، الخطط العلاجية، وتاريخ زيارات المرضى' : 'Central archive of patient diagnoses, clinical treatments, and charts' }}</p>
        </div>
        <a href="{{ route('admin.medical-records.create') }}" class="px-5 py-2.5 rounded-xl bg-medical-600 hover:bg-medical-700 text-white font-bold text-sm shadow-md shadow-medical-600/20 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>{{ app()->getLocale() === 'ar' ? 'إضافة سجل طبي جديد' : 'New Medical Record' }}</span>
        </a>
    </div>

    <!-- Search Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-3">
        <form action="{{ route('admin.medical-records.index') }}" method="GET" class="w-full sm:w-80 flex items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ app()->getLocale() === 'ar' ? 'ابحث بالتشخيص أو العلاج...' : 'Search diagnosis or treatment...' }}" class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
            <button type="submit" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition">
                {{ app()->getLocale() === 'ar' ? 'بحث' : 'Search' }}
            </button>
            @if(request('search'))
                <a href="{{ route('admin.medical-records.index') }}" class="text-xs text-rose-500 hover:underline shrink-0">{{ app()->getLocale() === 'ar' ? 'إلغاء' : 'Reset' }}</a>
            @endif
        </form>
        <span class="text-xs text-slate-400">{{ $records->total() }} {{ app()->getLocale() === 'ar' ? 'سجلات مسجلة' : 'records logged' }}</span>
    </div>

    <!-- Records Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-start text-sm">
                <thead>
                    <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider bg-slate-50/70 border-b border-slate-100">
                        <th class="py-3.5 px-6 text-start">ID</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'المريض' : 'Patient' }}</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'الطبيب المعالج' : 'Doctor' }}</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'التشخيص' : 'Diagnosis' }}</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'تاريخ العلاج' : 'Treatment Date' }}</th>
                        <th class="py-3.5 px-6 text-end">{{ app()->getLocale() === 'ar' ? 'الإجراءات' : 'Actions' }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($records as $rec)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 font-mono text-xs text-slate-400 font-bold">#{{ $rec->id }}</td>
                            <td class="py-4 px-6">
                                <a href="{{ route('admin.patients.show', $rec->patient_id) }}" class="font-bold text-navy-900 hover:text-medical-600 transition">
                                    {{ $rec->patient->name }}
                                </a>
                            </td>
                            <td class="py-4 px-6 text-xs text-slate-600 font-medium">
                                {{ $rec->doctor->user->name }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-navy-900 text-xs line-clamp-1">{{ $rec->diagnosis }}</div>
                                <div class="text-[11px] text-slate-400 line-clamp-1">{{ $rec->treatment }}</div>
                            </td>
                            <td class="py-4 px-6 text-xs text-slate-500">
                                {{ \Carbon\Carbon::parse($rec->treatment_date)->format('Y-m-d') }}
                            </td>
                            <td class="py-4 px-6 text-end">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.medical-records.show', $rec->id) }}" class="px-3 py-1.5 bg-medical-50 text-medical-700 hover:bg-medical-100 rounded-xl text-xs font-bold transition">
                                        {{ app()->getLocale() === 'ar' ? 'عرض السجل' : 'View' }}
                                    </a>
                                    <form action="{{ route('admin.medical-records.destroy', $rec->id) }}" method="POST" onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'هل تريد حذف هذا السجل الطبي؟' : 'Delete this medical record?' }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" title="{{ app()->getLocale() === 'ar' ? 'حذف' : 'Delete' }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400 text-sm">
                                {{ app()->getLocale() === 'ar' ? 'لم يتم العثور على سجلات طبية.' : 'No medical records found.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($records->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $records->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
