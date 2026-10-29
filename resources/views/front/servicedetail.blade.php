@extends('component.main', ['seos'=>$seos ?? null])
@section('page_class','rvg-premium')
@section('content')
@include('front.partials.page-hero',['eyebrow'=>'Our expertise','title'=>$service->name,'intro'=>$firstService?->sort_description ?? 'Thoughtful solutions, built around your business.'])
<section class="rvg-section"><div class="rvg-wrap grid grid-cols-1 lg:grid-cols-3 gap-10"><div class="lg:col-span-2">
@forelse($service->serviceDetails as $detail)@if($detail->image)<img src="{{ asset('storage/'.$detail->image) }}" alt="{{ $detail->image_alt ?? $service->name }}" style="border-radius:12px;width:100%;margin-bottom:30px" loading="lazy">@endif<div class="rvg-rich">{!! $detail->description !!}</div>@empty<p>Speak with our team to explore how this service can help your business.</p>@endforelse
</div><aside><div class="rvg-sidebar"><div class="rvg-eyebrow">Made for your business</div><h3>Let’s find the right approach.</h3><p>Tell us what you have in mind. We’ll help you take the next step.</p><a class="rvg-btn" href="{{ route('contact') }}">Talk to our team ↗</a></div></aside></div></section>
@include('front.partials.cta')
@endsection
