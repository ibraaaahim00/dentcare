@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'إدارة الإحصائيات' : 'Statistics CMS')

@section('content')
<div class="space-y-6" x-data="{ openModal: false, isEdit: false, formAction: '', stat: { id: null, title_ar: '', title_en: '', value: '', icon: 'users', sort_order: 1, is_active: true } }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'إحصائيات وأرقام العيادة (Statistics CMS)' : 'Clinic Statistics' }}</h1>
            <p class="text-xs text-slate-500 mt-1">{{ app()->getLocale() === 'ar' ? 'الأرقام والإنجازات المعروضة في الصفحة الرئيسية وصفحات الموقع (مثل: 5000+ مريض سعيد، 15+ طبيب مختص)' : 'Manage trust metrics, patient counts, and clinic milestones shown across the website' }}</p>
        </div>
        <button @click="isEdit = false; formAction = '{{ route('admin.statistics.store') }}'; stat = { id: null, title_ar: '', title_en: '', value: '', icon: 'users', sort_order: 1, is_active: true }; openModal = true;" class="px-5 py-2.5 rounded-xl bg-medical-600 hover:bg-medical-700 text-white font-bold text-sm shadow-md shadow-medical-600/20 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>{{ app()->getLocale() === 'ar' ? 'إضافة إحصائية جديدة' : 'Add Statistic' }}</span>
        </button>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-start text-sm">
                <thead>
                    <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider bg-slate-50/70 border-b border-slate-100">
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'القيمة / الرقم' : 'Value / Metric' }}</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'العنوان' : 'Title' }}</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'الأيقونة' : 'Icon' }}</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'الترتيب' : 'Order' }}</th>
                        <th class="py-3.5 px-6 text-start">{{ app()->getLocale() === 'ar' ? 'الحالة' : 'Status' }}</th>
                        <th class="py-3.5 px-6 text-end">{{ app()->getLocale() === 'ar' ? 'الإجراءات' : 'Actions' }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($statistics as $item)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 font-extrabold text-medical-600 text-base">
                                {{ $item->value }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900">{{ $item->title }}</div>
                                <div class="text-[11px] text-slate-400">AR: {{ $item->title_ar }} | EN: {{ $item->title_en }}</div>
                            </td>
                            <td class="py-4 px-6 font-mono text-xs text-slate-600">
                                {{ $item->icon ?? 'users' }}
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
                                    <button @click="isEdit = true; formAction = '/admin/statistics/{{ $item->id }}'; stat = { id: {{ $item->id }}, title_ar: '{{ addslashes($item->title_ar) }}', title_en: '{{ addslashes($item->title_en) }}', value: '{{ addslashes($item->value) }}', icon: '{{ $item->icon }}', sort_order: {{ $item->sort_order }}, is_active: {{ $item->is_active ? 'true' : 'false' }} }; openModal = true;" class="p-2 rounded-xl text-slate-400 hover:text-medical-600 hover:bg-slate-100 transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <form action="{{ route('admin.statistics.destroy', $item->id) }}" method="POST" onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'هل أنت متأكد من الحذف؟' : 'Are you sure you want to delete this statistic?' }}')">
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
                                {{ app()->getLocale() === 'ar' ? 'لا توجد إحصائيات مضافة حتى الآن.' : 'No statistics created yet.' }}
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
                <h3 class="font-extrabold text-navy-900 text-base" x-text="isEdit ? '{{ app()->getLocale() === 'ar' ? 'تعديل الإحصائية' : 'Edit Statistic' }}' : '{{ app()->getLocale() === 'ar' ? 'إضافة إحصائية جديدة' : 'Add New Statistic' }}'"></h3>
                <button @click="openModal = false" class="text-slate-400 hover:text-slate-600">&times;</button>
            </div>

            <form :action="formAction" method="POST" class="space-y-4">
                @csrf
                <template x-if="isEdit">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'القيمة / الرقم (مثال: +15,000 أو 99.8%) *' : 'Value / Number (e.g. 15,000+ or 99.8%) *' }}</label>
                    <input type="text" name="value" x-model="stat.value" required placeholder="5,000+" class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'العنوان (عربي) *' : 'Title (Arabic) *' }}</label>
                        <input type="text" name="title_ar" x-model="stat.title_ar" required placeholder="مريض يثق بنا" class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'العنوان (إنجليزي) *' : 'Title (English) *' }}</label>
                        <input type="text" name="title_en" x-model="stat.title_en" required placeholder="Happy Patients" class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'اسم الأيقونة (اختياري)' : 'Icon Key (Optional)' }}</label>
                        <input type="text" name="icon" x-model="stat.icon" placeholder="users, star, trophy, heart" class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'ar' ? 'ترتيب الظهور' : 'Sort Order' }}</label>
                        <input type="number" name="sort_order" x-model="stat.sort_order" min="0" class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:ring-2 focus:ring-medical-500 focus:outline-none">
                    </div>
                </div>

                <div class="pt-2">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" x-model="stat.is_active" class="sr-only peer">
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
