@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="bg-gradient-to-b from-medical-50 to-white py-12 border-b border-slate-100">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2 text-xs text-slate-500 mb-4">
            <a href="{{ route('home') }}" class="hover:text-medical-600">{{ __('app.home') }}</a>
            <span>/</span>
            <a href="{{ route('blog.index') }}" class="hover:text-medical-600">{{ __('app.blog') }}</a>
            <span>/</span>
            <span class="text-navy-900 font-semibold">{{ $post->title }}</span>
        </div>
        <div class="space-y-4">
            <div class="flex items-center gap-3 text-xs text-slate-500">
                <span class="px-3 py-1 rounded-full bg-medical-100 text-medical-800 font-bold">{{ $post->published_at?->format('M d, Y') }}</span>
                <span>{{ app()->getLocale() === 'ar' ? 'بواسطة' : 'By' }} {{ $post->author?->name }}</span>
            </div>
            <h1 class="text-3xl sm:text-5xl font-extrabold text-navy-900 tracking-tight leading-tight">{{ $post->title }}</h1>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="space-y-8">
        <div class="rounded-3xl overflow-hidden shadow-lg border border-slate-100">
            <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-[400px] object-cover">
        </div>

        <div class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-100 shadow-sm">
            <div class="prose max-w-none text-slate-700 leading-relaxed text-base space-y-4 whitespace-pre-line">
                {{ $post->content }}
            </div>

            <!-- Categories tags -->
            @if($post->categories->count() > 0)
                <div class="pt-8 border-t border-slate-100 mt-8 flex flex-wrap gap-2">
                    @foreach($post->categories as $category)
                        <a href="{{ route('blog.index', ['category' => $category->slug]) }}" class="px-3 py-1 rounded-full bg-slate-100 hover:bg-medical-50 hover:text-medical-600 text-xs font-semibold text-slate-600 transition">
                            #{{ $category->name }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
