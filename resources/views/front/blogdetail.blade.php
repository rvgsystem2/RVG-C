@extends('component.main', ['seos' => $seos ?? null])
@section('content')

<!-- Page Header Start -->
<div class="container-fluid custom-color py-5">
    <div class="container text-center py-5">
        <h1 class="display-2 text-white mb-4 animated slideInDown">{{ $blog->title }}</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Home</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">{{ $blog->title }}</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<section class="py-5 bg-white">
    <div class="container mt-5">
        <div class="row gy-5">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Blog Image & Category -->
                <div class="position-relative mb-4">
                    <img src="{{ asset('storage/' . $blog->image) }}" class="img-fluid rounded shadow w-100" alt="{{ $blog->image_alt ?? $blog->title }}">
                    <span class="position-absolute top-0 end-0 custom-color text-white px-4 py-2 rounded-bottom-start">
                        {{ $blog->category->name ?? 'Uncategorized' }}
                    </span>
                </div>

                <!-- Blog Title & Meta -->
                <div class="mb-4">
                    <h1 class="fw-bold display-6">{{ $blog->title }}</h1>
                    <p class="text-muted">
                        By <strong class="text-dark">{{ $blog->author ?? 'Admin' }}</strong> |
                        <i class="far fa-calendar-alt me-1"></i> {{ $blog->created_at->format('d M Y') }}
                    </p>
                </div>

                <!-- Blog Content -->
                <div class="mb-5 content-area">
                    {!! $blog->content !!}
                </div>

                <!-- Tags & Share -->
              

                <!-- Author Info -->
                <div class="d-flex align-items-center mt-5 p-4 bg-white rounded shadow-sm">
                    <img src="{{ asset('front-asset/img/team-1.jpg') }}" class="rounded-circle me-3 border border-3 shadow" width="70" alt="Author">
                    <div>
                        <h6 class="mb-1 fw-semibold">{{ $blog->author ?? 'Admin' }}</h6>
                        <small class="text-muted">Author</small>
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar -->
            <div class="col-lg-4">
                <!-- Latest Updates -->
                <div class="mb-5 p-4 bg-light rounded shadow-sm">
                    <h5 class="fw-bold mb-3">Latest Updates</h5>
                    <ul class="list-unstyled">
                        @php
                            $latestBlogs = \App\Models\Blog::latest()->take(3)->get();
                        @endphp
                        @foreach($latestBlogs as $latest)
                            <li class="mb-2">
                                <a href="{{ route('blogdetail', $latest->slug) }}" class="text-decoration-none text-dark">
                                    {{ $latest->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Recent Blog Posts -->
                <div class="mb-5 p-4 bg-light rounded shadow-sm">
                    <h5 class="fw-bold mb-3">Recent Posts</h5>
                    <ul class="list-group list-group-flush">
                        @foreach($latestBlogs as $recent)
                            <li class="list-group-item px-0 border-0">
                                <a href="{{ route('blogdetail', $recent->slug) }}" class="text-dark text-decoration-none">
                                    {{ $recent->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Important Links -->
                <div class="p-4 bg-light rounded shadow-sm">
                    <h5 class="fw-bold mb-3">Important Links</h5>
                    <div class="d-grid gap-2">
                        <a href="wa.me/+918423269465" class="btn btn-primary">Join Our WhatsApp Group</a>
                        <a href="https://www.instagram.com/realvictorygroups" class="btn btn-secondary">Instagram</a>
                        <a href="{{ route('contact') }}" class="btn btn-dark">Contact Support</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
