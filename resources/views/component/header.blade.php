<header class="rvg-nav"><div class="rvg-wrap rvg-nav-inner">
<a class="rvg-brand" href="{{ route('home') }}" aria-label="Real Victory Groups home"><img src="{{ asset('asset/img/logo-w-removebg-preview.png') }}" alt="Real Victory Groups" width="158" height="57"></a>
<nav class="rvg-links" id="primary-navigation" data-nav aria-label="Main navigation">
@foreach(['home'=>'Home','service'=>'Services','project'=>'Our work','about'=>'About us','packages'=>'Packages','blog'=>'Insights','contact'=>'Contact'] as $name=>$label)
<a href="{{ route($name) }}" @if(request()->routeIs($name) || ($name === 'service' && request()->routeIs('servicedetail')) || ($name === 'packages' && request()->routeIs('packages.*')) || ($name === 'blog' && request()->routeIs('blogdetail'))) aria-current="page" @endif>{{ $label }}</a>
@endforeach
</nav>
<a class="rvg-btn dark" href="{{ route('contact') }}">Let’s talk <span aria-hidden="true">↗</span></a>
<button class="rvg-menu" data-menu aria-label="Toggle navigation" aria-expanded="false" aria-controls="primary-navigation">☰</button>
</div></header>
