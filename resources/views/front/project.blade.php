@extends('component.main', ['seos' => $seos])
@section('content')

<!-- Page Header -->
<div class="container-fluid custom-color py-5">
    <div class="container text-center py-5">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Projects</h1>
        <nav aria-label="breadcrumb" class="animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Projects</li>
            </ol>
        </nav>
    </div>
</div>

    <div class="container-fluid bg-white p-0">


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

    </div>
@endsection
