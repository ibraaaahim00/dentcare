@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'إدارة الخدمات العلاجية' : 'Dental Services Management')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'الخدمات العلاجية والتجميلية' : 'Dental Services' }}</h1>
            <p class="text-xs text-slate-500 mt-1">{{ app()->getLocale() === 'ar' ? 'إدارة باقات وخدمات العيادة، الأسعار، مدد الجلسات، وتفاصيل الحجز' : 'Manage clinic clinical offerings, durations, pricing, and availability' }}</p>
        </div>
        <a href="{{ route('admin.services.create') }}" class="px-5 py-2.5 rounded-xl bg-medical-600 hover:bg-medical-700 text-white font-bold text-sm shadow-md shadow-medical-600/20 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>{{ app()->getLocale() === 'ar' ? 'إضافة خدمة جديدة' : 'Add New Service' }}</span>
        </a>
    </div>

    <!-- Search Form -->
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-3">
        <form action="{{ route('admin.services.index') }}" method="GET" class="w-full sm:w-80 flex items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ app()->getLocale() === 'ar' ? 'ابحث عن خدمة...' : 'Search services...' }}" class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
            <button type="submit" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition">
                {{ app()->getLocale() === 'ar' ? 'بحث' : 'Search' }}
            </button>
            @if(request('search'))
                <a href="{{ route('admin.services.index') }}" class="text-xs text-rose-500 hover:underline shrink-0">{{ app()->getLocale() === 'ar' ? 'إلغاء' : 'Reset' }}</a>
            @endif
        </form>
        <span class="text-xs text-slate-400">{{ $services->total() }} {{ app()->getLocale() === 'ar' ? 'خدمات مسجلة' : 'services registered' }}</span>
    </div>

    <!-- Services Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-start text-sm">
                <thead>
                    <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider bg-slate-50/70 border-b border-slate-100">
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'الخدمة' : 'Service' }}</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'المدة (دقيقة)' : 'Duration' }}</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'السعر' : 'Price' }}</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'الحالة' : 'Status' }}</th>
                        <th class="py-3.5 px-6 text-end">{{ app()->getLocale() === 'ar' ? 'الإجراءات' : 'Actions' }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($services as $srv)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $srv->image_url }}" alt="{{ $srv->name_en }}" class="w-12 h-12 rounded-2xl object-cover border border-slate-100 shadow-sm">
                                    <div>
                                        <div class="font-bold text-navy-900">{{ app()->getLocale() === 'ar' ? $srv->name_ar : $srv->name_en }}</div>
                                        <div class="text-[11px] text-slate-400">{{ app()->getLocale() === 'ar' ? $srv->name_en : $srv->name_ar }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-xs text-slate-600 font-semibold">{{ $srv->duration }} {{ app()->getLocale() === 'ar' ? 'دقيقة' : 'min' }}</td>
                            <td class="py-4 px-6 font-bold text-navy-900 text-xs">${{ number_format($srv->price, 2) }}</td>
                            <td class="py-4 px-6">
                                @if($srv->is_active)
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        {{ app()->getLocale() === 'ar' ? 'نشطة ومتاحة' : 'Active' }}
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-slate-100 text-slate-600">
                                        {{ app()->getLocale() === 'ar' ? 'معطلة' : 'Disabled' }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-end">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.services.edit', $srv->id) }}" class="p-2 rounded-xl text-slate-400 hover:text-medical-600 hover:bg-slate-100 transition" title="{{ app()->getLocale() === 'ar' ? 'تعديل' : 'Edit' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.services.destroy', $srv->id) }}" method="POST" onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'هل أنت متأكد من حذف هذه الخدمة؟' : 'Are you sure you want to delete this service?' }}')">
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
                            <td colspan="5" class="py-12 text-center text-slate-400 text-sm">
                                {{ app()->getLocale() === 'ar' ? 'لم يتم العثور على خدمات مسجلة.' : 'No services found.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($services->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $services->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
