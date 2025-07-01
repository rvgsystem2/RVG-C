@extends('component.main')
@section('content')

 <!-- Page Header Start -->
 <div class="container-fluid custom-color py-5">
    <div class="container text-center py-5">
        <h1 class="display-2 text-white mb-4 animated slideInDown">Our Blog</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="#">Home</a></li>

                <li class="breadcrumb-item" aria-current="page">Blog</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->


<!-- Fact Start -->
<div class="container-fluid bg-dark py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 wow fadeIn" data-wow-delay=".1s">
                <div class="d-flex counter">
                    <h1 class="me-3 text-danger counter-value">99</h1>
                    <h5 class="text-white mt-1">Success in getting happy customer</h5>
                </div>
            </div>
            <div class="col-lg-3 wow fadeIn" data-wow-delay=".3s">
                <div class="d-flex counter">
                    <h1 class="me-3 text-danger counter-value">25</h1>
                    <h5 class="text-white mt-1">Thousands of successful business</h5>
                </div>
            </div>
            <div class="col-lg-3 wow fadeIn" data-wow-delay=".5s">
                <div class="d-flex counter">
                    <h1 class="me-3 text-danger counter-value">120</h1>
                    <h5 class="text-white mt-1">Total clients who love HighTech</h5>
                </div>
            </div>
            <div class="col-lg-3 wow fadeIn" data-wow-delay=".7s">
                <div class="d-flex counter">
                    <h1 class="me-3 text-danger counter-value">5</h1>
                    <h5 class="text-white mt-1">Stars reviews given by satisfied clients</h5>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fact End -->

   <!-- Blog Start -->
   <div class="container-fluid blog py-5 mb-5">
    <div class="container">
        <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay=".3s" style="max-width: 600px;">
            <h5 class="text-dark">Our Blog</h5>
            <h1>Latest Blog & News</h1>
        </div>
        <div class="row g-5 justify-content-center">
            <div class="col-lg-6 col-xl-4 wow fadeIn" data-wow-delay=".3s">
                <div class="blog-item position-relative bg-light rounded">
                    <img src="{{asset('asset/img/image1.jpg')}}" class="img-fluid w-100 rounded-top" alt="">
                    <span class="position-absolute px-4 py-3 custom-color text-white rounded" style="top: -28px; right: 20px;">Web Design</span>
                    <div class="blog-btn d-flex justify-content-between position-relative px-3" style="margin-top: -75px;">
                        <div class="blog-icon btn btn-dark px-3 rounded-pill my-auto">
                            <a href="" class="btn text-white">Read More</a>
                        </div>
                        <div class="blog-btn-icon btn btn-dark px-4 py-2 rounded-pill d-flex align-items-center gap-3">
                            <!-- Arrow Icon -->
                            {{-- <div class="blog-icon-1">
                                <i class="fa fa-arrow-right text-white"></i>
                            </div> --}}

                            <!-- Social Icons -->
                            <div class="blog-icon-2 d-flex gap-2">
                                <a href="#" class="text-white"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>

                    </div>
                    <div class="blog-content text-center position-relative px-3" style="margin-top: -25px;">
                        <img src="{{asset('front-asset/img/team-1.jpg')}}" class="img-fluid-team rounded-circle border border-4 border-white mb-3" alt="">
                        <h5 class="">By Daniel Martin</h5>
                        <span class="text-dark">24 March 2023</span>
                        <p class="py-2">Lorem ipsum dolor sit amet elit. Sed efficitur quis purus ut interdum. Aliquam dolor eget urna ultricies tincidunt libero sit amet</p>
                    </div>
                    <div class="blog-coment d-flex justify-content-between px-4 py-2 border custom-color rounded-bottom">
                        <a href="" class="text-white"><small><i class="fas fa-share me-2 text-secondary"></i>5324 Share</small></a>
                        <a href="" class="text-white"><small><i class="fa fa-comments me-2 text-secondary"></i>5 Comments</small></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-4 wow fadeIn" data-wow-delay=".5s">
                <div class="blog-item position-relative bg-light rounded">
                    <img src="{{asset('asset/img/image1.jpg')}}" class="img-fluid w-100 rounded-top" alt="">
                    <span class="position-absolute px-4 py-3 custom-color text-white rounded" style="top: -28px; right: 20px;">Development</span>
                    <div class="blog-btn d-flex justify-content-between position-relative px-3" style="margin-top: -75px;">
                        <div class="blog-icon btn btn-dark px-3 rounded-pill my-auto">
                            <a href="" class="btn text-white ">Read More</a>
                        </div>
                        <div class="blog-btn-icon btn btn-dark px-4 py-2 rounded-pill d-flex align-items-center gap-3">
                            <!-- Arrow Icon -->
                            {{-- <div class="blog-icon-1">
                                <i class="fa fa-arrow-right text-white"></i>
                            </div> --}}

                            <!-- Social Icons -->
                            <div class="blog-icon-2 d-flex gap-2">
                                <a href="#" class="text-white"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>

                    </div>
                    <div class="blog-content text-center position-relative px-3" style="margin-top: -25px;">
                        <img src="{{asset('front-asset/img/team-2.jpg')}}" class="img-fluid-team rounded-circle border border-4 border-white mb-3" alt="">
                        <h5 class="">By Daniel Martin</h5>
                        <span class="text-dark">23 April 2023</span>
                        <p class="py-2">Lorem ipsum dolor sit amet elit. Sed efficitur quis purus ut interdum. Aliquam dolor eget urna ultricies tincidunt libero sit amet</p>
                    </div>
                    <div class="blog-coment d-flex justify-content-between px-4 py-2 border custom-color rounded-bottom">
                        <a href="" class="text-white"><small><i class="fas fa-share me-2 text-secondary"></i>5324 Share</small></a>
                        <a href="" class="text-white"><small><i class="fa fa-comments me-2 text-secondary"></i>5 Comments</small></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-4 wow fadeIn" data-wow-delay=".7s">
                <div class="blog-item position-relative bg-light rounded">
                    <img src="{{asset('asset/img/image1.jpg')}}" class="img-fluid w-100 rounded-top" alt="">
                    <span class="position-absolute px-4 py-3 custom-color text-white rounded" style="top: -28px; right: 20px;">Mobile App</span>
                    <div class="blog-btn d-flex justify-content-between position-relative px-3" style="margin-top: -75px;">
                        <div class="blog-icon btn btn-dark px-3 rounded-pill my-auto">
                            <a href="" class="btn text-white ">Read More</a>
                        </div>
                        <div class="blog-btn-icon btn btn-dark px-4 py-2 rounded-pill d-flex align-items-center gap-3">
                            <!-- Arrow Icon -->
                            {{-- <div class="blog-icon-1">
                                <i class="fa fa-arrow-right text-white"></i>
                            </div> --}}

                            <!-- Social Icons -->
                            <div class="blog-icon-2 d-flex gap-2">
                                <a href="#" class="text-white"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>

                    </div>
                    <div class="blog-content text-center position-relative px-3" style="margin-top: -25px;">
                        <img src="{{asset('front-asset/img/team-3.jpg')}}" class="img-fluid-team rounded-circle border border-4 border-white mb-3" alt="">
                        <h5 class="">By Daniel Martin</h5>
                        <span class="text-dark">30 jan 2023</span>
                        <p class="py-2">Lorem ipsum dolor sit amet elit. Sed efficitur quis purus ut interdum. Aliquam dolor eget urna ultricies tincidunt libero sit amet</p>
                    </div>
                    <div class="blog-coments d-flex justify-content-between px-4 py-2 border custom-color rounded-bottom">
                        <a href="" class="text-white"><small><i class="fas fa-share me-2 text-secondary"></i>5324 Share</small></a>
                        <a href="" class="text-white"><small><i class="fa fa-comments me-2 text-secondary"></i>5 Comments</small></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Blog End -->


@endsection
