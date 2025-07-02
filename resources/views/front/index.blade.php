@extends('component.main')
@section('content')


<div class="container-flued bg-white p-0">
    <!-- Spinner Start -->
    {{-- <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div> --}}
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <div class="container-flued position-relative p-0">


            <div class="container-flued pb-5 pt-5 custom-color" id="">
                <div class="container px-lg-5 pt-5">
                    <div class="row g-5 align-items-end">
                        <div class="col-lg-6 text-center text-lg-start">
                            <h1 class="text-white mb-4 animated slideInDown">A Digital Agency Of Inteligents & Creative
                                People</h1>
                            <p class="text-white pb-3 animated slideInDown">Tempor rebum no at dolore lorem clita rebum rebum
                                ipsum rebum stet dolor sed justo kasd. Ut dolor sed magna dolor sea diam. Sit diam sit justo
                                amet ipsum vero ipsum clita lorem</p>
                            <a href=""
                                class="btn btn-dark py-sm-3 px-sm-5 rounded-pill me-3 animated slideInLeft">Read More</a>
                            <a href=""
                                class="btn btn-light py-sm-3 px-sm-5 rounded-pill animated slideInRight text-danger">Contact
                                Us</a>
                        </div>
                        <div class="col-lg-6 text-center text-lg-start pt-5">
                            <img class="img-fluid animated zoomIn" src="{{ asset('front-asset/img/hero.png') }}"
                                alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->




        <!-- About Start -->
        <div class="container-fluid py-5">
            <div class="container py-5 px-lg-5">
                <p class="section-title ">About Us<span></span></p>
                <div class="row g-5 align-items-center">

                    <!-- Image Column: Order-1 on mobile, Order-2 on large screens -->
                    <div class="col-lg-6 order-1 order-lg-2">
                        <img class="img-fluid wow zoomIn" data-wow-delay="0.5s"
                            src="{{ asset('front-asset/img/about.png') }}" alt="About Image">
                    </div>

                    <!-- Content Column: Order-2 on mobile, Order-1 on large screens -->
                    <div class="col-lg-6 order-2 order-lg-1 wow fadeInUp" data-wow-delay="0.1s">

                        <h1 class="mb-5">#1 Digital solution with 10 years of experience</h1>
                        <p class="mb-4">Diam dolor diam ipsum et tempor sit. Aliqu diam amet diam et eos labore. Clita
                            erat ipsum et lorem et sit, sed stet no labore lorem sit clita duo justo eirmod magna dolore
                            erat amet</p>

                        <div class="skill mb-4">
                            <div class="d-flex justify-content-between">
                                <p class="mb-2">Digital Marketing</p>
                                <p class="mb-2">85%</p>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-custom" style="width: 85%;" role="progressbar"
                                    aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        <div class="skill mb-4">
                            <div class="d-flex justify-content-between">
                                <p class="mb-2">SEO & Backlinks</p>
                                <p class="mb-2">90%</p>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-secondary" style="width: 90%;" role="progressbar"
                                    aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        <div class="skill mb-4">
                            <div class="d-flex justify-content-between">
                                <p class="mb-2">Design & Development</p>
                                <p class="mb-2">95%</p>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-dark" style="width: 95%;" role="progressbar" aria-valuenow="95"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        <a href="#" class="btn btn-custom py-sm-3 px-sm-5 rounded-pill mt-3">Read More</a>
                    </div>

                </div>
            </div>
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
                        <img class="img-fluid flex-shrink-0 rounded-circle" src="{{asset('front-asset/img/testimonial-1.jpg')}}" style="width: 65px; height: 65px;">
                        <div class="ps-4">
                            <h5 class="mb-1">Client Name</h5>
                            <span>Profession</span>
                        </div>
                    </div>
                    <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                </div>
                <div class="testimonial-item bg-custom rounded p-4">
                    <div class="d-flex align-items-center">
                        <img class="img-fluid flex-shrink-0 rounded-circle" src="{{asset('front-asset/img/testimonial-2.jpg')}}" style="width: 65px; height: 65px;">
                        <div class="ps-4">
                            <h5 class="mb-1">Client Name</h5>
                            <span>Profession</span>
                        </div>
                    </div>
                    <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                </div>
                <div class="testimonial-item bg-custom rounded p-4">
                    <div class="d-flex align-items-center">
                        <img class="img-fluid flex-shrink-0 rounded-circle" src="{{asset('front-asset/img/testimonial-3.jpg')}}" style="width: 65px; height: 65px;">
                        <div class="ps-4">
                            <h5 class="mb-1">Client Name</h5>
                            <span>Profession</span>
                        </div>
                    </div>
                    <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                </div>
                <div class="testimonial-item bg-custom rounded p-4">
                    <div class="d-flex align-items-center">
                        <img class="img-fluid flex-shrink-0 rounded-circle" src="{{asset('front-asset/img/testimonial-4.jpg')}}" style="width: 65px; height: 65px;">
                        <div class="ps-4">
                            <h5 class="mb-1">Client Name</h5>
                            <span>Profession</span>
                        </div>
                    </div>
                    <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->



<!-- Contact Start -->
<div class="container-fluid py-5 mt-0 position-relative overflow-hidden">
    <!-- Background Image -->
    <img src="{{ asset('asset/img/image1.jpg') }}" alt="Contact Background"
        class="position-absolute w-100 h-100 object-fit-cover top-0 start-0 z-n1" style="opacity: 0.8; object-fit: cover;">

    <div class="container py-5 position-relative z-1">
        <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay=".3s" style="max-width: 600px;">
            <h5 class="text-dark">Get In Touch</h5>
            <h1 class="mb-3">Contact for any query</h1>
            <p class="mb-2 text-dark">
                The contact form is currently inactive. You can get a working Ajax & PHP form in minutes.
                <a href="https://htmlcodex.com/contact-form" class="text-dark fw-bold">Download Now</a>.
            </p>
        </div>

        <div class="contact-detail bg-white rounded shadow-lg position-relative p-4 p-md-5">
            <!-- Contact Details -->
            <div class="row g-4 g-lg-5 mb-5 justify-content-center">
                <!-- Address -->
                <div class="col-md-6 col-xl-4 wow fadeIn" data-wow-delay=".3s">
                    <div class="d-flex bg-light p-3 rounded h-100">
                        <div class="flex-shrink-0 btn-square custom-color rounded-circle d-flex align-items-center justify-content-center"
                             style="width: 64px; height: 64px;">
                            <i class="fas fa-map-marker-alt text-white fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="text-dark mb-1">Address</h5>
                            <a href="https://goo.gl/maps/Zd4BCynmTb98ivUJ6" target="_blank" class="text-dark text-decoration-none">
                                23 Rank Str, NY
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Phone -->
                <div class="col-md-6 col-xl-4 wow fadeIn" data-wow-delay=".5s">
                    <div class="d-flex bg-light p-3 rounded h-100">
                        <div class="flex-shrink-0 btn-square custom-color rounded-circle d-flex align-items-center justify-content-center"
                             style="width: 64px; height: 64px;">
                            <i class="fa fa-phone text-white fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="text-dark mb-1">Call Us</h5>
                            <a class="text-dark text-decoration-none" href="tel:+0123456789">
                                +012 3456 7890
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="col-md-6 col-xl-4 wow fadeIn" data-wow-delay=".7s">
                    <div class="d-flex bg-light p-3 rounded h-100">
                        <div class="flex-shrink-0 btn-square custom-color rounded-circle d-flex align-items-center justify-content-center"
                             style="width: 64px; height: 64px;">
                            <i class="fa fa-envelope text-white fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="text-dark mb-1">Email Us</h5>
                            <a class="text-dark text-decoration-none" href="mailto:info@example.com">
                                info@example.com
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form + Map -->
            <div class="row g-4 g-lg-5">
                <!-- Google Map -->
                <div class="col-lg-6 wow fadeIn" data-wow-delay=".3s">
                    <div class="h-100 rounded overflow-hidden shadow-sm">
                        <iframe class="w-100 h-100 border-0"
                                style="min-height: 300px;"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3025.4710403339755!2d-73.82241512404069!3d40.685622471397615!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c26749046ee14f%3A0xea672968476d962c!2s123rd%20St%2C%20Queens%2C%20NY%2C%20USA!5e0!3m2!1sen!2sbd!4v1686493221834!5m2!1sen!2sbd"
                                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

                <!-- Form -->
                <div class="col-lg-6 wow fadeIn" data-wow-delay=".5s">
                    <form class="bg-light rounded shadow-sm p-4">
                        <div class="mb-3">
                            <input type="text" class="form-control border-0 py-3" placeholder="Your Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control border-0 py-3" placeholder="Your Email" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control border-0 py-3" placeholder="Subject">
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control border-0 py-3" rows="5" placeholder="Message"></textarea>
                        </div>
                        <button type="submit" class="btn custom-color text-white py-3 px-4 w-100">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- end contact us --}}


        <!-- Team Start -->
        {{-- <div class="container-flued py-5">
        <div class="container py-5 px-lg-5">
            <div class="wow fadeInUp" data-wow-delay="0.1s">
                <p class="section-title text-secondary justify-content-center"><span></span>Our Team<span></span></p>
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
    </div> --}}
        <!-- Team End -->




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

            document.querySelectorAll('#portfolio-flters li').forEach(function (filterEl) {
                filterEl.addEventListener('click', function () {
                    document.querySelectorAll('#portfolio-flters li').forEach(el => el.classList.remove('active'));
                    this.classList.add('active');
                    iso.arrange({ filter: this.getAttribute('data-filter') });
                });
            });
        }
    });
</script>

@endsection
