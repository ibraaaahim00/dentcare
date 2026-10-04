@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'إدارة المرضى' : 'Patients Directory')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'سجل المرضى' : 'Patients Directory' }}</h1>
            <p class="text-xs text-slate-500 mt-1">{{ app()->getLocale() === 'ar' ? 'استعراض ملفات المرضى المسجلين، سجلات العلاج وتاريخ المواعيد' : 'Manage registered patients, treatment history, and medical visits' }}</p>
        </div>
        <div class="text-xs text-slate-500 font-semibold bg-white px-4 py-2 rounded-xl border border-slate-100 shadow-sm">
            {{ $patients->total() }} {{ app()->getLocale() === 'ar' ? 'مريض مسجل' : 'Registered Patients' }}
        </div>
    </div>

    <!-- Search Form -->
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
        <form action="{{ route('admin.patients.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="relative w-full sm:w-80">
                <span class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'right-3' : 'left-3' }} flex items-center text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ app()->getLocale() === 'ar' ? 'ابحث بالاسم أو البريد أو الهاتف...' : 'Search by name, email, or phone...' }}" class="w-full text-xs rounded-xl border border-slate-200 py-2.5 {{ app()->getLocale() === 'ar' ? 'pr-9 pl-4' : 'pl-9 pr-4' }} focus:outline-none focus:ring-2 focus:ring-medical-500">
            </div>
            <button type="submit" class="px-5 py-2.5 bg-medical-600 hover:bg-medical-700 text-white rounded-xl text-xs font-bold transition">
                {{ app()->getLocale() === 'ar' ? 'بحث' : 'Search' }}
            </button>
            @if(request('search'))
                <a href="{{ route('admin.patients.index') }}" class="text-xs text-rose-500 hover:underline">{{ app()->getLocale() === 'ar' ? 'إعادة ضبط' : 'Reset' }}</a>
            @endif
        </form>
    </div>

    <!-- Patients List Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-start text-sm">
                <thead>
                    <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider bg-slate-50/70 border-b border-slate-100">
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'المريض' : 'Patient' }}</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'الاتصال' : 'Contact' }}</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'الجنس / الميلاد' : 'Gender / DOB' }}</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'تاريخ التسجيل' : 'Registered Since' }}</th>
                        <th class="py-3.5 px-6 text-end">{{ app()->getLocale() === 'ar' ? 'الإجراءات' : 'Actions' }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($patients as $patient)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $patient->avatar_url }}" alt="{{ $patient->name }}" class="w-10 h-10 rounded-full object-cover border border-slate-100 shadow-sm">
                                    <div>
                                        <a href="{{ route('admin.patients.show', $patient->id) }}" class="font-bold text-navy-900 hover:text-medical-600 transition">
                                            {{ $patient->name }}
                                        </a>
                                        <div class="text-[11px] text-slate-400">ID: #{{ $patient->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-xs text-slate-600">
                                <div>{{ $patient->email }}</div>
                                <div class="text-slate-400 mt-0.5">{{ $patient->phone }}</div>
                            </td>
                            <td class="py-4 px-6 text-xs text-slate-600">
                                <span class="capitalize">{{ $patient->gender?->value ?? '—' }}</span>
                                @if($patient->date_of_birth)
                                    <span class="text-slate-400 block text-[11px]">{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('Y-m-d') }}</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-xs text-slate-500">
                                {{ $patient->created_at->format('Y-m-d') }}
                            </td>
                            <td class="py-4 px-6 text-end">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.patients.show', $patient->id) }}" class="px-3 py-1.5 rounded-xl bg-medical-50 text-medical-700 hover:bg-medical-100 text-xs font-bold transition">
                                        {{ app()->getLocale() === 'ar' ? 'الملف الطبي' : 'Profile' }}
                                    </a>
                                    <a href="{{ route('admin.patients.edit', $patient->id) }}" class="p-2 rounded-xl text-slate-400 hover:text-navy-900 hover:bg-slate-100 transition" title="{{ app()->getLocale() === 'ar' ? 'تعديل' : 'Edit' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400 text-sm">
                                {{ app()->getLocale() === 'ar' ? 'لم يتم العثور على مرضى مسجلين.' : 'No patients found.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($patients->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $patients->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
