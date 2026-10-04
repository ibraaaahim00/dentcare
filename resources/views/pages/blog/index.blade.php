@extends('layouts.app')

@section('title', __('app.blog'))

@section('content')
<div class="bg-gradient-to-b from-medical-50 to-white py-16 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="text-medical-600 font-bold text-xs uppercase tracking-wider block mb-2">{{ app()->getLocale() === 'ar' ? 'المعرفة الصحية' : 'Dental Health Knowledge' }}</span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-navy-900 tracking-tight">{{ __('app.blog') }}</h1>
        <p class="text-slate-500 text-sm sm:text-base mt-3 max-w-xl mx-auto">
            {{ app()->getLocale() === 'ar' ? 'نصائح طبية ومقالات توعوية حول العناية بأسنانك وابتسامتك.' : 'Expert tips, insights, and oral hygiene guides from our clinical team.' }}
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
        
        <!-- Main Blog Posts Grid -->
        <div class="lg:col-span-3">
            @if($posts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($posts as $post)
                        <article class="bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group">
                            <div class="h-48 overflow-hidden relative">
                                <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="p-6 flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="text-xs text-medical-600 font-bold mb-2">{{ $post->published_at?->format('M d, Y') }}</div>
                                    <a href="{{ route('blog.show', $post->slug) }}">
                                        <h3 class="text-xl font-bold text-navy-900 mb-2 group-hover:text-medical-600 transition">{{ $post->title }}</h3>
                                    </a>
                                    <p class="text-slate-500 text-sm line-clamp-3 leading-relaxed mb-4">{{ $post->excerpt }}</p>
                                </div>
                                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                                    <span class="text-slate-400">{{ $post->author?->name }}</span>
                                    <a href="{{ route('blog.show', $post->slug) }}" class="font-bold text-medical-600 hover:text-medical-700">
                                        {{ app()->getLocale() === 'ar' ? 'اقرأ المزيد' : 'Read more' }} &rarr;
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="p-12 text-center bg-white rounded-3xl border border-slate-100">
                    <p class="text-slate-400 text-sm">{{ app()->getLocale() === 'ar' ? 'لا توجد مقالات منشورة حالياً في هذا القسم.' : 'No blog posts published yet.' }}</p>
                </div>
            @endif
        </div>

        <!-- Sidebar (Search & Categories) -->
        <div class="space-y-8">
            <!-- Search Form -->
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
                <h3 class="font-bold text-navy-900 text-sm mb-3">{{ __('app.search') }}</h3>
                <form method="GET" action="{{ route('blog.index') }}" class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-medical-500/20 focus:border-medical-500"
                           placeholder="{{ __('app.search') }}...">
                    <button type="submit" class="px-4 py-2.5 bg-medical-600 text-white rounded-xl text-xs font-bold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </form>
            </div>

            <!-- Categories Widget -->
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
                <h3 class="font-bold text-navy-900 text-sm mb-4">{{ app()->getLocale() === 'ar' ? 'التصنيفات' : 'Categories' }}</h3>
                <ul class="space-y-2 text-xs">
                    <li>
                        <a href="{{ route('blog.index') }}" class="flex justify-between items-center py-1.5 px-2 rounded-lg hover:bg-slate-50 font-medium text-slate-700">
                            <span>{{ app()->getLocale() === 'ar' ? 'جميع المقالات' : 'All Categories' }}</span>
                        </a>
                    </li>
                    @foreach($categories as $category)
                        <li>
                            <a href="{{ route('blog.index', ['category' => $category->slug]) }}" class="flex justify-between items-center py-1.5 px-2 rounded-lg hover:bg-slate-50 font-medium text-slate-700">
                                <span>{{ $category->name }}</span>
                                <span class="text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full text-[10px]">{{ $category->posts_count }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>
</div>
@endsection
