@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'إدارة تقييمات المرضى' : 'Patient Reviews')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'تقييمات وآراء المرضى' : 'Reviews & Testimonials' }}</h1>
            <p class="text-xs text-slate-500 mt-1">{{ app()->getLocale() === 'ar' ? 'مراجعة واعتماد التقييمات قبل نشرها على الموقع العام' : 'Moderate patient reviews before they are displayed publicly on the landing page' }}</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.reviews.index') }}" class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ !request('status') ? 'bg-medical-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-50' }}">
                {{ app()->getLocale() === 'ar' ? 'الكل' : 'All' }}
            </a>
            <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ request('status') === 'pending' ? 'bg-amber-500 text-white' : 'bg-white text-slate-600 hover:bg-slate-50' }}">
                {{ app()->getLocale() === 'ar' ? 'بانتظار الاعتماد' : 'Pending' }}
            </a>
            <a href="{{ route('admin.reviews.index', ['status' => 'approved']) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ request('status') === 'approved' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-50' }}">
                {{ app()->getLocale() === 'ar' ? 'المعتمدة' : 'Approved' }}
            </a>
            <a href="{{ route('admin.reviews.index', ['status' => 'rejected']) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ request('status') === 'rejected' ? 'bg-rose-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-50' }}">
                {{ app()->getLocale() === 'ar' ? 'المرفوضة' : 'Rejected' }}
            </a>
        </div>
    </div>

    <!-- Reviews Grid / Table -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        @forelse($reviews as $rev)
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $rev->patient->avatar_url }}" alt="" class="w-10 h-10 rounded-full object-cover border border-slate-100">
                            <div>
                                <h3 class="font-bold text-navy-900 text-sm">{{ $rev->patient->name }}</h3>
                                <p class="text-[11px] text-slate-400">{{ $rev->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 text-[11px] font-bold rounded-full {{ $rev->status->value === 'approved' ? 'bg-emerald-50 text-emerald-700' : ($rev->status->value === 'rejected' ? 'bg-rose-50 text-rose-700' : 'bg-amber-50 text-amber-700') }}">
                            {{ ucfirst($rev->status->value) }}
                        </span>
                    </div>

                    <!-- Stars -->
                    <div class="flex items-center gap-1 text-amber-400 text-sm">
                        @for($i = 1; $i <= 5; $i++)
                            <span>{{ $i <= $rev->rating ? '★' : '☆' }}</span>
                        @endfor
                        <span class="text-xs font-bold text-slate-600 ms-1">({{ $rev->rating }}/5)</span>
                    </div>

                    <!-- Comment -->
                    <p class="text-xs text-slate-600 leading-relaxed bg-slate-50/70 p-3.5 rounded-2xl">
                        "{{ $rev->comment }}"
                    </p>

                    @if($rev->doctor)
                        <div class="text-[11px] text-slate-400">
                            {{ app()->getLocale() === 'ar' ? 'التقييم موجه للطبيب:' : 'Doctor rated:' }} <span class="font-semibold text-slate-700">{{ $rev->doctor->user->name }}</span>
                        </div>
                    @endif
                </div>

                <!-- Moderation Actions -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        @if($rev->status->value !== 'approved')
                            <form action="{{ route('admin.reviews.update-status', $rev->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="px-3 py-1.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 rounded-xl text-xs font-bold transition">
                                    {{ app()->getLocale() === 'ar' ? 'اعتماد ونشر' : 'Approve' }}
                                </button>
                            </form>
                        @endif

                        @if($rev->status->value !== 'rejected')
                            <form action="{{ route('admin.reviews.update-status', $rev->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="px-3 py-1.5 bg-rose-50 text-rose-700 hover:bg-rose-100 rounded-xl text-xs font-bold transition">
                                    {{ app()->getLocale() === 'ar' ? 'رفض' : 'Reject' }}
                                </button>
                            </form>
                        @endif
                    </div>

                    <form action="{{ route('admin.reviews.destroy', $rev->id) }}" method="POST" onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'هل تريد حذف هذا التقييم؟' : 'Delete review?' }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 rounded-lg transition" title="Delete">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-2 py-12 text-center text-slate-400 text-sm bg-white rounded-3xl border border-slate-100">
                {{ app()->getLocale() === 'ar' ? 'لا توجد تقييمات مطابقة.' : 'No reviews found.' }}
            </div>
        @endforelse
    </div>

    @if($reviews->hasPages())
        <div class="p-4 bg-white rounded-2xl border border-slate-100">
            {{ $reviews->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection
