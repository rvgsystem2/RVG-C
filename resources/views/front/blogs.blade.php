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
            
        </div>
    </div>
</div>
<!-- Blog End -->


@endsection
