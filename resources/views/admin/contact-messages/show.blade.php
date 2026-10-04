@extends('layouts.admin')

@section('title', (app()->getLocale() === 'ar' ? 'عرض الرسالة: ' : 'Message: ') . $contactMessage->subject)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'تفاصيل الرسالة' : 'Inquiry Details' }}</h1>
            <p class="text-xs text-slate-500 mt-1">{{ $contactMessage->created_at->format('Y-m-d h:i A') }} ({{ $contactMessage->created_at->diffForHumans() }})</p>
        </div>
        <a href="{{ route('admin.contact-messages.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
            &larr; {{ app()->getLocale() === 'ar' ? 'العودة للرسائل' : 'Back to Inquiries' }}
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 lg:p-8 space-y-6">
        <!-- Sender Box -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-5 rounded-2xl bg-slate-50">
            <div>
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">{{ app()->getLocale() === 'ar' ? 'بيانات المرسل' : 'Sender Info' }}</span>
                <div class="text-base font-bold text-navy-900 mt-1">{{ $contactMessage->name }}</div>
                <div class="text-xs text-slate-600 mt-0.5">{{ $contactMessage->email }} &bull; {{ $contactMessage->phone }}</div>
            </div>
            <a href="mailto:{{ $contactMessage->email }}?subject=Re: {{ urlencode($contactMessage->subject) }}" class="px-4 py-2 bg-medical-600 hover:bg-medical-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-2 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'رد عبر البريد' : 'Reply via Email' }}</span>
            </a>
        </div>

        <div class="space-y-4">
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">{{ app()->getLocale() === 'ar' ? 'الموضوع' : 'Subject' }}</span>
                <div class="text-sm font-bold text-navy-900">{{ $contactMessage->subject }}</div>
            </div>

            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">{{ app()->getLocale() === 'ar' ? 'نص الرسالة' : 'Message Body' }}</span>
                <div class="p-5 rounded-2xl bg-slate-50/70 border border-slate-100 text-slate-700 text-xs leading-relaxed whitespace-pre-wrap">
                    {{ $contactMessage->message }}
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <span class="text-xs text-slate-400">
                {{ app()->getLocale() === 'ar' ? 'تمت القراءة في:' : 'Read on:' }} {{ $contactMessage->read_at ? $contactMessage->read_at->format('Y-m-d h:i A') : 'Just now' }}
            </span>
            <form action="{{ route('admin.contact-messages.destroy', $contactMessage->id) }}" method="POST" onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'هل تريد حذف هذه الرسالة نهائياً؟' : 'Delete this message permanently?' }}')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-rose-50 text-rose-700 hover:bg-rose-100 rounded-xl text-xs font-bold transition">
                    {{ app()->getLocale() === 'ar' ? 'حذف الرسالة' : 'Delete Message' }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
