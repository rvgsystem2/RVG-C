@extends('component.main')
@section('content')
    <div class="container-fluid bg-white p-0">
 <!-- Page Header -->
<div class="container-fluid custom-color py-5">
    <div class="container text-center py-5">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Contact us</h1>
        <nav aria-label="breadcrumb" class="animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">contact us</li>
            </ol>
        </nav>
    </div>
</div>




<!-- Contact Start -->
<div class="container-fluid py-5 mt-5 position-relative overflow-hidden">
    <!-- Background Image -->
    <img src="{{ asset('asset/img/image1.jpg') }}" alt="Contact Background"
        class="position-absolute w-100 h-100 object-fit-cover top-0 start-0 z-n1" style="opacity: 0.8;">

    <div class="container py-5 position-relative z-1">
        <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay=".3s" style="max-width: 600px;">
            <h5 class="text-dark">Get In Touch</h5>
            <h1 class="mb-3">Contact for any query</h1>
            <p class="mb-2 text-dark">
                The contact form is currently inactive. You can get a working Ajax & PHP form in minutes.
                <a href="https://htmlcodex.com/contact-form" class="text-dark fw-bold">Download Now</a>.
            </p>
        </div>

        <div class="contact-detail bg-white rounded shadow-lg position-relative p-5">
            <!-- Contact Details -->
            <div class="row g-5 mb-5 justify-content-center">
                <div class="col-xl-4 col-lg-6 wow fadeIn" data-wow-delay=".3s">
                    <div class="d-flex bg-light p-3 rounded h-100">
                        <div class="flex-shrink-0 btn-square custom-color rounded-circle d-flex align-items-center justify-content-center"
                             style="width: 64px; height: 64px;">
                            <i class="fas fa-map-marker-alt text-white fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="text-dark">Address</h4>
                            <a href="https://goo.gl/maps/Zd4BCynmTb98ivUJ6" target="_blank" class="h5 d-block text-dark text-decoration-none">
                                23 Rank Str, NY
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 wow fadeIn" data-wow-delay=".5s">
                    <div class="d-flex bg-light p-3 rounded h-100">
                        <div class="flex-shrink-0 btn-square custom-color rounded-circle d-flex align-items-center justify-content-center"
                             style="width: 64px; height: 64px;">
                            <i class="fa fa-phone text-white fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="text-dark">Call Us</h4>
                            <a class="h5 d-block text-dark text-decoration-none" href="tel:+0123456789" target="_blank">
                                +012 3456 7890
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 wow fadeIn" data-wow-delay=".7s">
                    <div class="d-flex bg-light p-3 rounded h-100">
                        <div class="flex-shrink-0 btn-square custom-color rounded-circle d-flex align-items-center justify-content-center"
                             style="width: 64px; height: 64px;">
                            <i class="fa fa-envelope text-white fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="text-dark">Email Us</h4>
                            <a class="h5 d-block text-dark text-decoration-none" href="mailto:info@example.com" target="_blank">
                                info@example.com
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form + Map -->
            <div class="row g-5">
                <div class="col-lg-6 wow fadeIn" data-wow-delay=".3s">
                    <div class="h-100 rounded overflow-hidden shadow-sm">
                        <iframe class="w-100 h-100 border-0 rounded"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3025.4710403339755!2d-73.82241512404069!3d40.685622471397615!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c26749046ee14f%3A0xea672968476d962c!2s123rd%20St%2C%20Queens%2C%20NY%2C%20USA!5e0!3m2!1sen!2sbd!4v1686493221834!5m2!1sen!2sbd"
                                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

                <div class="col-lg-6 wow fadeIn" data-wow-delay=".5s">
                    <form class="p-4 bg-light rounded shadow-sm">
                        <div class="mb-3">
                            <input type="text" class="form-control border-0 py-3" placeholder="Your Name">
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control border-0 py-3" placeholder="Your Email">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control border-0 py-3" placeholder="Project">
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control border-0 py-3" rows="5" placeholder="Message"></textarea>
                        </div>
                        <button type="button" class="btn custom-color text-white py-3 px-5">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


    </div>

@endsection
