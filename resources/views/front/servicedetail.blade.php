@extends('component.main')
@section('content')

 <!-- Page Header Start -->
 <div class="container-fluid custom-color py-5">
    <div class="container text-center py-5">
        <h1 class="display-2 text-white mb-4 animated slideInDown">Service-detail</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="#">Home</a></li>

                <li class="breadcrumb-item" aria-current="page">service-detail</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->


<!-- Service Detail Page -->
<section class="py-5 bg-light">
    <div class="container mt-5">
        <div class="row g-5">
            <!-- Main Service Detail Content -->
            <div class="col-lg-8">
                <!-- Banner Image -->
                <div class="position-relative mb-4">
                    <img src="{{ asset('asset/img/image1.jpg') }}" class="img-fluid rounded shadow" alt="Web Design">
                    <span class="position-absolute top-0 end-0 custom-color text-white px-4 py-2 rounded-bottom-start">
                        Web Design
                    </span>
                </div>

                <!-- Title & Meta -->
                <h1 class="mb-3 fw-bold">Professional Web Design Solutions</h1>
                <p class="text-muted mb-4"><i class="fa fa-calendar-alt me-2"></i>Updated on 24 March 2023</p>

                <!-- Service Description -->
                <p class="lead">
                    Elevate your brand’s online presence with our custom web design solutions tailored to your business needs.
                </p>
                <p>
                    We build responsive, SEO-optimized, and user-friendly websites that convert visitors into customers. Whether you’re a startup or an enterprise, we focus on providing scalable designs powered by modern UI/UX principles.
                </p>

                <!-- Service Features -->
                <div class="row gy-3 my-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-start gap-3">
                            <i class="fa fa-check-circle text-dark fs-4"></i>
                            <div>
                                <h6 class="mb-1 fw-semibold">Responsive Design</h6>
                                <small>Optimized for all devices – mobile, tablet, and desktop.</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start gap-3">
                            <i class="fa fa-check-circle text-dark fs-4"></i>
                            <div>
                                <h6 class="mb-1 fw-semibold">SEO Friendly</h6>
                                <small>Structured for higher search engine visibility and performance.</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start gap-3">
                            <i class="fa fa-check-circle text-dark fs-4"></i>
                            <div>
                                <h6 class="mb-1 fw-semibold">Custom UI/UX</h6>
                                <small>Modern layouts that deliver a seamless experience to users.</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start gap-3">
                            <i class="fa fa-check-circle text-dark fs-4"></i>
                            <div>
                                <h6 class="mb-1 fw-semibold">Performance Optimized</h6>
                                <small>Fast-loading pages with minimal bounce rates.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="bg-white p-4 rounded shadow-sm mt-4">
                    <h5 class="fw-bold mb-3">Let’s Get Started Today!</h5>
                    <p>Looking for a high-performing website? Contact us today to discuss your vision and how we can bring it to life.</p>
                    <a href="{{ url('/contact') }}" class="btn btn-dark px-4 py-2 rounded-pill">Contact Our Team</a>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Related Services -->
                <div class="mb-5 p-4 bg-white rounded shadow-sm">
                    <h5 class="fw-bold mb-3">Other Services</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-decoration-none text-dark">App Development</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-dark">Email Marketing</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-dark">PPC Advertising</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-dark">Social Media Strategy</a></li>
                    </ul>
                </div>

                <!-- Quick Contact -->
                <div class="p-4 bg-white rounded shadow-sm">
                    <h5 class="fw-bold mb-3">Need Help?</h5>
                    <p class="mb-3">Get in touch with our experts to find out how we can boost your digital presence.</p>
                    <p href="{{ url('/contact') }}" class="btn btn-imp w-100 mb-2">Request a Call Back</p>
                    <p href="mailto:info@yourdomain.com" class="btn btn-imp w-100">Email Us</p>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
