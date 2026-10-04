@extends('layouts.admin')

@section('title', (app()->getLocale() === 'ar' ? 'جدول مواعيد الطبيب: ' : 'Doctor Schedule: ') . $doctor->name)

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">
                {{ app()->getLocale() === 'ar' ? 'جدول وساعات عمل الطبيب' : 'Doctor Working Schedule' }}
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                {{ $doctor->name }} — {{ $doctor->specialization }}
            </p>
        </div>
        <a href="{{ route('admin.doctors.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition">
            {{ app()->getLocale() === 'ar' ? 'العودة لقائمة الأطباء' : 'Back to Doctors' }}
        </a>
    </div>

    <!-- Alert / Info -->
    <div class="p-4 rounded-2xl bg-medical-50 border border-medical-200 text-medical-800 text-xs flex items-center gap-3">
        <svg class="w-5 h-5 shrink-0 text-medical-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span>{{ app()->getLocale() === 'ar' ? 'حدد أيام وساعات عمل الطبيب وفترات الاستراحة. اليوم المحدد كيوم عطلة لن يظهر في حجوزات المرضى.' : 'Configure weekly working hours, break periods, and off days for this doctor. Off days will be unavailable during booking.' }}</span>
    </div>

    <form action="{{ route('admin.doctors.schedule.update', $doctor->id) }}" method="POST">
        @csrf
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden p-6 space-y-4">
            @php
                $dayNames = [
                    0 => ['ar' => 'الأحد', 'en' => 'Sunday'],
                    1 => ['ar' => 'الاثنين', 'en' => 'Monday'],
                    2 => ['ar' => 'الثلاثاء', 'en' => 'Tuesday'],
                    3 => ['ar' => 'الأربعاء', 'en' => 'Wednesday'],
                    4 => ['ar' => 'الخميس', 'en' => 'Thursday'],
                    5 => ['ar' => 'الجمعة', 'en' => 'Friday'],
                    6 => ['ar' => 'السبت', 'en' => 'Saturday'],
                ];
            @endphp

            <div class="divide-y divide-slate-100">
                @foreach($dayNames as $dayIndex => $dayLabel)
                    @php
                        $sched = $schedules->get($dayIndex);
                        $isOff = $sched ? $sched->is_day_off : ($dayIndex === 5); // Friday default off
                        $start = $sched && $sched->start_time ? substr($sched->start_time, 0, 5) : '09:00';
                        $end = $sched && $sched->end_time ? substr($sched->end_time, 0, 5) : '17:00';
                        $bStart = $sched && $sched->break_start ? substr($sched->break_start, 0, 5) : '';
                        $bEnd = $sched && $sched->break_end ? substr($sched->break_end, 0, 5) : '';
                    @endphp
                    <div class="py-4 flex flex-col md:flex-row md:items-center justify-between gap-4" x-data="{ isOff: {{ $isOff ? 'true' : 'false' }} }">
                        <div class="w-36 font-bold text-slate-800 text-sm">
                            {{ $dayLabel[app()->getLocale()] ?? $dayLabel['en'] }}
                        </div>

                        <div class="flex items-center gap-3">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="days[{{ $dayIndex }}][is_day_off]" value="1" x-model="isOff" class="sr-only peer">
                                <div class="w-10 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-rose-500"></div>
                                <span class="ms-2 text-xs font-semibold text-slate-600" x-text="isOff ? '{{ app()->getLocale() === 'ar' ? 'يوم عطلة' : 'Day Off' }}' : '{{ app()->getLocale() === 'ar' ? 'يوم عمل' : 'Work Day' }}'"></span>
                            </label>
                        </div>

                        <div class="flex flex-wrap items-center gap-3" x-show="!isOff" x-cloak>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-slate-400">{{ app()->getLocale() === 'ar' ? 'من' : 'From' }}</span>
                                <input type="time" name="days[{{ $dayIndex }}][start_time]" value="{{ $start }}" class="text-xs rounded-xl border border-slate-200 px-3 py-2 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-slate-400">{{ app()->getLocale() === 'ar' ? 'إلى' : 'To' }}</span>
                                <input type="time" name="days[{{ $dayIndex }}][end_time]" value="{{ $end }}" class="text-xs rounded-xl border border-slate-200 px-3 py-2 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                            </div>
                            <div class="flex items-center gap-2 border-s border-slate-200 ps-3">
                                <span class="text-xs text-amber-600 font-medium">{{ app()->getLocale() === 'ar' ? 'استراحة:' : 'Break:' }}</span>
                                <input type="time" name="days[{{ $dayIndex }}][break_start]" value="{{ $bStart }}" placeholder="Start" class="text-xs rounded-xl border border-slate-200 px-2 py-2 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                                <span class="text-xs text-slate-400">-</span>
                                <input type="time" name="days[{{ $dayIndex }}][break_end]" value="{{ $bEnd }}" placeholder="End" class="text-xs rounded-xl border border-slate-200 px-2 py-2 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                            </div>
                        </div>

                        <div x-show="isOff" class="text-xs text-rose-500 font-semibold" x-cloak>
                            {{ app()->getLocale() === 'ar' ? 'هذا اليوم عطلة رسمية للطبيب' : 'Marked as regular off day' }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-medical-600 hover:bg-medical-700 text-white font-bold text-sm shadow-md shadow-medical-600/20 transition">
                    {{ app()->getLocale() === 'ar' ? 'حفظ جدول المواعيد' : 'Save Doctor Schedule' }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
