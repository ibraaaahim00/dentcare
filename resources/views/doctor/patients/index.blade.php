@extends('layouts.doctor')

@section('title', app()->getLocale() === 'ar' ? 'سجل مرضاي' : 'My Patients')
@section('page_title', app()->getLocale() === 'ar' ? 'قائمة المرضى والمراجعين' : 'My Assigned Patients')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        @if($patients->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
                    <thead class="text-xs text-slate-400 uppercase bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4">{{ app()->getLocale() === 'ar' ? 'المريض' : 'Patient' }}</th>
                            <th class="px-6 py-4">{{ __('app.email') }}</th>
                            <th class="px-6 py-4">{{ __('app.phone') }}</th>
                            <th class="px-6 py-4">{{ app()->getLocale() === 'ar' ? 'الزيارات' : 'Visits' }}</th>
                            <th class="px-6 py-4 text-center">{{ __('app.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($patients as $patient)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-6 py-4 font-bold text-navy-900">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $patient->avatar_url }}" alt="" class="w-8 h-8 rounded-full object-cover">
                                        <span>{{ $patient->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-500">{{ $patient->email }}</td>
                                <td class="px-6 py-4 text-slate-700" dir="ltr">{{ $patient->phone }}</td>
                                <td class="px-6 py-4 font-bold text-medical-600">{{ $patient->appointments_count }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('doctor.patients.show', $patient->id) }}" class="px-3.5 py-1.5 bg-slate-100 hover:bg-medical-50 text-slate-700 hover:text-medical-600 rounded-xl text-xs font-bold transition">
                                        {{ app()->getLocale() === 'ar' ? 'السجل الطبي' : 'Medical File' }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-6 border-t border-slate-100">
                {{ $patients->links() }}
            </div>
        @else
            <div class="p-12 text-center text-slate-400 text-sm">
                {{ app()->getLocale() === 'ar' ? 'لا يوجد مرضى مسجلين معك حتى الآن.' : 'No patients registered yet.' }}
            </div>
        @endif
    </div>
</div>
@endsection
