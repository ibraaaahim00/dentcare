@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'إدارة الأطباء' : 'Doctors Management')

@section('content')
<div class="space-y-6">
    <!-- Header with Add Doctor action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'إدارة الأطباء والاستشاريين' : 'Doctors & Specialists' }}</h1>
            <p class="text-xs text-slate-500 mt-1">{{ app()->getLocale() === 'ar' ? 'إدارة الطاقم الطبي، التخصصات، رسوم الكشف، والصلاحيات' : 'Manage medical staff, credentials, consultation fees, and profile details' }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.doctors.create') }}" class="px-5 py-2.5 rounded-xl bg-medical-600 hover:bg-medical-700 text-white font-bold text-sm shadow-md shadow-medical-600/20 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'إضافة طبيب جديد' : 'Add New Doctor' }}</span>
            </a>
        </div>
    </div>

    <!-- Search & Filters Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <form action="{{ route('admin.doctors.index') }}" method="GET" class="w-full md:w-80 flex items-center gap-2">
            <div class="relative w-full">
                <span class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'right-3' : 'left-3' }} flex items-center text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ app()->getLocale() === 'ar' ? 'ابحث بالاسم أو التخصص...' : 'Search by name or specialty...' }}" class="w-full text-xs rounded-xl border border-slate-200 py-2.5 {{ app()->getLocale() === 'ar' ? 'pr-9 pl-4' : 'pl-9 pr-4' }} focus:outline-none focus:ring-2 focus:ring-medical-500">
            </div>
            <button type="submit" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition">
                {{ app()->getLocale() === 'ar' ? 'بحث' : 'Search' }}
            </button>
            @if(request('search'))
                <a href="{{ route('admin.doctors.index') }}" class="text-xs text-rose-500 hover:underline shrink-0">{{ app()->getLocale() === 'ar' ? 'إلغاء' : 'Reset' }}</a>
            @endif
        </form>
        <span class="text-xs text-slate-400">{{ $doctors->total() }} {{ app()->getLocale() === 'ar' ? 'أطباء مسجلين' : 'total doctors registered' }}</span>
    </div>

    <!-- Doctors Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-start text-sm">
                <thead>
                    <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider bg-slate-50/70 border-b border-slate-100">
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'الطبيب' : 'Doctor' }}</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'التخصص' : 'Specialization' }}</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'الخبرة' : 'Experience' }}</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'سعر الكشف' : 'Consultation Fee' }}</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'الحالة' : 'Status' }}</th>
                        <th class="py-3.5 px-6 text-end">{{ app()->getLocale() === 'ar' ? 'الإجراءات' : 'Actions' }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($doctors as $doc)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $doc->image_url }}" alt="{{ $doc->user->name }}" class="w-10 h-10 rounded-full object-cover border border-slate-100 shadow-sm">
                                    <div>
                                        <div class="font-bold text-navy-900">{{ $doc->user->name }}</div>
                                        <div class="text-xs text-slate-400">{{ $doc->user->email }} &bull; {{ $doc->user->phone }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-slate-700 font-medium text-xs">{{ $doc->specialization }}</td>
                            <td class="py-4 px-6 text-slate-600 text-xs">{{ $doc->experience_years }} {{ app()->getLocale() === 'ar' ? 'سنوات' : 'years' }}</td>
                            <td class="py-4 px-6 font-bold text-navy-900 text-xs">${{ number_format($doc->consultation_fee, 2) }}</td>
                            <td class="py-4 px-6">
                                @if($doc->is_active)
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        {{ app()->getLocale() === 'ar' ? 'متاح للعمل' : 'Active' }}
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-slate-100 text-slate-600">
                                        {{ app()->getLocale() === 'ar' ? 'غير نشط' : 'Inactive' }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-end">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.doctors.schedule.edit', $doc->id) }}" class="p-2 rounded-xl text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition" title="{{ app()->getLocale() === 'ar' ? 'مواعيد وساعات العمل' : 'Doctor Working Schedule' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </a>
                                    <a href="{{ route('admin.doctors.edit', $doc->id) }}" class="p-2 rounded-xl text-slate-400 hover:text-medical-600 hover:bg-slate-100 transition" title="{{ app()->getLocale() === 'ar' ? 'تعديل' : 'Edit' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.doctors.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'هل أنت متأكد من حذف هذا الطبيب؟' : 'Are you sure you want to delete this doctor?' }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" title="{{ app()->getLocale() === 'ar' ? 'حذف' : 'Delete' }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400 text-sm">
                                {{ app()->getLocale() === 'ar' ? 'لم يتم العثور على أطباء.' : 'No doctors found.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($doctors->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $doctors->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
