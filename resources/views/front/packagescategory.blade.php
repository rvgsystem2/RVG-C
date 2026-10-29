@extends('component.main', ['seos'=>$seos ?? null])
@section('page_class','rvg-premium')
@section('content')
@include('front.partials.page-hero',['eyebrow'=>'Packages','title'=>$activeCat->name,'intro'=>'Explore packages tailored to your needs.'])
<section class="rvg-section"><div class="rvg-wrap"><nav class="rvg-filters" aria-label="Package categories"><a class="rvg-filter" href="{{ route('packages') }}">All packages</a>@foreach($categories as $category)<a class="rvg-filter" href="{{ route('packages.byCategory',$category) }}" @if($category->id===$activeCat->id) aria-current="page" @endif>{{ $category->name }}</a>@endforeach</nav>@include('front.partials.package-cards')<div class="rvg-pagination">{{ $packages->links() }}</div></div></section>
@endsection
