@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'إدارة المواعيد والحجوزات' : 'Appointments Management')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'المواعيد والحجوزات' : 'Appointments Management' }}</h1>
            <p class="text-xs text-slate-500 mt-1">{{ app()->getLocale() === 'ar' ? 'متابعة كافة حجوزات المرضى وتحديث الحالات والتواصل الطبي' : 'Review scheduled visits, update states, and view clinical history' }}</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs font-semibold px-3 py-1.5 rounded-xl bg-white border border-slate-100 text-slate-600 shadow-sm">
                {{ $appointments->total() }} {{ app()->getLocale() === 'ar' ? 'حجز مسجل' : 'Bookings Total' }}
            </span>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm">
        <form action="{{ route('admin.appointments.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1.5">{{ app()->getLocale() === 'ar' ? 'الحالة' : 'Status' }}</label>
                <select name="status" class="w-full text-xs rounded-xl border border-slate-200 px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    <option value="">{{ app()->getLocale() === 'ar' ? 'جميع الحالات' : 'All Statuses' }}</option>
                    @foreach(\App\Enums\AppointmentStatus::cases() as $st)
                        <option value="{{ $st->value }}" {{ request('status') === $st->value ? 'selected' : '' }}>
                            {{ $st->label() }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1.5">{{ app()->getLocale() === 'ar' ? 'الطبيب المعالج' : 'Doctor' }}</label>
                <select name="doctor_id" class="w-full text-xs rounded-xl border border-slate-200 px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    <option value="">{{ app()->getLocale() === 'ar' ? 'جميع الأطباء' : 'All Doctors' }}</option>
                    @foreach($doctors as $doc)
                        <option value="{{ $doc->id }}" {{ request('doctor_id') == $doc->id ? 'selected' : '' }}>
                            {{ $doc->user->name }} ({{ $doc->specialization }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1.5">{{ app()->getLocale() === 'ar' ? 'التاريخ' : 'Date' }}</label>
                <input type="date" name="date" value="{{ request('date') }}" class="w-full text-xs rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-medical-500">
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="w-full py-2.5 bg-medical-600 hover:bg-medical-700 text-white rounded-xl text-xs font-bold transition">
                    {{ app()->getLocale() === 'ar' ? 'تصفية النتائج' : 'Filter' }}
                </button>
                @if(request()->hasAny(['status', 'doctor_id', 'date']))
                    <a href="{{ route('admin.appointments.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition">
                        {{ app()->getLocale() === 'ar' ? 'إعادة ضبط' : 'Reset' }}
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Appointments Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-start text-sm">
                <thead>
                    <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider bg-slate-50/70 border-b border-slate-100">
                        <th class="py-3.5 px-6 text-start">ID</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'المريض' : 'Patient' }}</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'الطبيب' : 'Doctor' }}</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'الخدمة' : 'Service' }}</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'الموعد' : 'Schedule' }}</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'الحالة' : 'Status' }}</th>
                        <th class="py-3.5 px-6 text-end">{{ app()->getLocale() === 'ar' ? 'الإجراءات' : 'Actions' }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($appointments as $apt)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 font-mono text-xs text-slate-400 font-bold">#{{ $apt->id }}</td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-navy-900">{{ $apt->patient->name }}</div>
                                <div class="text-[11px] text-slate-400">{{ $apt->patient->phone }}</div>
                            </td>
                            <td class="py-4 px-6 text-xs text-slate-700 font-medium">
                                {{ $apt->doctor->user->name }}
                            </td>
                            <td class="py-4 px-6 text-xs text-slate-600">
                                {{ app()->getLocale() === 'ar' ? $apt->service->name_ar : $apt->service->name_en }}
                            </td>
                            <td class="py-4 px-6 text-xs">
                                <div class="font-bold text-navy-900">{{ \Carbon\Carbon::parse($apt->appointment_date)->format('Y-m-d') }}</div>
                                <div class="text-slate-400 text-[11px]">{{ \Carbon\Carbon::parse($apt->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($apt->end_time)->format('h:i A') }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 text-[11px] font-bold rounded-full {{ $apt->status->badgeClass() }}">
                                    {{ $apt->status->label() }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-end">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.appointments.show', $apt->id) }}" class="px-3 py-1.5 bg-medical-50 text-medical-700 hover:bg-medical-100 rounded-xl text-xs font-bold transition">
                                        {{ app()->getLocale() === 'ar' ? 'تفاصيل' : 'Details' }}
                                    </a>
                                    <form action="{{ route('admin.appointments.destroy', $apt->id) }}" method="POST" onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'هل أنت متأكد من حذف هذا الموعد؟' : 'Are you sure you want to delete this appointment?' }}')">
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
                            <td colspan="7" class="py-12 text-center text-slate-400 text-sm">
                                {{ app()->getLocale() === 'ar' ? 'لم يتم العثور على حجوزات مطابقة.' : 'No matching appointments found.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($appointments->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $appointments->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
