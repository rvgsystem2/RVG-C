@extends('component.main')
@section('content')


    <div class="container-flued bg-white p-0">


        <!-- Navbar & Hero Start -->
        <div class="container-flued position-relative p-0">


            <div class="container-fluid pb-5 pt-5 custom-color" id="">
                <div class="container px-lg-5 pt-5">
                    @forelse ($banners as $banner)
                        <div class="row g-5 align-items-end">
                            <div class="col-lg-6 text-center text-lg-start">
                                <h1 class="text-white mb-4 animated slideInDown">{{ $banner->title }}</h1>
                                <p class="text-white pb-3 animated slideInDown">{{ $banner->subtitle }}</p>
                                <a href="{{ url('about') }}"
                                    class="btn btn-dark py-sm-3 px-sm-5 rounded-pill me-3 animated slideInLeft">Read
                                    More</a>
                                <a href="{{ url('contact') }}"
                                    class="btn btn-light py-sm-3 px-sm-5 rounded-pill animated slideInRight text-danger">Contact
                                    Us</a>
                            </div>
                            <div class="col-lg-6 text-center text-lg-start pt-5">
                                <img class="img-fluid animated zoomIn"
                                    src="{{ asset('storage/' . ($banner->image ?? 'front-asset/img/hero.png')) }}"
                                    alt="{{ $banner->img_alt_text ?? 'Banner Image' }}">
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
                                src="{{ asset('storage/' . ($about->image ?? 'front-asset/img/about.png')) }}"
                                alt="{{ $about->image_alt ?? 'Abouts Image' }}">
                        </div>

                        <!-- Content Column: Order-2 on mobile, Order-1 on large screens -->
                        <div class="col-lg-6 order-2 order-lg-1 wow fadeInUp" data-wow-delay="0.1s">

                            <h1 class="mb-5">{{ $about->subtitle }}</h1>
                            <p class="mb-4">{!! $about->description !!}</p>



                            <a href="{{ url('about') }}" class="btn btn-custom py-sm-3 px-sm-5 rounded-pill mt-3">Read
                                More</a>
                        </div>

                    </div>
                </div>
            @empty
            @endforelse
        </div>

        <!-- About End -->


        {{-- counter --}}
        @include('front.counter')
        {{-- /counter --}}

        <!-- PRODUCT Start -->
        @include('front.product')
        <!-- Feature End -->


        <!-- Service Start -->
        <div class="container-fluid py-5 bg-light">
            <div class="container py-5 px-lg-5">
                <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
                    <p class="section-title text-dark justify-content-center"><span></span>Our Services<span></span></p>
                    <h1 class="display-6">What Solutions We Provide</h1>
                    <p class="text-muted">Discover the wide range of digital, creative, and strategic solutions we offer to
                        elevate your business.</p>
                </div>

                <div class="row g-4">
                    @forelse ($serviceCategories as $category)
                        @foreach ($category->serviceDetails as $detail)
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="bg-white shadow rounded-4 text-center h-100 p-4 service-card transition-scale">
                                    <div class="service-icon mb-3 text-primary fs-1">
                                        <i class="{{ $category->icon }}"></i>
                                    </div>
                                    <h5 class="fw-bold mb-2">{{ $category->name }}</h5>
                                    <p class="text-muted mb-4">
                                        {{ \Illuminate\Support\Str::limit($detail->sort_description, 120) }}</p>
                                    <div class="d-flex justify-content-center gap-3">
                                        <a href="{{ route('servicedetail', $category->slug) }}"
                                            class="btn btn-success btn-sm px-4">Read More</a>
                                        <a href="#contact" class="btn btn-custom btn-sm px-4">Contact Us</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @empty
                        <div class="col-12 text-center">
                            <p class="text-muted">No services available at the moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        <!-- Service End -->


        <!-- Service End -->

        <!-- Projects Start -->
        <div class="container-fluid py-5 bg-light">
            <div class="container py-5 px-lg-5">
                <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
                    <p class="section-title text-dark justify-content-center"><span></span>Our Projects<span></span></p>
                    <h1 class="display-6">Recently Completed Projects</h1>
                    <p class="text-muted">Explore a few of our successful project deployments for different clients.</p>
                </div>

                <!-- Tab-style Filter Buttons -->
                <div class="row mb-4 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="col-12 d-flex justify-content-center flex-wrap gap-2" id="portfolio-flters">
                        <button class="btn btn-outline-dark active" data-filter="*">All</button>
                        @foreach ($categories as $category)
                            <button class="btn btn-outline-dark"
                                data-filter=".{{ Str::slug($category) }}">{{ $category }}</button>
                        @endforeach
                    </div>
                </div>

                <!-- Projects Grid -->
                <div class="row g-4 portfolio-container">
                    @foreach ($projects as $project)
                        @php
                            $images = json_decode($project->project_images, true) ?? [];
                            $firstImage = $images[0] ?? $project->thumb_image;
                        @endphp
                        <div class="col-lg-4 col-md-6 portfolio-item {{ Str::slug($project->project_category_name) }} wow fadeInUp"
                            data-wow-delay="0.1s">
                            <div class="card shadow-sm border-0 h-100 project-card overflow-hidden rounded-4">
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $firstImage) }}" class="card-img-top"
                                        alt="{{ $project->title }}" style="height: 240px; object-fit: cover;">
                                    <div class="portfolio-overlay d-flex align-items-center justify-content-center gap-2">
                                        @if (count($images))
                                            <a href="{{ asset('storage/' . $images[0]) }}"
                                                data-lightbox="portfolio-{{ $project->id }}"
                                                class="btn btn-light btn-sm rounded-circle">
                                                <i class="fa fa-eye text-danger"></i>
                                            </a>

                                            @foreach ($images as $index => $img)
                                                @if ($index > 0)
                                                    <a href="{{ asset('storage/' . $img) }}"
                                                        data-lightbox="portfolio-{{ $project->id }}" class="d-none"></a>
                                                @endif
                                            @endforeach
                                        @endif

                                        @if ($project->project_url)
                                            <a href="{{ $project->project_url }}" target="_blank"
                                                class="btn btn-light btn-sm rounded-circle">
                                                <i class="fa fa-link text-dark"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body text-center">
                                    <p class="text-danger small fw-semibold mb-1">{{ $project->project_category_name }}</p>
                                    <h5 class="card-title mb-0">{{ $project->title }}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Projects End -->




        <!-- Testimonials Start -->
        <div class="container-fluid py-5 bg-light">
            <div class="container">
                <div class="text-center mx-auto mb-5" style="max-width: 600px;">
                    <h5 class="text-dark">Testimonials</h5>
                    <h1 class="display-6 mb-4">What Our Clients Say!</h1>
                    <p class="text-muted">Real stories from real people. See how our service is making an impact.</p>
                </div>

                @if ($testimonials->count())
                    <div class="owl-carousel testimonial-carousel">
                        @foreach ($testimonials as $testimonial)
                            <div class="testimonial-item bg-white rounded-4 shadow-sm p-4 border border-light">
                                <div class="d-flex align-items-center mb-3">
                                    <img class="img-fluid rounded-circle border border-3 border-dark"
                                        src="{{ asset('storage/' . $testimonial->image) }}"
                                        alt="{{ $testimonial->name }}"
                                        style="width: 65px; height: 65px; object-fit: cover;">
                                    <div class="ps-3">
                                        <h5 class="mb-1">{{ $testimonial->name }}</h5>
                                        <span class="text-muted small">{{ $testimonial->designation }}</span><br>
                                        <span class="text-muted small">{{ $testimonial->company }}</span>
                                    </div>
                                </div>
                                <p class="fst-italic text-dark mb-0">
                                    <i class="fas fa-quote-left me-2 text-dark"></i>{{ $testimonial->message }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-muted">No testimonials found.</p>
                @endif
            </div>
        </div>
        <!-- Testimonials End -->




        <!-- Contact Start -->
        @include('front.contentcomponent')

        {{-- start contact us --}}


        <div class="container-fluid py-5">
            <div class="container bg-light py-5 px-4 px-lg-5 rounded shadow text-center">
                <!-- Text Content -->
                <div class="mb-4">
                    <h2 class="fw-bold mb-3">Have a project in mind? Let's talk now.</h2>
                    <p class="text-muted mb-0">Sure, let’s discuss your project idea in detail. What’s next?</p>
                </div>

                <!-- Buttons Row -->
                <div class="row justify-content-center g-3 mb-3">
                    <div class="col-md-auto">
                        <a href="tel:+918299012292" class="btn btn-success px-4 py-3 rounded-pill shadow-sm">
                            <i class="fa fa-phone-alt me-2"></i> Call Now
                        </a>
                    </div>
                    <div class="col-md-auto">
                        <a href="https://wa.me/+918299012292" target="_blank"
                            class="btn btn-success px-4 py-3 rounded-pill shadow-sm">
                            <i class="fab fa-whatsapp me-2"></i> WhatsApp
                        </a>
                    </div>
                </div>

                <!-- Optional: Full-width WhatsApp Button -->
                <div class="d-grid">
                    <a href="https://wa.me/+918299012292" target="_blank"
                        class="btn btn-success py-3 rounded-pill fw-semibold shadow">
                        <i class="fab fa-whatsapp me-2"></i> Let's Chat on WhatsApp
                    </a>
                </div>
            </div>
        </div>




    </div>

    <!-- jQuery (required) -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Initialize Isotope -->
    <script>
        $(window).on('load', function() {
            var $grid = $('.portfolio-container').isotope({
                itemSelector: '.portfolio-item',
                layoutMode: 'fitRows'
            });

            $('#portfolio-flters').on('click', 'button', function() {
                $('#portfolio-flters button').removeClass('active');
                $(this).addClass('active');
                var filterValue = $(this).attr('data-filter');
                $grid.isotope({
                    filter: filterValue
                });
            });
        });
    </script>

@endsection
