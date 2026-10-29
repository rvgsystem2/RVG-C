@extends('component.main', ['seos'=>$seos ?? null])
@section('page_class','rvg-premium')
@section('content')
@include('front.partials.page-hero',['eyebrow'=>$blog->category?->name ?? 'Insights','title'=>$blog->title,'intro'=>'By '.($blog->author ?? 'Real Victory Groups').' · '.$blog->created_at->format('d M Y')])
<section class="rvg-section"><article class="rvg-wrap" style="max-width:850px">@if($blog->image)<img src="{{ asset('storage/'.$blog->image) }}" alt="{{ $blog->image_alt ?? $blog->title }}" style="border-radius:14px;width:100%;margin-bottom:35px">@endif<div class="rvg-rich">{!! $blog->content !!}</div><a class="rvg-link" href="{{ route('blog') }}">← Back to insights</a></article></section>
@include('front.partials.cta')
@endsection
