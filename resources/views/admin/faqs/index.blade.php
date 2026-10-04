@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'الأسئلة الشائعة' : 'FAQs Management')

@section('content')
<div class="space-y-6" x-data="{ editingFaq: null }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'الأسئلة الشائعة والأجوبة' : 'Frequently Asked Questions' }}</h1>
            <p class="text-xs text-slate-500 mt-1">{{ app()->getLocale() === 'ar' ? 'إدارة استفسارات المرضى وإجابات الفريق الطبي عليها' : 'Manage common patient questions and dental advice answers' }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Add / Edit Form -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm h-fit">
            <h2 class="text-base font-bold text-navy-900 mb-4" x-text="editingFaq ? '{{ app()->getLocale() === 'ar' ? 'تعديل السؤال' : 'Edit FAQ' }}' : '{{ app()->getLocale() === 'ar' ? 'إضافة سؤال جديد' : 'Add FAQ' }}'"></h2>

            <form :action="editingFaq ? '/admin/faqs/' + editingFaq.id : '{{ route('admin.faqs.store') }}'" method="POST" class="space-y-4">
                @csrf
                <template x-if="editingFaq">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'السؤال (بالعربية)' : 'Question (Arabic)' }} *</label>
                    <input type="text" name="question_ar" :value="editingFaq ? editingFaq.question_ar : ''" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'السؤال (بالإنجليزية)' : 'Question (English)' }} *</label>
                    <input type="text" name="question_en" :value="editingFaq ? editingFaq.question_en : ''" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'الإجابة (بالعربية)' : 'Answer (Arabic)' }} *</label>
                    <textarea name="answer_ar" rows="3" required class="w-full text-sm rounded-xl border border-slate-200 p-3.5 focus:outline-none focus:ring-2 focus:ring-medical-500" x-text="editingFaq ? editingFaq.answer_ar : ''"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'الإجابة (بالإنجليزية)' : 'Answer (English)' }} *</label>
                    <textarea name="answer_en" rows="3" required class="w-full text-sm rounded-xl border border-slate-200 p-3.5 focus:outline-none focus:ring-2 focus:ring-medical-500" x-text="editingFaq ? editingFaq.answer_en : ''"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-3 items-center">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'ترتيب الظهور' : 'Sort Order' }}</label>
                        <input type="number" name="sort_order" :value="editingFaq ? editingFaq.sort_order : 0" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    </div>
                    <div class="pt-5">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" :checked="editingFaq ? editingFaq.is_active : true" class="w-4 h-4 text-medical-600 rounded border-slate-300">
                            <span class="text-xs font-bold text-slate-700">{{ app()->getLocale() === 'ar' ? 'نشط' : 'Active' }}</span>
                        </label>
                    </div>
                </div>

                <div class="pt-2 flex items-center gap-2">
                    <button type="submit" class="w-full py-2.5 bg-medical-600 hover:bg-medical-700 text-white rounded-xl text-xs font-bold shadow-md shadow-medical-600/20 transition">
                        <span x-text="editingFaq ? '{{ app()->getLocale() === 'ar' ? 'حفظ التعديل' : 'Update FAQ' }}' : '{{ app()->getLocale() === 'ar' ? 'إضافة السؤال' : 'Add FAQ' }}'"></span>
                    </button>
                    <button type="button" x-show="editingFaq" @click="editingFaq = null" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition">
                        {{ app()->getLocale() === 'ar' ? 'إلغاء' : 'Cancel' }}
                    </button>
                </div>
            </form>
        </div>

        <!-- FAQs List (2 cols) -->
        <div class="lg:col-span-2 space-y-3">
            @forelse($faqs as $faq)
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-5 space-y-3">
                    <div class="flex items-start justify-between gap-3">
                        <div class="space-y-1">
                            <h3 class="font-bold text-navy-900 text-sm">{{ app()->getLocale() === 'ar' ? $faq->question_ar : $faq->question_en }}</h3>
                            <p class="text-xs text-slate-400">{{ app()->getLocale() === 'ar' ? $faq->question_en : $faq->question_ar }}</p>
                        </div>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full shrink-0 {{ $faq->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                            {{ $faq->is_active ? (app()->getLocale() === 'ar' ? 'نشط' : 'Active') : (app()->getLocale() === 'ar' ? 'معطل' : 'Disabled') }}
                        </span>
                    </div>

                    <p class="text-xs text-slate-600 leading-relaxed bg-slate-50/70 p-3.5 rounded-2xl">
                        {{ app()->getLocale() === 'ar' ? $faq->answer_ar : $faq->answer_en }}
                    </p>

                    <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                        <button type="button" @click="editingFaq = {{ json_encode($faq) }}" class="p-1.5 text-slate-400 hover:text-medical-600 rounded-lg transition" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                        <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'هل تريد حذف هذا السؤال؟' : 'Delete FAQ?' }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 rounded-lg transition" title="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="py-12 text-center text-slate-400 text-sm bg-white rounded-3xl border border-slate-100">
                    {{ app()->getLocale() === 'ar' ? 'لا توجد أسئلة شائعة مسجلة بعد.' : 'No FAQs recorded.' }}
                </div>
            @endforelse

            @if($faqs->hasPages())
                <div class="p-4 bg-white rounded-2xl border border-slate-100">
                    {{ $faqs->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
