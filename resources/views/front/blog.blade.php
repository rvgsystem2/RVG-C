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
   <div class="container-fluid py-5 mb-5">
    <div class="container">
        <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay=".3s" style="max-width: 600px;">
            <h5 class="text-dark">Our Blog</h5>
            <h1>Latest Blog & News</h1>
        </div>
     <div class="row g-5 gap-5 justify-content-center">
    @foreach($blogs as $blog)
    <div class="col-lg-6 col-xl-4 wow fadeIn blog py-5" data-wow-delay=".3s">
        <div class="blog-item position-relative bg-light rounded ">
            <img src="{{ asset('storage/' . $blog->thumbnail_img) }}" class="img-fluid w-100 rounded-top" alt="{{ $blog->thumbnail_img_alt }}">
            <span class="position-absolute px-4 py-2 custom-color text-white rounded" style="top: -28px; right: 20px;">
                {{ $blog->category->name ?? 'Uncategorized' }}
            </span>

            <div class="d-flex align-items-start p-2 mt-3 mb-2">
                <!-- Author Image -->
                <img src="{{ asset('front-asset/img/team-1.jpg') }}" alt="Author" class="rounded-circle me-3" width="60" height="60" style="object-fit: cover;">

                <!-- Content -->
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-around align-items-center mb-1">
                        <h6 class="mb-0">{{ $blog->author ?? 'Admin' }}</h6>
                        <small class="text-muted">{{ $blog->created_at->format('d M Y') }}</small>
                    </div>
                    <p class="mb-0 text-muted">{{ Str::limit(strip_tags($blog->sort_content), 120) }}</p>
                </div>
            </div>

            <div class="blog-btn d-flex justify-content-center px-3 mt-0 w-100">
                <a href="{{ route('blogdetail', $blog->slug) }}" class="btn btn-dark rounded-pill text-white w-100 px-3 py-2">
                    Read More
                </a>
            </div>

            {{-- <div class="blog-coment d-flex justify-content-between px-4 py-2 border custom-color text-white rounded-bottom">
                <small><i class="fas fa-share me-1 text-secondary"></i> Share</small>
                <small><i class="fa fa-comments me-1 text-secondary"></i> 5 Comments</small>
            </div> --}}
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
