@extends('component.main')
@section('content')


    <div class="container-flued bg-white p-0">
    


        <!-- Navbar & Hero Start -->
        <div class="container-flued position-relative p-0">


            <div class="container-flued pb-5 pt-5 custom-color" id="">
                <div class="container px-lg-5 pt-5">
                  @forelse ($banners as $banner)
                      <div class="row g-5 align-items-end">
                          <div class="col-lg-6 text-center text-lg-start">
                              <h1 class="text-white mb-4 animated slideInDown">{{ $banner->title }}</h1>
                              <p class="text-white pb-3 animated slideInDown">{{ $banner->subtitle }}</p>
                              <a href="{{url('about')}}" class="btn btn-dark py-sm-3 px-sm-5 rounded-pill me-3 animated slideInLeft">Read More</a>
                              <a href="{{ url('contact') }}" class="btn btn-light py-sm-3 px-sm-5 rounded-pill animated slideInRight text-danger">Contact Us</a>
                          </div>
                          <div class="col-lg-6 text-center text-lg-start pt-5">
                              <img class="img-fluid animated zoomIn" src="{{ asset('storage/' . ($banner->image ?? 'front-asset/img/hero.png')) }}" alt="{{ $banner->img_alt_text ?? 'Banner Image' }}">
                          </div>
                      </div>
                  @empty
                      <p class="text-white">No banners available</p>
                  @endforelse
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->




        <!-- About Start -->
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

        <!-- About End -->


        <!-- Facts Start -->
        <div class="container-fluid custom-color py-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container py-5 px-lg-5">
                <div class="row g-4">
                    <div class="col-6 col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.1s">
                        <i class="fa fa-certificate fa-3x mb-3"></i>
                        <h1 class="text-white mb-2" data-toggle="counter-up">1234</h1>
                        <p class="text-white mb-0">Years Experience</p>
                    </div>
                    <div class="col-6 col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.3s">
                        <i class="fa fa-users-cog fa-3x  mb-3"></i>
                        <h1 class="text-white mb-2" data-toggle="counter-up">1234</h1>
                        <p class="text-white mb-0">Team Members</p>
                    </div>
                    <div class="col-6 col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.5s">
                        <i class="fa fa-users fa-3x  mb-3"></i>
                        <h1 class="text-white mb-2" data-toggle="counter-up">1234</h1>
                        <p class="text-white mb-0">Satisfied Clients</p>
                    </div>
                    <div class="col-6 col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.7s">
                        <i class="fa fa-check fa-3x  mb-3"></i>
                        <h1 class="text-white mb-2" data-toggle="counter-up">1234</h1>
                        <p class="text-white mb-0">Complete Projects</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Facts End -->


        <!-- Feature Start -->
        <div class="container-xxl py-5">
            <div class="container py-5 px-lg-5">
                <div class="row g-4">
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="feature-item bg-custom rounded text-center p-4">
                            <i class="fa fa-3x fa-mail-bulk text-danger mb-4"></i>
                            <h5 class="mb-3">Digital Marketing</h5>
                            <p class="m-0">Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem sed diam stet
                                diam sed stet lorem.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="feature-item bg-custom rounded text-center p-4">
                            <i class="fa fa-3x fa-search text-danger mb-4"></i>
                            <h5 class="mb-3">SEO & Backlinks</h5>
                            <p class="m-0">Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem sed diam stet
                                diam sed stet lorem.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="feature-item bg-custom rounded text-center p-4">
                            <i class="fa fa-3x fa-laptop-code text-danger mb-4"></i>
                            <h5 class="mb-3">Design & Development</h5>
                            <p class="m-0">Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem sed diam stet
                                diam sed stet lorem.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Feature End -->


        <!-- Service Start -->
        <div class="container-fluid py-5">
            <div class="container py-5 px-lg-5">
                <div class="wow fadeInUp text-center mb-5" data-wow-delay="0.1s">
                    <p class="section-title justify-content-center"><span></span>Our Services<span></span></p>
                    <h1 class="text-center">What Solutions We Provide</h1>
                </div>

                <div class="row g-4">
                    @forelse ($serviceCategories as $category)
                        @foreach ($category->serviceDetails as $detail)
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="service-item d-flex flex-column text-center rounded p-4 h-100 shadow">
                                    <div class="service-icon mb-3">
                                        <i class="{{ $category->icon }}"></i>
                                    </div>

                                    <h5 class="mb-3">{{ $category->name }}</h5>
                                    <p class="mb-4">{{ $detail->sort_description }}</p>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('servicedetail', $category->slug) }}"
                                            class="btn btn-danger w-50">Read More</a>
                                        <a href="#" class="btn btn-danger w-50">Contact Us</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @empty
                        <div class="col-12 text-center">
                            <p class="text-danger">No services available at the moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>


        <!-- Service End -->

        <!-- Projects Start -->
        <div class="container-flued py-5">
            <div class="container py-5 px-lg-5">
                <div class="wow fadeInUp" data-wow-delay="0.1s">
                    <p class="section-title justify-content-center"><span></span>Our Projects<span></span></p>
                    <h1 class="text-center mb-5">Recently Completed Projects</h1>
                </div>

                <!-- Dynamic Filter Buttons -->
                <div class="row mt-n2 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="col-12 text-center">
                        <ul class="list-inline mb-5" id="portfolio-flters">
                            <li class="mx-2 active" data-filter="*">All</li>
                            @foreach ($categories as $category)
                                <li class="mx-2" data-filter=".{{ Str::slug($category) }}">{{ $category }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Dynamic Projects -->
                <div class="row g-4 portfolio-container">
                    @foreach ($projects as $project)
                        @php
                            $images = json_decode($project->project_images, true) ?? [];
                            $firstImage = $images[0] ?? $project->thumb_image;
                        @endphp
                        <div class="col-lg-4 col-md-6 portfolio-item {{ Str::slug($project->project_category_name) }} wow fadeInUp"
                            data-wow-delay="0.1s">
                            <div class="rounded overflow-hidden">
                                <div class="position-relative overflow-hidden">
                                    <img class="img-fluid w-100" src="{{ asset('storage/' . $firstImage) }}"
                                        alt="{{ $project->title }}">
                                    <div class="portfolio-overlay">
                                        @if (count($images))
                                            <!-- First visible button to open lightbox -->
                                            <a class="btn btn-square btn-outline-light mx-1"
                                                href="{{ asset('storage/' . $images[0]) }}"
                                                data-lightbox="portfolio-{{ $project->id }}">
                                                <i class="fa fa-eye"></i>
                                            </a>

                                            <!-- Hidden links for rest of the images (for lightbox group) -->
                                            @foreach ($images as $index => $img)
                                                @if ($index > 0)
                                                    <a href="{{ asset('storage/' . $img) }}"
                                                        data-lightbox="portfolio-{{ $project->id }}" class="d-none"></a>
                                                @endif
                                            @endforeach
                                        @endif

                                        @if ($project->project_url)
                                            <a class="btn btn-square btn-outline-light mx-1"
                                                href="{{ $project->project_url }}"><i class="fa fa-link"></i></a>
                                        @endif
                                    </div>

                                </div>
                                <div class="bg-custom p-4">
                                    <p class="text-danger fw-medium mb-2">{{ $project->project_category_name }}</p>
                                    <h5 class="lh-base mb-0">{{ $project->title }}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Projects End -->

        <!-- Testimonial Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">

                    <h1 class="display-6 mb-4">What Our Clients Say!</h1>
                </div>
                <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
                    <div class="testimonial-item bg-custom rounded p-4">
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded-circle"
                                src="{{ asset('front-asset/img/testimonial-1.jpg') }}"
                                style="width: 65px; height: 65px;">
                            <div class="ps-4">
                                <h5 class="mb-1">Client Name</h5>
                                <span>Profession</span>
                            </div>
                        </div>
                        <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et
                            eos. Clita erat ipsum et lorem et sit.</p>
                    </div>
                    <div class="testimonial-item bg-custom rounded p-4">
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded-circle"
                                src="{{ asset('front-asset/img/testimonial-2.jpg') }}"
                                style="width: 65px; height: 65px;">
                            <div class="ps-4">
                                <h5 class="mb-1">Client Name</h5>
                                <span>Profession</span>
                            </div>
                        </div>
                        <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et
                            eos. Clita erat ipsum et lorem et sit.</p>
                    </div>
                    <div class="testimonial-item bg-custom rounded p-4">
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded-circle"
                                src="{{ asset('front-asset/img/testimonial-3.jpg') }}"
                                style="width: 65px; height: 65px;">
                            <div class="ps-4">
                                <h5 class="mb-1">Client Name</h5>
                                <span>Profession</span>
                            </div>
                        </div>
                        <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et
                            eos. Clita erat ipsum et lorem et sit.</p>
                    </div>
                    <div class="testimonial-item bg-custom rounded p-4">
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded-circle"
                                src="{{ asset('front-asset/img/testimonial-4.jpg') }}"
                                style="width: 65px; height: 65px;">
                            <div class="ps-4">
                                <h5 class="mb-1">Client Name</h5>
                                <span>Profession</span>
                            </div>
                        </div>
                        <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et
                            eos. Clita erat ipsum et lorem et sit.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Testimonial End -->



        <!-- Contact Start -->
     @include('front.contentcomponent')

        {{-- start contact us --}}
        {{-- end contact us --}}







    </div>


    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var portfolioIsotope = document.querySelector('.portfolio-container');
            if (portfolioIsotope) {
                var iso = new Isotope(portfolioIsotope, {
                    itemSelector: '.portfolio-item',
                    layoutMode: 'fitRows'
                });

                document.querySelectorAll('#portfolio-flters li').forEach(function(filterEl) {
                    filterEl.addEventListener('click', function() {
                        document.querySelectorAll('#portfolio-flters li').forEach(el => el.classList
                            .remove('active'));
                        this.classList.add('active');
                        iso.arrange({
                            filter: this.getAttribute('data-filter')
                        });
                    });
                });
            }
        });
    </script>

@endsection
