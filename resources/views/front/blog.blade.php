@extends('component.main')
@section('content')

 <!-- Page Header Start -->
 <div class="container-fluid custom-color py-5">
    <div class="container text-center py-5">
        <h1 class="display-2 text-white mb-4 animated slideInDown">Our Blog</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>

                <li class="breadcrumb-item" aria-current="page">Blog</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->




   <!-- Blog Start -->
   <div class="container-fluid blog py-5 mb-5">
    <div class="container">
        <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay=".3s" style="max-width: 600px;">
            <h5 class="text-dark">Our Blog</h5>
            <h1>Latest Blog & News</h1>
        </div>
     <div class="row g-5 justify-content-center">
    @foreach($blogs as $blog)
    <div class="col-lg-6 col-xl-4 wow fadeIn" data-wow-delay=".3s">
        <div class="blog-item position-relative bg-light rounded">
            <img src="{{ asset('storage/' . $blog->thumbnail_img) }}" class="img-fluid w-100 rounded-top" alt="{{ $blog->thumbnail_img_alt }}">
            <span class="position-absolute px-4 py-2 custom-color text-white rounded" style="top: -28px; right: 20px;">
                {{ $blog->category->name ?? 'Uncategorized' }}
            </span>
            <div class="blog-btn d-flex justify-content-between px-3 mt-n5">
                <a href="{{ route('blogdetail', $blog->slug) }}" class="btn btn-dark rounded-pill text-white px-3">Read More</a>
               
            </div>
            <div class="text-center p-3">
                <img src="{{ asset('front-asset/img/team-1.jpg') }}" class="rounded-circle mb-2" width="50" alt="Author">
                <h5>{{ $blog->author ?? 'Admin' }}</h5>
                <small class="text-muted">{{ $blog->created_at->format('d M Y') }}</small>
                <p class="mt-3">{{ Str::limit(strip_tags($blog->sort_content), 120) }}</p>
            </div>
            <div class="blog-coment d-flex justify-content-between px-4 py-2 border custom-color text-white rounded-bottom">
                <small><i class="fas fa-share me-1 text-secondary"></i> Share</small>
                <small><i class="fa fa-comments me-1 text-secondary"></i> 5 Comments</small>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Pagination -->
<div class="text-center mt-4">
    {{ $blogs->links('pagination::bootstrap-5') }}
</div>

    </div>
</div>
<!-- Blog End -->


@endsection
