<div class="container-fluid py-5 position-relative overflow-hidden">
    <!-- Background Image -->
    <img src="{{ asset('asset/img/image1.jpg') }}" alt="Contact Background"
        class="position-absolute w-100 h-100 top-0 start-0 z-n1"
        style="object-fit: cover; opacity: 0.8;">

    <div class="container py-5 position-relative z-1">
        <!-- Heading -->
        <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay=".3s" style="max-width: 600px;">
            <h5 class="text-dark">Get In Touch</h5>
            <h1 class="mb-3">Contact for any query</h1>
        </div>

        <!-- Contact Info Cards -->
        <div class="contact-detail bg-white rounded shadow-lg p-4 p-md-5">
            <div class="row g-4 mb-5 justify-content-center">
                <!-- Address -->
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay=".3s">
                    <div class="d-flex bg-light p-3 rounded h-100 align-items-start">
                        <div class="flex-shrink-0 btn-square custom-color rounded-circle d-flex align-items-center justify-content-center"
                             style="width: 64px; height: 64px;">
                            <i class="fas fa-map-marker-alt text-white fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="text-dark mb-1">Address</h5>
                            <a href="https://www.google.com/maps/place/Real+Victory+Groups/..."
                               class="text-dark text-decoration-none" target="_blank">
                                73 Basement, Ekta Enclave Society, Lakhanpur,<br> Khyora, Kanpur, Uttar Pradesh 208024
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Phone -->
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay=".5s">
                    <div class="d-flex bg-light p-3 rounded h-100 align-items-start">
                        <div class="flex-shrink-0 btn-square custom-color rounded-circle d-flex align-items-center justify-content-center"
                             style="width: 64px; height: 64px;">
                            <i class="fa fa-phone text-white fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="text-dark mb-1">Call Us</h5>
                            <a href="tel:+918299012292" class="text-dark text-decoration-none">
                                +91 82990 12292
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay=".7s">
                    <div class="d-flex bg-light p-3 rounded h-100 align-items-start">
                        <div class="flex-shrink-0 btn-square custom-color rounded-circle d-flex align-items-center justify-content-center"
                             style="width: 64px; height: 64px;">
                            <i class="fa fa-envelope text-white fs-4"></i>
                        </div>
                        <div class="ms-3 overflow-hidden text-break" style="min-width: 0;">
                            <h5 class="text-dark mb-1">Email Us</h5>
                            <a class="text-dark text-decoration-none d-inline-block text-break" href="mailto:realvictorygroups@gmail.com"
                               style="word-break: break-all;">
                                realvictorygroups@gmail.com
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form & Map -->
            <div class="row g-4">
                <!-- Map -->
                <div class="col-lg-6 wow fadeIn" data-wow-delay=".3s">
                    <div class="h-100 rounded overflow-hidden shadow-sm">
                        <iframe class="w-100 h-100 border-0"
                            style="min-height: 300px;"
                            src="https://www.google.com/maps/embed?pb=!1m18!...RealVictoryGroups..."
                            allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

                <!-- Contact Form -->
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
                        <button type="submit" class="btn custom-color text-white py-3 px-4 w-100">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
