{{-- header --}}

<nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0 ">
    <a href="/" class="navbar-brand p-0">
        {{-- <h1 class="m-0">DGital</h1> --}}
        <img src="{{asset('asset/img/logo-icon.jpg')}}" alt="" class="logo">
        {{-- <img src="{{asset('asset/img/logo-w.png')}}" alt="" class="logo" >
        <!-- <img src="img/logo.png" alt="Logo"> --> --}}
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="fa fa-bars"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav mx-auto py-0">
            <a href="/" class="nav-item nav-link {{ request()->is('/') ? 'active text-secondary' : '' }}">
                Home
            </a>
            <a href="{{ route('about') }}" class="nav-item nav-link {{ request()->routeIs('about') ? 'active text-secondary' : '' }}">
                About
            </a>
            <a href="{{route('blog')}}" class="nav-item nav-link {{ request()->routeIs('blogs') ? 'active text-secondary' : '' }}">
                Blog
            </a>
            <a href="{{ route('service') }}" class="nav-item nav-link {{ request()->routeIs('service') ? 'active text-secondary' : '' }}">
                Service
            </a>
            <a href="{{ route('project') }}" class="nav-item nav-link {{ request()->routeIs('project') ? 'active text-secondary' : '' }}">
                Project
            </a>
            <a href="{{ route('contact') }}" class="nav-item nav-link {{ request()->routeIs('contact') ? 'active text-secondary' : '' }}">
                Contact
            </a>
        </div>

        <button href="#" class="btn rounded-pill py-2 px-4 ms-3 d-none d-lg-block ">Get Started</button>
    </div>
</nav>
