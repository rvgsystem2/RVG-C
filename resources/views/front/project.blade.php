@extends('component.main', ['seos'=>$seos ?? null])
@section('page_class','rvg-premium')
@section('content')
@include('front.partials.page-hero',['eyebrow'=>'Our work','title'=>'Different challenges. The same attention to detail.','intro'=>'Explore the ideas and experiences we bring to life for businesses.'])
<section class="rvg-section"><div class="rvg-wrap">
@if($projects->isNotEmpty())<div class="rvg-filters" role="group" aria-label="Filter projects"><button class="rvg-filter" data-filter="all" aria-pressed="true">All work</button>@foreach($categories as $category)<button class="rvg-filter" data-filter="{{ $category }}" aria-pressed="false">{{ $category }}</button>@endforeach</div>@include('front.partials.projects')
@else <div style="margin-bottom:25px"><p>Explore our creative direction below. These are design concepts, not client case studies.</p></div>@include('front.partials.concept-work') @endif
</div></section>@include('front.partials.cta')
@endsection
