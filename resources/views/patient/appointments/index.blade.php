@extends('layouts.patient')

@section('title', app()->getLocale() === 'ar' ? 'مواعيدي' : 'My Appointments')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-navy-900">{{ app()->getLocale() === 'ar' ? 'سجل مواعيدي الطبية' : 'My Appointments' }}</h1>
            <p class="text-xs text-slate-500 mt-1">{{ app()->getLocale() === 'ar' ? 'استعراض جميع المواعيد السابقة والحالية ومتابعة حالتها' : 'Track current and historical visits' }}</p>
        </div>
        <a href="{{ route('appointments.create') }}" class="px-5 py-2.5 bg-medical-600 hover:bg-medical-700 text-white font-bold text-xs rounded-xl shadow-md transition">
            {{ app()->getLocale() === 'ar' ? 'حجز موعد جديد' : 'Book New' }}
        </a>
    </div>

    <!-- Status Filters -->
    <div class="flex flex-wrap gap-2 text-xs font-semibold">
        <a href="{{ route('patient.appointments.index') }}" class="px-3.5 py-1.5 rounded-lg {{ !request('status') ? 'bg-navy-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            {{ app()->getLocale() === 'ar' ? 'الكل' : 'All' }}
        </a>
        <a href="{{ route('patient.appointments.index', ['status' => 'pending']) }}" class="px-3.5 py-1.5 rounded-lg {{ request('status') === 'pending' ? 'bg-navy-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            {{ app()->getLocale() === 'ar' ? 'قيد الانتظار' : 'Pending' }}
        </a>
        <a href="{{ route('patient.appointments.index', ['status' => 'confirmed']) }}" class="px-3.5 py-1.5 rounded-lg {{ request('status') === 'confirmed' ? 'bg-navy-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            {{ app()->getLocale() === 'ar' ? 'مؤكدة' : 'Confirmed' }}
        </a>
        <a href="{{ route('patient.appointments.index', ['status' => 'completed']) }}" class="px-3.5 py-1.5 rounded-lg {{ request('status') === 'completed' ? 'bg-navy-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            {{ app()->getLocale() === 'ar' ? 'مكتملة' : 'Completed' }}
        </a>
        <a href="{{ route('patient.appointments.index', ['status' => 'cancelled']) }}" class="px-3.5 py-1.5 rounded-lg {{ request('status') === 'cancelled' ? 'bg-navy-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            {{ app()->getLocale() === 'ar' ? 'ملغاة' : 'Cancelled' }}
        </a>
    </div>

    <!-- Appointments Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        @if($appointments->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
                    <thead class="text-xs text-slate-400 uppercase bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4">{{ __('app.date') }}</th>
                            <th class="px-6 py-4">{{ __('app.time') }}</th>
                            <th class="px-6 py-4">{{ __('app.doctors') }}</th>
                            <th class="px-6 py-4">{{ __('app.services') }}</th>
                            <th class="px-6 py-4">{{ __('app.status') }}</th>
                            <th class="px-6 py-4 text-center">{{ __('app.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($appointments as $appointment)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-6 py-4 font-bold text-navy-900">{{ $appointment->appointment_date->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 text-slate-600" dir="ltr">{{ substr($appointment->start_time, 0, 5) }} - {{ substr($appointment->end_time, 0, 5) }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2.5">
                                        <img src="{{ $appointment->doctor->image_url }}" alt="" class="w-8 h-8 rounded-full object-cover">
                                        <div>
                                            <span class="block font-bold text-navy-900 text-xs">{{ $appointment->doctor->name }}</span>
                                            <span class="block text-[11px] text-slate-400">{{ $appointment->doctor->specialization }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-700 font-medium">{{ $appointment->service->name }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $appointment->status->badgeClass() }}">
                                        {{ $appointment->status->label() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('patient.appointments.show', $appointment->id) }}" class="px-3.5 py-1.5 bg-slate-100 hover:bg-medical-50 text-slate-700 hover:text-medical-600 rounded-xl text-xs font-bold transition">
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
            <div class="p-12 text-center">
                <p class="text-slate-400 text-sm">{{ app()->getLocale() === 'ar' ? 'لا توجد مواعيد مطابقة لخيارات البحث.' : 'No appointments found.' }}</p>
            </div>
        @endif
    </div>
</div>
@endsection
