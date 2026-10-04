@extends('layouts.patient')

@section('title', app()->getLocale() === 'ar' ? 'الإشعارات' : 'Notifications')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-extrabold text-navy-900">{{ app()->getLocale() === 'ar' ? 'التنبيهات والإشعارات' : 'Notifications' }}</h1>
            <p class="text-xs text-slate-500 mt-1">{{ app()->getLocale() === 'ar' ? 'سجل تحديثات المواعيد وتنبيهات الحجز' : 'Appointment alerts and system updates' }}</p>
        </div>
        <form method="POST" action="{{ route('patient.notifications.mark-read') }}">
            @csrf
            <button type="submit" class="text-xs font-bold text-medical-600 hover:underline">
                {{ app()->getLocale() === 'ar' ? 'تحديد الكل كمقروء' : 'Mark all as read' }}
            </button>
        </form>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden divide-y divide-slate-100">
        @forelse($notifications as $notif)
            <div class="p-5 flex items-start gap-4 hover:bg-slate-50/50 transition">
                <div class="w-10 h-10 rounded-xl bg-medical-50 text-medical-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <div class="flex-1 space-y-1">
                    <h4 class="font-bold text-sm text-navy-900">{{ $notif->data['title'] ?? 'Notification' }}</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">{{ $notif->data['message'] ?? '' }}</p>
                    <span class="text-[11px] text-slate-400 block">{{ $notif->created_at->diffForHumans() }}</span>
                </div>
            </div>
        @empty
            <div class="p-12 text-center text-slate-400 text-sm">
                {{ app()->getLocale() === 'ar' ? 'لا توجد إشعارات جديدة.' : 'No notifications found.' }}
            </div>
        @endforelse
    </div>

    <div>
        {{ $notifications->links() }}
    </div>
</div>
@endsection
