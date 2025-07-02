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
                                src="{{ asset('front-asset/img/testimonial-1.jpg') }}" style="width: 65px; height: 65px;">
                            <div class="ps-4">
                                <h5 class="mb-1">Client Name</h5>
                                <span>Profession</span>
                            </div>
                        </div>
                        <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos.
                            Clita erat ipsum et lorem et sit.</p>
                    </div>
                    <div class="testimonial-item bg-custom rounded p-4">
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded-circle"
                                src="{{ asset('front-asset/img/testimonial-2.jpg') }}" style="width: 65px; height: 65px;">
                            <div class="ps-4">
                                <h5 class="mb-1">Client Name</h5>
                                <span>Profession</span>
                            </div>
                        </div>
                        <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos.
                            Clita erat ipsum et lorem et sit.</p>
                    </div>
                    <div class="testimonial-item bg-custom rounded p-4">
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded-circle"
                                src="{{ asset('front-asset/img/testimonial-3.jpg') }}" style="width: 65px; height: 65px;">
                            <div class="ps-4">
                                <h5 class="mb-1">Client Name</h5>
                                <span>Profession</span>
                            </div>
                        </div>
                        <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos.
                            Clita erat ipsum et lorem et sit.</p>
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
        <!-- Service End -->





    </div>

@endsection
