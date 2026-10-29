@extends('component.main', ['seos'=>$seos ?? null])
@section('page_class','rvg-premium')
@section('content')
@include('front.partials.page-hero',['eyebrow'=>'Our packages','title'=>'The right start for your next big step.','intro'=>'Explore our current packages and choose the support that fits your business.'])
<section class="rvg-section"><div class="rvg-wrap">@include('front.partials.package-cards')</div></section>
@include('front.partials.cta')
@endsection
