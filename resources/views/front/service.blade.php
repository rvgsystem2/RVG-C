@extends('component.main', ['seos'=>$seos ?? null])
@section('page_class','rvg-premium')
@section('content')
@include('front.partials.page-hero',['eyebrow'=>'Our expertise','title'=>'Connected thinking. Exceptional execution.','intro'=>'Strategy, design, development and marketing. The right capabilities, brought together around your business.'])
<section class="rvg-section"><div class="rvg-wrap">@include('front.partials.services')</div></section>
@include('front.partials.cta')
@endsection
