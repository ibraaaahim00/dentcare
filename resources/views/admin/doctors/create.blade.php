@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'إضافة طبيب جديد' : 'Add New Doctor')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">{{ app()->getLocale() === 'ar' ? 'إضافة طبيب جديد' : 'Add New Doctor' }}</h1>
            <p class="text-xs text-slate-500 mt-1">{{ app()->getLocale() === 'ar' ? 'إنشاء حساب طبيب جديد وتحديد التخصص والخدمات المرتبطة' : 'Create new doctor account with medical specialization and assigned services' }}</p>
        </div>
        <a href="{{ route('admin.doctors.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
            &larr; {{ app()->getLocale() === 'ar' ? 'العودة للقائمة' : 'Back to Doctors' }}
        </a>
    </div>

    <form action="{{ route('admin.doctors.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 lg:p-8 space-y-8">
        @csrf

        <!-- Account Information Section -->
        <div>
            <h2 class="text-sm font-bold text-navy-900 uppercase tracking-wider pb-3 border-b border-slate-100 mb-4 flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-medical-50 text-medical-600 flex items-center justify-center text-xs">1</span>
                <span>{{ app()->getLocale() === 'ar' ? 'بيانات الحساب الشخصي' : 'Account Credentials' }}</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'الاسم الكامل' : 'Full Name' }} *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    @error('name')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني' : 'Email Address' }} *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    @error('email')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'رقم الهاتف' : 'Phone Number' }} *</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    @error('phone')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'كلمة المرور' : 'Password' }} *</label>
                    <input type="password" name="password" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    @error('password')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <!-- Medical Profile Section -->
        <div>
            <h2 class="text-sm font-bold text-navy-900 uppercase tracking-wider pb-3 border-b border-slate-100 mb-4 flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-medical-50 text-medical-600 flex items-center justify-center text-xs">2</span>
                <span>{{ app()->getLocale() === 'ar' ? 'البيانات المهنية والطبية' : 'Professional Medical Profile' }}</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'التخصص الطبي' : 'Specialization' }} *</label>
                    <input type="text" name="specialization" value="{{ old('specialization') }}" placeholder="e.g. Orthodontics, Implantology" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    @error('specialization')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'سنوات الخبرة' : 'Experience (Years)' }} *</label>
                    <input type="number" name="experience_years" value="{{ old('experience_years', 5) }}" min="0" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    @error('experience_years')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'سعر الكشف ($)' : 'Consultation Fee ($)' }} *</label>
                    <input type="number" step="0.01" name="consultation_fee" value="{{ old('consultation_fee', 50.00) }}" min="0" required class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    @error('consultation_fee')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-3">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'المؤهلات العلمية' : 'Qualifications & Degrees' }}</label>
                    <input type="text" name="qualifications" value="{{ old('qualifications') }}" placeholder="e.g. DDS, MSc Oral Surgery, Harvard Dental Fellow" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-medical-500">
                </div>

                <div class="md:col-span-3">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'نبذة تعريفية' : 'Doctor Biography' }}</label>
                    <textarea name="bio" rows="3" class="w-full text-sm rounded-xl border border-slate-200 p-3.5 focus:outline-none focus:ring-2 focus:ring-medical-500">{{ old('bio') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Services Assignment & Photo -->
        <div>
            <h2 class="text-sm font-bold text-navy-900 uppercase tracking-wider pb-3 border-b border-slate-100 mb-4 flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-medical-50 text-medical-600 flex items-center justify-center text-xs">3</span>
                <span>{{ app()->getLocale() === 'ar' ? 'الخدمات الموكلة والصورة الشخصية' : 'Assigned Services & Photo' }}</span>
            </h2>

            <div class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-2">{{ app()->getLocale() === 'ar' ? 'حدد الخدمات التي يقدمها الطبيب:' : 'Assign Services this Doctor Provides:' }}</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        @foreach($services as $service)
                            <label class="flex items-center gap-2.5 text-xs text-slate-700 cursor-pointer p-2 rounded-xl hover:bg-white transition">
                                <input type="checkbox" name="services[]" value="{{ $service->id }}" {{ in_array($service->id, old('services', [])) ? 'checked' : '' }} class="w-4 h-4 text-medical-600 rounded border-slate-300 focus:ring-medical-500">
                                <span class="font-medium">{{ app()->getLocale() === 'ar' ? $service->name_ar : $service->name_en }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 items-center">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'الصورة الشخصية للطبيب' : 'Profile Image' }}</label>
                        <input type="file" name="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-medical-50 file:text-medical-700 hover:file:bg-medical-100">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ app()->getLocale() === 'ar' ? 'ترتيب الظهور' : 'Sort Order' }}</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full text-sm rounded-xl border border-slate-200 px-3.5 py-2 focus:outline-none focus:ring-2 focus:ring-medical-500">
                    </div>

                    <div class="pt-5">
                        <label class="flex items-center gap-2.5 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 text-medical-600 rounded border-slate-300 focus:ring-medical-500">
                            <span class="text-xs font-bold text-slate-700">{{ app()->getLocale() === 'ar' ? 'الحساب مفعّل للعمل والحجوزات' : 'Account Active for Bookings' }}</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.doctors.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition">
                {{ app()->getLocale() === 'ar' ? 'إلغاء' : 'Cancel' }}
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-medical-600 hover:bg-medical-700 text-white font-bold text-sm shadow-md shadow-medical-600/20 transition">
                {{ app()->getLocale() === 'ar' ? 'حفظ الطبيب' : 'Save Doctor' }}
            </button>
        </div>
    </form>
</div>
@endsection
