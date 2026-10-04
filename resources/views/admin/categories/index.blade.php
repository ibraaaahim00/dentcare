@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'تصنيفات المدونة' : 'Blog Categories')

@section('content')
<div class="space-y-6" x-data="{ editingCategory: null }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'تصنيفات المقالات' : 'Blog Categories' }}</h1>
            <p class="text-xs text-slate-500 mt-1">{{ app()->getLocale() === 'ar' ? 'إدارة تصنيفات مقالات التوعية السنية' : 'Organize dental education articles by clinical topics' }}</p>
        </div>
        <a href="{{ route('admin.blog.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
            &larr; {{ app()->getLocale() === 'ar' ? 'العودة للمقالات' : 'Back to Blog' }}
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Add / Edit Category Form -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm h-fit">
            <h2 class="text-base font-bold text-navy-900 mb-4" x-text="editingCategory ? '{{ app()->getLocale() === 'ar' ? 'تعديل التصنيف' : 'Edit Category' }}' : '{{ app()->getLocale() === 'ar' ? 'إضافة تصنيف جديد' : 'Add New Category' }}'"></h2>

            <form :action="editingCategory ? '/admin/categories/' + editingCategory.id : '{{ route('admin.categories.store') }}'" method="POST" class="space-y-4">
                @csrf
                <template x-if="editingCategory">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'الاسم (بالعربية)' : 'Name (Arabic)' }} *</label>
                    <input type="text" name="name_ar" :value="editingCategory ? editingCategory.name_ar : ''" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'الاسم (بالإنجليزية)' : 'Name (English)' }} *</label>
                    <input type="text" name="name_en" :value="editingCategory ? editingCategory.name_en : ''" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'الاسم اللطيف (Slug) - اختياري' : 'Slug (Optional)' }}</label>
                    <input type="text" name="slug" :value="editingCategory ? editingCategory.slug : ''" placeholder="oral-hygiene" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                </div>

                <div class="pt-2 flex items-center gap-2">
                    <button type="submit" class="w-full py-2.5 bg-medical-600 hover:bg-medical-700 text-white rounded-xl text-xs font-bold shadow-md shadow-medical-600/20 transition">
                        <span x-text="editingCategory ? '{{ app()->getLocale() === 'ar' ? 'حفظ التعديل' : 'Update' }}' : '{{ app()->getLocale() === 'ar' ? 'إضافة التصنيف' : 'Create' }}'"></span>
                    </button>
                    <button type="button" x-show="editingCategory" @click="editingCategory = null" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition">
                        {{ app()->getLocale() === 'ar' ? 'إلغاء' : 'Cancel' }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Categories Table (2 cols) -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-start text-sm">
                    <thead>
                        <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider bg-slate-50/70 border-b border-slate-100">
                            <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'التصنيف (عربي)' : 'Name (AR)' }}</th>
                            <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'التصنيف (إنجليزي)' : 'Name (EN)' }}</th>
                            <th class="py-3.5 px-6 text-start">Slug</th>
                            <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'عدد المقالات' : 'Posts Count' }}</th>
                            <th class="py-3.5 px-6 text-end">{{ app()->getLocale() === 'ar' ? 'الإجراءات' : 'Actions' }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($categories as $cat)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6 font-bold text-navy-900 text-xs">{{ $cat->name_ar }}</td>
                                <td class="py-4 px-6 text-slate-700 text-xs">{{ $cat->name_en }}</td>
                                <td class="py-4 px-6 text-slate-400 font-mono text-[11px]">{{ $cat->slug }}</td>
                                <td class="py-4 px-6">
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-medical-50 text-medical-700">
                                        {{ $cat->posts_count }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-end">
                                    <div class="inline-flex items-center gap-2">
                                        <button type="button" @click="editingCategory = {{ json_encode($cat) }}" class="p-2 rounded-xl text-slate-400 hover:text-medical-600 hover:bg-slate-100 transition" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                        <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'هل تريد حذف هذا التصنيف؟' : 'Delete category?' }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-slate-400 text-sm">
                                    {{ app()->getLocale() === 'ar' ? 'لا توجد تصنيفات بعد.' : 'No categories found.' }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($categories->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
