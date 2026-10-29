@extends('component.main', ['seos'=>$seos ?? null])
@section('page_class','rvg-premium')
@section('content')
@include('front.partials.page-hero',['eyebrow'=>'Our packages','title'=>$package->name,'intro'=>$package->short_description])
<section class="rvg-section"><div class="rvg-wrap grid grid-cols-1 lg:grid-cols-3 gap-10"><div class="lg:col-span-2">
@if($package->thumbnail ?? $package->image)<div class="rvg-card" style="margin-bottom:30px"><img src="{{ asset('storage/'.($package->thumbnail ?? $package->image)) }}" alt="{{ $package->image_alt ?? $package->name }}" style="width:100%;max-height:500px;object-fit:contain"></div>@endif
<div class="rvg-rich">{!! $package->description !!}</div>
@if($package->media->isNotEmpty())<h2 style="font-size:30px;margin-top:40px">A closer look.</h2><div class="rvg-gallery">
@foreach($package->media as $medium)
@php $items = is_array($medium->media_type) ? $medium->media_type : (json_decode($medium->media_type ?? '[]',true) ?: []); if(isset($items['path'])) { $items = [$items]; } @endphp
@foreach($items as $item)
@php $path = is_string($item) ? $item : ($item['path'] ?? $item['file'] ?? $item['url'] ?? null); $extension = strtolower(pathinfo($path ?? '',PATHINFO_EXTENSION)); @endphp
@if($path && !preg_match('/^(https?:)?\/\//i',$path))
@if(in_array($extension,['mp4','webm','ogg']))<video controls preload="metadata" playsinline aria-label="{{ $package->name }} preview"><source src="{{ asset('storage/'.$path) }}"></video>@elseif(in_array($extension,['jpg','jpeg','png','webp','gif','avif']))<a href="{{ asset('storage/'.$path) }}" target="_blank" rel="noopener noreferrer"><img src="{{ asset('storage/'.$path) }}" alt="{{ $package->name }} preview" loading="lazy"></a>@endif
@endif
@endforeach @endforeach</div>@endif
@if($package->faqs->isNotEmpty())<h2 style="font-size:30px;margin-top:45px">Good questions. Clear answers.</h2>@foreach($package->faqs as $faq)<details class="rvg-faq"><summary>{{ $faq->question }}</summary><div class="rvg-rich">{!! $faq->answer !!}</div></details>@endforeach @endif
</div><aside><div class="rvg-sidebar"><div class="rvg-eyebrow">{{ $package->label ?: 'Your next step' }}</div><h3>{{ $package->name }}</h3><div class="rvg-price">₹{{ number_format(($package->sale_price !== null && (float)$package->sale_price > 0 && (float)$package->sale_price < (float)$package->price ? (float)$package->sale_price : (float)$package->price),2) }}</div>@if($package->duration_days)<p>Valid for {{ $package->duration_days }} days</p>@endif<a class="rvg-btn" style="width:100%;margin:15px 0 28px" href="{{ route('packages.buy',$package->id) }}">Choose this package ↗</a><hr style="border-color:var(--line)"><h3 style="font-size:18px;margin-top:25px">Have a question first?</h3><p style="font-size:12px">Leave your number and we’ll help you find the right fit.</p><form class="rvg-form" data-ajax-form method="POST" action="{{ route('interest.store') }}">@csrf<input type="hidden" name="package_id" value="{{ $package->id }}"><label for="interest-phone">Phone number *</label><input id="interest-phone" name="phone" type="tel" autocomplete="tel" pattern="(\+?91)?[6-9][0-9]{9}" placeholder="10-digit mobile number" required><button type="submit" class="rvg-btn dark">Request a callback ↗</button><div class="rvg-status" role="status" aria-live="polite" hidden></div></form></div></aside></div></section>
@endsection
