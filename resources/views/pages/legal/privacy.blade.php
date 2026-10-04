@extends('layouts.app')

@section('title', app()->getLocale() === 'ar' ? 'سياسة الخصوصية' : 'Privacy Policy')

@section('content')
<div class="py-16 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-100 shadow-sm space-y-6">
        <h1 class="text-3xl font-extrabold text-navy-900">{{ app()->getLocale() === 'ar' ? 'سياسة الخصوصية وسرية المعلومات' : 'Privacy Policy' }}</h1>
        <div class="text-slate-600 text-sm leading-relaxed space-y-4">
            <p>{{ app()->getLocale() === 'ar' ? 'نحن في عيادة دنت كير نلتزم بأعلى درجات الحفاظ على سرية وخصوصية بيانات مرضانا الطبية والشخصية، ونطبق أعلى المعايير الرقمية لحمايتها.' : 'At DentCare Clinic, safeguarding patient medical records and personal data is our utmost priority.' }}</p>
            <h3 class="text-base font-bold text-navy-900">{{ app()->getLocale() === 'ar' ? 'البيانات التي نقوم بجمعها' : 'Information We Collect' }}</h3>
            <p>{{ app()->getLocale() === 'ar' ? 'نقوم بجمع البيانات الضرورية لتقديم الاستشارات والعلاج الطبي، وتشمل الاسم، رقم الهاتف، البريد الإلكتروني، السجل الطبي والتاريخ الصحي.' : 'We collect contact details and confidential medical histories strictly needed for diagnosing and administering dental care.' }}</p>
        </div>
    </div>
</div>
@endsection
