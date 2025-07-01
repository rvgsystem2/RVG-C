@extends('component.main')
@section('content')

 <!-- Page Header Start -->
 <div class="container-fluid custom-color py-5">
    <div class="container text-center py-5">
        <h1 class="display-2 text-white mb-4 animated slideInDown">Blog-detail</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="#">Home</a></li>

                <li class="breadcrumb-item" aria-current="page">Blog-detail</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->


<section class=" py-5 bg-white">
    <div class="container mt-5">
        <div class="row gy-5">
            <!-- Left: Main Blog Content (70%) -->
            <div class="col-lg-8">
                <!-- Blog Image with Overlay Badge -->
                <div class="position-relative mb-4">
                    <img src="{{ asset('asset/img/image1.jpg') }}" class="img-fluid rounded shadow" alt="Blog Cover Image">
                    <span class="position-absolute top-0 end-0 custom-color text-white px-4 py-2 rounded-bottom-start">
                        Web Design
                    </span>
                </div>

                <!-- Blog Title and Meta -->
                <div class="mb-4">
                    <h1 class="fw-bold display-6">Mastering Modern Web Design Trends in 2023</h1>
                    <p class="text-muted">By <strong class="text-dark">Daniel Martin</strong> | <i class="far fa-calendar-alt me-1"></i> 24 March 2023</p>
                </div>

                <!-- Blog Content -->
                <p class="lead mb-4">
                    The world of web design is evolving rapidly. Staying ahead means embracing new technologies, design systems, and user experiences.
                </p>
                <p class="mb-4">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque efficitur sem sed dui cursus, non luctus dolor pharetra.
                </p>
                <blockquote class="blockquote border-start border-4 border-dark ps-3 py-2 mb-4">
                    <p class="mb-0 fst-italic">"Design is not just what it looks like and feels like. Design is how it works." – Steve Jobs</p>
                </blockquote>
                <p class="mb-4">
                    Fusce in risus convallis, fringilla nisl sed, placerat leo. Donec lacinia nisl nec finibus porttitor.
                </p>

                <!-- Tags and Share -->
                <div class="d-flex justify-content-between align-items-center flex-wrap bg-white p-4 rounded shadow-sm mt-5">
                    <div>
                        <span class="badge custom-color p-3 me-2">#UX</span>
                        <span class="badge custom-color p-3 me-2">#Design</span>
                        <span class="badge custom-color p-3 me-2">#2023Trends</span>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-sm btn-outline-primary rounded-circle btn-send"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-info rounded-circle btn-send" ><i class="fab fa-twitter"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-danger rounded-circle btn-send"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>

                <!-- Author Info -->
                <div class="d-flex align-items-center mt-5 p-4 bg-white rounded shadow-sm">
                    <img src="{{ asset('front-asset/img/team-1.jpg') }}" class="rounded-circle me-3 border border-3 border-white shadow" width="70" alt="Author">
                    <div>
                        <h6 class="mb-1 fw-semibold">Daniel Martin</h6>
                        <small class="text-muted">Lead Designer at Victory Groups</small>
                    </div>
                </div>

                <!-- Comments & Shares -->
                <div class="d-flex justify-content-between align-items-center mt-4 custom-color text-white rounded p-3">
                    <small><i class="fas fa-share me-2 text-warning"></i>5324 Shares</small>
                    <small><i class="fa fa-comments me-2 text-warning"></i>5 Comments</small>
                </div>
            </div>

            <!-- Right: Sidebar (30%) -->
            <div class="col-lg-4">
                <!-- Latest Updates -->
                <div class="mb-5 p-4 bg-white rounded shadow-sm">
                    <h5 class="fw-bold mb-3">Latest Updates</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-decoration-none text-dark">How AI is Changing UI Design</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-dark">Top 5 UX Tools for Designers</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-dark">Mobile First Design: Why It Matters</a></li>
                    </ul>
                </div>

                <!-- Recent Blog Posts -->
                <div class="mb-5 p-4 bg-white rounded shadow-sm">
                    <h5 class="fw-bold mb-3">Recent Posts</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0"><a href="#" class="text-dark text-decoration-none">Understanding Color Psychology in Branding</a></li>
                        <li class="list-group-item px-0"><a href="#" class="text-dark text-decoration-none">5 Essential Tools for Frontend Devs</a></li>
                        <li class="list-group-item px-0"><a href="#" class="text-dark text-decoration-none">Using Figma Effectively as a Team</a></li>
                    </ul>
                </div>

                <!-- Important Links -->
                <div class="p-4 bg-white rounded shadow-sm">
                    <h5 class="fw-bold mb-3">Important Links</h5>
                    <div class="d-grid gap-2">
                        <p href="#" class="btn btn-imp">Join Our Newsletter</p>
                        <p href="#" class="btn btn-imp">Submit Your Blog</p>
                        <p href="#" class="btn btn-imp">Contact Support</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
