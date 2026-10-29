@extends('component.main', ['seos'=>$seos ?? null])
@section('page_class','rvg-premium')
@section('content')
@include('front.partials.page-hero',['eyebrow'=>'Ideas & insights','title'=>'A little perspective. A lot of possibility.','intro'=>'Thoughts on design, technology, marketing and building a stronger business.'])
<section class="rvg-section"><div class="rvg-wrap"><div class="rvg-three-grid">@forelse($blogs as $blog)<article class="rvg-card">@if($blog->image)<a href="{{ route('blogdetail',$blog->slug) }}"><img src="{{ asset('storage/'.$blog->image) }}" alt="{{ $blog->image_alt ?? $blog->title }}" style="width:100%;aspect-ratio:1.5;object-fit:cover" loading="lazy"></a>@endif<div class="rvg-eyebrow">{{ $blog->category?->name ?? 'Insights' }}</div><h3><a href="{{ route('blogdetail',$blog->slug) }}">{{ $blog->title }}</a></h3><p>{{ \Illuminate\Support\Str::limit(strip_tags($blog->content),140) }}</p><a class="rvg-link" href="{{ route('blogdetail',$blog->slug) }}">Read the story ↗</a></article>@empty<div class="rvg-empty">Fresh perspectives are on their way. Check back soon.</div>@endforelse</div><div class="rvg-pagination">{{ $blogs->links() }}</div></div></section>
@include('front.partials.cta')
@endsection
