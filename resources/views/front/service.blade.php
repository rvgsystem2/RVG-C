@extends('component.main')
@section('content')
    <div class="container-fluid bg-white p-0">

        <!-- Page Header Start -->
        <div class="container-fluid custom-color py-5">
            <div class="container text-center py-5">
                <h1 class="display-2 text-white mb-4 animated slideInDown">Our Service</h1>
                <nav aria-label="breadcrumb animated slideInDown">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>

                        <li class="breadcrumb-item" aria-current="page">service</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Page Header End -->




            <!-- Service Start -->
<div class="container-fluid py-5 bg-light">
    <div class="container py-5 px-lg-5">
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <p class="section-title text-dark justify-content-center"><span></span>Our Services<span></span></p>
            <h1 class="display-6">What Solutions We Provide</h1>
            <p class="text-muted">Discover the wide range of digital, creative, and strategic solutions we offer to elevate your business.</p>
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
                            <p class="text-muted mb-4">{{ \Illuminate\Support\Str::limit($detail->sort_description, 120) }}</p>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="{{ route('servicedetail', $category->slug) }}" class="btn btn-success btn-sm px-4">Read More</a>
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

              <!-- Testimonials Start -->
<div class="container-xxl py-5 bg-light">
    <div class="container">
        <div class="text-center mx-auto mb-5" style="max-width: 600px;">
            <h5 class="text-primary">Testimonials</h5>
            <h1 class="display-6 mb-4">What Our Clients Say!</h1>
            <p class="text-muted">Real stories from real people. See how our service is making an impact.</p>
        </div>

        @if ($testimonials->count())
            <div class="owl-carousel testimonial-carousel">
                @foreach ($testimonials as $testimonial)
                    <div class="testimonial-item bg-white rounded-4 shadow-sm p-4 border border-light">
                        <div class="d-flex align-items-center mb-3">
                            <img class="img-fluid rounded-circle border border-3 border-primary"
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
                            <i class="fas fa-quote-left me-2 text-primary"></i>{{ $testimonial->message }}
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
    



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Initialize Isotope -->
<script>
    $(window).on('load', function () {
        var $grid = $('.portfolio-container').isotope({
            itemSelector: '.portfolio-item',
            layoutMode: 'fitRows'
        });

        $('#portfolio-flters').on('click', 'button', function () {
            $('#portfolio-flters button').removeClass('active');
            $(this).addClass('active');
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({ filter: filterValue });
        });
    });
</script>


    </div>

@endsection
