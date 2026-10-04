@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'إدارة لماذا تختارنا' : 'Why Choose Us CMS')

@section('content')
<div class="space-y-6" x-data="{ openModal: false, isEdit: false, formAction: '', feat: { id: null, title_ar: '', title_en: '', description_ar: '', description_en: '', icon: 'shield-check', sort_order: 1, is_active: true } }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'قسم لماذا تختارنا (Why Choose Us CMS)' : 'Why Choose Us Features' }}</h1>
            <p class="text-xs text-slate-500 mt-1">{{ app()->getLocale() === 'ar' ? 'إدارة الميزات التنافسية والقيم المضافة للعيادة المعروضة في الصفحة الرئيسية' : 'Manage key highlights, advanced clinic tech, sterilization standards, and competitive edges' }}</p>
        </div>
        <button @click="isEdit = false; formAction = '{{ route('admin.features.store') }}'; feat = { id: null, title_ar: '', title_en: '', description_ar: '', description_en: '', icon: 'shield-check', sort_order: 1, is_active: true }; openModal = true;" class="px-5 py-2.5 rounded-xl bg-medical-600 hover:bg-medical-700 text-white font-bold text-sm shadow-md shadow-medical-600/20 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>{{ app()->getLocale() === 'ar' ? 'إضافة ميزة جديدة' : 'Add Feature' }}</span>
        </button>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-start text-sm">
                <thead>
                    <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider bg-slate-50/70 border-b border-slate-100">
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'الميزة' : 'Feature' }}</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'الوصف' : 'Description' }}</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'الرمز' : 'Icon' }}</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'الترتيب' : 'Order' }}</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'الحالة' : 'Status' }}</th>
                        <th class="py-3.5 px-6 text-end">{{ app()->getLocale() === 'ar' ? 'الإجراءات' : 'Actions' }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($features as $item)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 font-bold text-slate-900">
                                {{ $item->title }}
                            </td>
                            <td class="py-4 px-6 text-xs text-slate-500 max-w-sm">
                                <div class="line-clamp-2">{{ $item->description }}</div>
                            </td>
                            <td class="py-4 px-6 font-mono text-xs text-slate-600">
                                {{ $item->icon ?? 'star' }}
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-600">
                                #{{ $item->sort_order }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 text-[11px] font-bold rounded-full {{ $item->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $item->is_active ? (app()->getLocale() === 'ar' ? 'نشط' : 'Active') : (app()->getLocale() === 'ar' ? 'معطل' : 'Disabled') }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-end">
                                <div class="inline-flex items-center gap-2">
                                    <button @click="isEdit = true; formAction = '/admin/features/{{ $item->id }}'; feat = { id: {{ $item->id }}, title_ar: '{{ addslashes($item->title_ar) }}', title_en: '{{ addslashes($item->title_en) }}', description_ar: '{{ addslashes(str_replace(["\r", "\n"], ' ', $item->description_ar)) }}', description_en: '{{ addslashes(str_replace(["\r", "\n"], ' ', $item->description_en)) }}', icon: '{{ $item->icon }}', sort_order: {{ $item->sort_order }}, is_active: {{ $item->is_active ? 'true' : 'false' }} }; openModal = true;" class="p-2 rounded-xl text-slate-400 hover:text-medical-600 hover:bg-slate-100 transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <form action="{{ route('admin.features.destroy', $item->id) }}" method="POST" onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'هل أنت متأكد من الحذف؟' : 'Are you sure you want to delete this feature?' }}')">
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
                            <td colspan="6" class="py-12 text-center text-slate-400 text-sm">
                                {{ app()->getLocale() === 'ar' ? 'لا توجد ميزات مضافة حتى الآن.' : 'No features created yet.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Create / Edit -->
    <div x-show="openModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-navy-950/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div @click.away="openModal = false" class="bg-white rounded-3xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-slate-100">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-extrabold text-navy-900 text-base" x-text="isEdit ? '{{ app()->getLocale() === 'ar' ? 'تعديل الميزة' : 'Edit Feature' }}' : '{{ app()->getLocale() === 'ar' ? 'إضافة ميزة جديدة' : 'Add New Feature' }}'"></h3>
                <button @click="openModal = false" class="text-slate-400 hover:text-slate-600">&times;</button>
            </div>

            <form :action="formAction" method="POST" class="space-y-4">
                @csrf
                <template x-if="isEdit">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'العنوان (عربي) *' : 'Title (Arabic) *' }}</label>
                        <input type="text" name="title_ar" x-model="feat.title_ar" required placeholder="أحدث تقنيات الليزر" class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'العنوان (إنجليزي) *' : 'Title (English) *' }}</label>
                        <input type="text" name="title_en" x-model="feat.title_en" required placeholder="Latest Laser Tech" class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'الوصف (عربي) *' : 'Description (Arabic) *' }}</label>
                    <textarea name="description_ar" x-model="feat.description_ar" rows="3" required class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:ring-2 focus:ring-medical-500 focus:outline-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'الوصف (إنجليزي) *' : 'Description (English) *' }}</label>
                    <textarea name="description_en" x-model="feat.description_en" rows="3" required class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:ring-2 focus:ring-medical-500 focus:outline-none"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'رمز الأيقونة' : 'Icon Key' }}</label>
                        <input type="text" name="icon" x-model="feat.icon" placeholder="shield-check, sparkles, clock, user-group" class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'الترتيب' : 'Sort Order' }}</label>
                        <input type="number" name="sort_order" x-model="feat.sort_order" min="0" class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                    </div>
                </div>

                <div class="pt-2">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" x-model="feat.is_active" class="sr-only peer">
                        <div class="w-10 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-600"></div>
                        <span class="ms-2 text-xs font-bold text-slate-700">{{ app()->getLocale() === 'ar' ? 'تفعيل الظهور' : 'Active Status' }}</span>
                    </label>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button type="button" @click="openModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold">{{ app()->getLocale() === 'ar' ? 'إلغاء' : 'Cancel' }}</button>
                    <button type="submit" class="px-5 py-2 bg-medical-600 text-white rounded-xl text-xs font-bold hover:bg-medical-700 transition">{{ app()->getLocale() === 'ar' ? 'حفظ' : 'Save' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
