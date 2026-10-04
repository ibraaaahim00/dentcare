@extends('layouts.doctor')

@section('title', app()->getLocale() === 'ar' ? 'الملف الطبي والشخصي' : 'Doctor Profile')
@section('page_title', app()->getLocale() === 'ar' ? 'الملف الطبي والشخصي للطبيب' : 'Clinical & Personal Profile')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm">
        <form method="POST" action="{{ route('doctor.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Avatar / Photo -->
            <div class="flex items-center gap-6 pb-6 border-b border-slate-100">
                <img src="{{ $doctor->image_url }}" alt="" class="w-20 h-20 rounded-2xl object-cover border-2 border-slate-200">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-2">{{ app()->getLocale() === 'ar' ? 'تغيير صورة الطبيب' : 'Doctor Portrait' }}</label>
                    <input type="file" name="image" class="text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-medical-50 file:text-medical-700 hover:file:bg-medical-100">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">{{ app()->getLocale() === 'ar' ? 'الاسم' : 'Doctor Name' }}</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $doctor->user->name) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500">
                </div>
                <div>
                    <label for="specialization" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">{{ app()->getLocale() === 'ar' ? 'التخصص الطبي' : 'Specialization' }}</label>
                    <input type="text" id="specialization" name="specialization" value="{{ old('specialization', $doctor->specialization) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">{{ __('app.email') }}</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $doctor->user->email) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500">
                </div>
                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">{{ __('app.phone') }}</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $doctor->user->phone) }}" required dir="ltr"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="experience_years" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">{{ app()->getLocale() === 'ar' ? 'سنوات الخبرة' : 'Years Experience' }}</label>
                    <input type="number" id="experience_years" name="experience_years" value="{{ old('experience_years', $doctor->experience_years) }}" min="0" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white">
                </div>
                <div>
                    <label for="consultation_fee" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">{{ app()->getLocale() === 'ar' ? 'رسوم الاستشارة ($)' : 'Consultation Fee ($)' }}</label>
                    <input type="number" step="0.01" id="consultation_fee" name="consultation_fee" value="{{ old('consultation_fee', $doctor->consultation_fee) }}" min="0" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white">
                </div>
            </div>

            <div>
                <label for="bio" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">{{ app()->getLocale() === 'ar' ? 'النبذة المهنية' : 'Biography' }}</label>
                <textarea id="bio" name="bio" rows="3"
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">{{ old('bio', $doctor->bio) }}</textarea>
            </div>

            <div>
                <label for="qualifications" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">{{ app()->getLocale() === 'ar' ? 'المؤهلات العلمية' : 'Qualifications' }}</label>
                <textarea id="qualifications" name="qualifications" rows="2"
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">{{ old('qualifications', $doctor->qualifications) }}</textarea>
            </div>

            <!-- Services Offered -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-2">{{ app()->getLocale() === 'ar' ? 'الخدمات التي تقدمها' : 'Offered Services' }}</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                    @php $myServices = $doctor->services->pluck('id')->toArray(); @endphp
                    @foreach($allServices as $srv)
                        <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 text-xs cursor-pointer hover:bg-slate-50">
                            <input type="checkbox" name="services[]" value="{{ $srv->id }}" {{ in_array($srv->id, $myServices) ? 'checked' : '' }}
                                   class="w-4 h-4 rounded text-medical-600 focus:ring-medical-500">
                            <span class="text-slate-800 font-medium truncate">{{ $srv->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-6 py-3 bg-medical-600 hover:bg-medical-700 text-white font-bold text-xs rounded-xl shadow-md transition">
                    {{ __('app.save') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
