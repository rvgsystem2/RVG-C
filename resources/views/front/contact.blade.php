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
<div class="container-fluid py-5 mt-0 position-relative overflow-hidden">
    <!-- Background Image -->
    <img src="{{ asset('asset/img/image1.jpg') }}" alt="Contact Background"
        class="position-absolute w-100 h-100 object-fit-cover top-0 start-0 z-n1" style="opacity: 0.8; object-fit: cover;">

    <div class="container py-5 position-relative z-1">
        <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay=".3s" style="max-width: 600px;">
            <h5 class="text-dark">Get In Touch</h5>
            <h1 class="mb-3">Contact for any query</h1>
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
                            <a href="https://www.google.com/maps/place/Real+Victory+Groups/@26.4945319,80.2796977,17z/data=!3m1!4b1!4m6!3m5!1s0x399c3826d4ebf859:0xe9e2ed37cc371552!8m2!3d26.4945319!4d80.2796977!16s%2Fg%2F11gfmmvbm9?entry=ttu&g_ep=EgoyMDI1MDYyOS4wIKXMDSoASAFQAw%3D%3D" target="_blank" class="text-dark text-decoration-none">
                                73 Basement, Ekta Enclave Society, Lakhanpur, Khyora, Kanpur, Uttar Pradesh 208024
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
                                08299012292
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
                            realvictorygroups.com
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
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3570.7953955523994!2d80.2796977!3d26.4945319!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x399c3826d4ebf859%3A0xe9e2ed37cc371552!2sReal%20Victory%20Groups!5e0!3m2!1sen!2sin!4v1751433742224!5m2!1sen!2sin"
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



    </div>

@endsection
