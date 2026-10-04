@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'رسائل واستفسارات الزوار' : 'Contact Inquiries')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'رسائل واستفسارات الزوار' : 'Contact Inquiries' }}</h1>
            <p class="text-xs text-slate-500 mt-1">{{ app()->getLocale() === 'ar' ? 'متابعة رسائل اتصل بنا، استفسارات الحجز، والتواصل المباشر' : 'Review direct messages from public contact form' }}</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.contact-messages.index') }}" class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ !request('status') ? 'bg-medical-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-50' }}">
                {{ app()->getLocale() === 'ar' ? 'الكل' : 'All' }}
            </a>
            <a href="{{ route('admin.contact-messages.index', ['status' => 'unread']) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ request('status') === 'unread' ? 'bg-rose-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-50' }}">
                {{ app()->getLocale() === 'ar' ? 'غير مقروءة' : 'Unread' }}
            </a>
            <a href="{{ route('admin.contact-messages.index', ['status' => 'read']) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ request('status') === 'read' ? 'bg-slate-800 text-white' : 'bg-white text-slate-600 hover:bg-slate-50' }}">
                {{ app()->getLocale() === 'ar' ? 'مقروءة' : 'Read' }}
            </a>
        </div>
    </div>

    <!-- Messages Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-start text-sm">
                <thead>
                    <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider bg-slate-50/70 border-b border-slate-100">
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'المرسل' : 'Sender' }}</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'الموضوع' : 'Subject' }}</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'الحالة' : 'Status' }}</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'التاريخ' : 'Date' }}</th>
                        <th class="py-3.5 px-6 text-end">{{ app()->getLocale() === 'ar' ? 'الإجراءات' : 'Actions' }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($messages as $msg)
                        <tr class="hover:bg-slate-50/50 transition {{ $msg->status->value === 'unread' ? 'bg-medical-50/30 font-semibold' : '' }}">
                            <td class="py-4 px-6">
                                <div class="font-bold text-navy-900 text-xs">{{ $msg->name }}</div>
                                <div class="text-[11px] text-slate-400">{{ $msg->email }} &bull; {{ $msg->phone }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-xs text-navy-900 font-medium line-clamp-1">{{ $msg->subject }}</div>
                                <div class="text-[11px] text-slate-400 line-clamp-1">{{ $msg->message }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 text-[10px] font-bold rounded-full {{ $msg->status->value === 'unread' ? 'bg-rose-50 text-rose-600' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $msg->status->value === 'unread' ? (app()->getLocale() === 'ar' ? 'غير مقروءة' : 'Unread') : (app()->getLocale() === 'ar' ? 'مقروءة' : 'Read') }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-xs text-slate-400">
                                {{ $msg->created_at->diffForHumans() }}
                            </td>
                            <td class="py-4 px-6 text-end">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.contact-messages.show', $msg->id) }}" class="px-3 py-1.5 bg-medical-50 text-medical-700 hover:bg-medical-100 rounded-xl text-xs font-bold transition">
                                        {{ app()->getLocale() === 'ar' ? 'قراءة' : 'Read' }}
                                    </a>
                                    <form action="{{ route('admin.contact-messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'هل تريد حذف هذه الرسالة؟' : 'Delete message?' }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400 text-sm">
                                {{ app()->getLocale() === 'ar' ? 'لا توجد رسائل مطابقة.' : 'No messages found.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($messages->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $messages->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
