@extends('component.main')
@section('content')

<!-- Page Header -->
<div class="container-fluid custom-color py-5">
    <div class="container text-center py-5">
        <h1 class="display-3 text-white mb-3 animated slideInDown">About Us</h1>
        <nav aria-label="breadcrumb" class="animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">About Us</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Features -->
<section class="py-5">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="bg-light p-4 rounded shadow-sm h-100">
                    <i class="fa fa-mail-bulk fa-3x text-danger mb-3"></i>
                    <h5 class="fw-bold">Digital Marketing</h5>
                    <p>Boost your brand visibility and drive traffic with our tailored digital marketing campaigns.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="bg-light p-4 rounded shadow-sm h-100">
                    <i class="fa fa-search fa-3x text-danger mb-3"></i>
                    <h5 class="fw-bold">SEO & Backlinks</h5>
                    <p>Rank higher on Google with strategic keyword targeting and authority-building backlinks.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="bg-light p-4 rounded shadow-sm h-100">
                    <i class="fa fa-laptop-code fa-3x text-danger mb-3"></i>
                    <h5 class="fw-bold">Design & Development</h5>
                    <p>We craft responsive and engaging websites that convert visitors into loyal customers.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
 <div class="container-fluid py-5">
            @forelse ($abouts as $about)
                <div class="container py-5 px-lg-5">
                <p class="section-title ">{{ $about->title }}<span></span></p>
                <div class="row g-5 align-items-center">

                    <!-- Image Column: Order-1 on mobile, Order-2 on large screens -->
                    <div class="col-lg-6 order-1 order-lg-2">
                        <img class="img-fluid wow zoomIn" data-wow-delay="0.5s"
                            src="{{ asset('storage/' . ($about->image ?? 'front-asset/img/about.png')) }}" alt="{{ $about->image_alt ?? 'Abouts Image' }}">
                    </div>

                    <!-- Content Column: Order-2 on mobile, Order-1 on large screens -->
                    <div class="col-lg-6 order-2 order-lg-1 wow fadeInUp" data-wow-delay="0.1s">

                        <h1 class="mb-5">{{ $about->subtitle }}</h1>
                        <p class="mb-4">{!! $about->description !!}</p>

                      

                        <a href="{{ url('about') }}" class="btn btn-custom py-sm-3 px-sm-5 rounded-pill mt-3">Read More</a>
                    </div>

                </div>
            </div>
            @empty
                
            @endforelse
        </div>
<!-- Facts -->
<section class="custom-color py-5 text-white">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-3">
                <i class="fa fa-certificate fa-2x mb-2"></i>
                <h3>10+</h3><p>Years Experience</p>
            </div>
            <div class="col-md-3">
                <i class="fa fa-users-cog fa-2x mb-2"></i>
                <h3>25</h3><p>Team Members</p>
            </div>
            <div class="col-md-3">
                <i class="fa fa-users fa-2x mb-2"></i>
                <h3>500+</h3><p>Satisfied Clients</p>
            </div>
            <div class="col-md-3">
                <i class="fa fa-check fa-2x mb-2"></i>
                <h3>850+</h3><p>Projects Completed</p>
            </div>
        </div>
    </div>
</section>


    <!-- Team Start -->
    <div class="container-flued py-5">
        <div class="container py-5 px-lg-5">
            <div class="wow fadeInUp" data-wow-delay="0.1s">
                <p class="section-title text-dark justify-content-center"><span></span>Our Team<span></span></p>
                <h1 class="text-center mb-5">Our Team Members</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item bg-custom rounded">
                        <div class="text-center border-bottom p-4">
                            <img class="img-fluid rounded-circle mb-4" src="{{asset('front-asset/img/team-1.jpg')}}" alt="">
                            <h5>John Doe</h5>
                            <span>CEO & Founder</span>
                        </div>
                        <div class="d-flex justify-content-center p-4">
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item bg-custom rounded">
                        <div class="text-center border-bottom p-4">
                            <img class="img-fluid rounded-circle mb-4" src="{{asset('front-asset/img/team-2.jpg')}}" alt="">
                            <h5>Jessica Brown</h5>
                            <span>Web Designer</span>
                        </div>
                        <div class="d-flex justify-content-center p-4">
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="team-item bg-custom rounded">
                        <div class="text-center border-bottom p-4">
                            <img class="img-fluid rounded-circle mb-4" src="{{asset('front-asset/img/team-3.jpg')}}" alt="">
                            <h5>Tony Johnson</h5>
                            <span>SEO Expert</span>
                        </div>
                        <div class="d-flex justify-content-center p-4">
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->

@endsection
