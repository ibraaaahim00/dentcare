@extends('layouts.doctor')

@section('title', app()->getLocale() === 'ar' ? 'مواعيد الطبيب' : 'Doctor Appointments')
@section('page_title', app()->getLocale() === 'ar' ? 'إدارة المواعيد السريرية' : 'Doctor Appointments Management')

@section('content')
<div class="space-y-6">
    <!-- Filters -->
    <div class="flex flex-wrap gap-2 text-xs font-semibold">
        <a href="{{ route('doctor.appointments.index') }}" class="px-3.5 py-1.5 rounded-lg {{ !request('status') ? 'bg-navy-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            {{ app()->getLocale() === 'ar' ? 'الكل' : 'All' }}
        </a>
        <a href="{{ route('doctor.appointments.index', ['status' => 'pending']) }}" class="px-3.5 py-1.5 rounded-lg {{ request('status') === 'pending' ? 'bg-navy-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            {{ app()->getLocale() === 'ar' ? 'قيد الانتظار' : 'Pending' }}
        </a>
        <a href="{{ route('doctor.appointments.index', ['status' => 'confirmed']) }}" class="px-3.5 py-1.5 rounded-lg {{ request('status') === 'confirmed' ? 'bg-navy-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            {{ app()->getLocale() === 'ar' ? 'مؤكدة' : 'Confirmed' }}
        </a>
        <a href="{{ route('doctor.appointments.index', ['status' => 'completed']) }}" class="px-3.5 py-1.5 rounded-lg {{ request('status') === 'completed' ? 'bg-navy-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            {{ app()->getLocale() === 'ar' ? 'مكتملة' : 'Completed' }}
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        @if($appointments->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
                    <thead class="text-xs text-slate-400 uppercase bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4">{{ __('app.date') }}</th>
                            <th class="px-6 py-4">{{ __('app.time') }}</th>
                            <th class="px-6 py-4">{{ app()->getLocale() === 'ar' ? 'المريض' : 'Patient' }}</th>
                            <th class="px-6 py-4">{{ __('app.services') }}</th>
                            <th class="px-6 py-4">{{ __('app.status') }}</th>
                            <th class="px-6 py-4 text-center">{{ __('app.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($appointments as $apt)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-6 py-4 font-bold text-navy-900">{{ $apt->appointment_date->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 text-slate-600" dir="ltr">{{ substr($apt->start_time, 0, 5) }} - {{ substr($apt->end_time, 0, 5) }}</td>
                                <td class="px-6 py-4 font-semibold text-navy-900">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ $apt->patient->avatar_url }}" alt="" class="w-7 h-7 rounded-full object-cover">
                                        <span>{{ $apt->patient->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-500">{{ $apt->service->name }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $apt->status->badgeClass() }}">
                                        {{ $apt->status->label() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('doctor.appointments.show', $apt->id) }}" class="px-3.5 py-1.5 bg-slate-100 hover:bg-medical-50 text-slate-700 hover:text-medical-600 rounded-xl text-xs font-bold transition">
                                        {{ __('app.view') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-6 border-t border-slate-100">
                {{ $appointments->links() }}
            </div>
        @else
            <div class="p-12 text-center text-slate-400 text-sm">
                {{ app()->getLocale() === 'ar' ? 'لا توجد مواعيد مطابقة.' : 'No appointments found.' }}
            </div>
        @endif
    </div>
</div>
@endsection
