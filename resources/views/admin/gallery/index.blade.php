@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'معرض صور العيادة والحالات' : 'Clinic Gallery')

@section('content')
<div class="space-y-6" x-data="{ editingItem: null }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'معرض الصور وقبل/بعد' : 'Clinic Gallery & Cases' }}</h1>
            <p class="text-xs text-slate-500 mt-1">{{ app()->getLocale() === 'ar' ? 'إدارة صور مرافق العيادة، الأجهزة الحديثة، ونتائج الحالات العلاجية' : 'Manage clinic visual facilities, modern tech, and smile transformations' }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Upload / Edit Form -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm h-fit">
            <h2 class="text-base font-bold text-navy-900 mb-4" x-text="editingItem ? '{{ app()->getLocale() === 'ar' ? 'تعديل بيانات الصورة' : 'Edit Gallery Item' }}' : '{{ app()->getLocale() === 'ar' ? 'إضافة صورة جديدة للمعرض' : 'Upload New Gallery Item' }}'"></h2>

            <form :action="editingItem ? '/admin/gallery/' + editingItem.id : '{{ route('admin.gallery.store') }}'" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <template x-if="editingItem">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'العنوان (بالعربية)' : 'Title (Arabic)' }} *</label>
                    <input type="text" name="title_ar" :value="editingItem ? editingItem.title_ar : ''" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'العنوان (بالإنجليزية)' : 'Title (English)' }} *</label>
                    <input type="text" name="title_en" :value="editingItem ? editingItem.title_en : ''" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'التصنيف' : 'Category' }}</label>
                    <input type="text" name="category" :value="editingItem ? editingItem.category : ''" placeholder="Cosmetics, Ortho, Surgery" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">
                        <span x-text="editingItem ? '{{ app()->getLocale() === 'ar' ? 'تغيير الصورة الرئيسية (اختياري)' : 'Change Main Image (optional)' }}' : '{{ app()->getLocale() === 'ar' ? 'ملف الصورة الرئيسية *' : 'Main Image File *' }}'"></span>
                    </label>
                    <input type="file" name="image" accept="image/*" :required="!editingItem" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-medical-50 file:text-medical-700 hover:file:bg-medical-100">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'صورة قبل (اختياري)' : 'Before Image' }}</label>
                        <input type="file" name="before_image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-2 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-50 file:text-slate-700 hover:file:bg-slate-100">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'صورة بعد (اختياري)' : 'After Image' }}</label>
                        <input type="file" name="after_image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-2 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-50 file:text-slate-700 hover:file:bg-slate-100">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 items-center">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'ترتيب الظهور' : 'Sort Order' }}</label>
                        <input type="number" name="sort_order" :value="editingItem ? editingItem.sort_order : 0" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    </div>
                    <div class="pt-5">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" :checked="editingItem ? editingItem.is_active : true" class="w-4 h-4 text-medical-600 rounded border-slate-300">
                            <span class="text-xs font-bold text-slate-700">{{ app()->getLocale() === 'ar' ? 'نشطة' : 'Active' }}</span>
                        </label>
                    </div>
                </div>

                <div class="pt-2 flex items-center gap-2">
                    <button type="submit" class="w-full py-2.5 bg-medical-600 hover:bg-medical-700 text-white rounded-xl text-xs font-bold shadow-md shadow-medical-600/20 transition">
                        <span x-text="editingItem ? '{{ app()->getLocale() === 'ar' ? 'حفظ التعديلات' : 'Update Item' }}' : '{{ app()->getLocale() === 'ar' ? 'رفع وحفظ الصورة' : 'Upload Image' }}'"></span>
                    </button>
                    <button type="button" x-show="editingItem" @click="editingItem = null" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition">
                        {{ app()->getLocale() === 'ar' ? 'إلغاء' : 'Cancel' }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Gallery Grid (2 cols) -->
        <div class="lg:col-span-2">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @forelse($items as $item)
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden group">
                        <div class="relative h-44 overflow-hidden bg-slate-100">
                            <img src="{{ $item->image_url }}" alt="{{ $item->title_en }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            <div class="absolute top-2 right-2 flex items-center gap-1.5">
                                <form action="{{ route('admin.gallery.toggle', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="p-2 bg-white/90 backdrop-blur-sm text-slate-600 hover:text-medical-600 rounded-xl shadow transition" title="{{ $item->is_active ? 'Deactivate' : 'Activate' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                </form>
                                <button type="button" @click="editingItem = {{ json_encode($item) }}" class="p-2 bg-white/90 backdrop-blur-sm text-slate-600 hover:text-medical-600 rounded-xl shadow transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <form action="{{ route('admin.gallery.destroy', $item->id) }}" method="POST" onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'هل أنت متأكد من حذف هذه الصورة؟' : 'Delete image?' }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-white/90 backdrop-blur-sm text-rose-600 rounded-xl hover:bg-white shadow transition" title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="p-4 flex items-center justify-between">
                            <div>
                                <h3 class="text-xs font-bold text-navy-900">{{ app()->getLocale() === 'ar' ? $item->title_ar : $item->title_en }}</h3>
                                <p class="text-[10px] text-slate-400 mt-0.5">{{ $item->category ?: (app()->getLocale() === 'ar' ? $item->title_en : $item->title_ar) }}</p>
                            </div>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $item->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                {{ $item->is_active ? (app()->getLocale() === 'ar' ? 'نشط' : 'Active') : (app()->getLocale() === 'ar' ? 'معطل' : 'Disabled') }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 py-12 text-center text-slate-400 text-sm bg-white rounded-3xl border border-slate-100">
                        {{ app()->getLocale() === 'ar' ? 'لا توجد صور في المعرض بعد.' : 'No gallery items found.' }}
                    </div>
                @endforelse
            </div>

            @if($items->hasPages())
                <div class="p-4 mt-4 bg-white rounded-2xl border border-slate-100">
                    {{ $items->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
