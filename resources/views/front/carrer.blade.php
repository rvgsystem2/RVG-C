@extends('component.main')

@section('content')
       <!-- Page Header Start -->
       <div class="container-fluid custom-color lg:py-5 md:py-4 sm:py-3 py-2">
        <div class="container text-center lg:py-5 md:py-4 sm:py-3 py-2">
            <h1 class="display-2 text-white mb-4 animated slideInDown">Join Our Team</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>

                    <li class="breadcrumb-item" aria-current="page"><a href="#">Carrer</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

<!-- Job Openings -->
<div class="container my-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold">Current Openings</h2>
        <p class="text-muted">We are always looking for talented individuals to join our team</p>
    </div>

    <div class="row g-4">
        <!-- Job Card Example -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Web Developer</h5>
                    <p class="card-text text-muted">We are looking for a skilled developer with experience in Laravel and modern front-end frameworks.</p>
                    <ul class="list-unstyled">
                        <li><strong>Location:</strong> Remote</li>
                        <li><strong>Experience:</strong> 2+ years</li>
                        <li><strong>Type:</strong> Full Time</li>
                    </ul>
                    <a href="#applyForm" class="btn btn-dark mt-2">Apply Now</a>
                </div>
            </div>
        </div>

        <!-- Repeat for more jobs -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Graphic Designer</h5>
                    <p class="card-text text-muted">Looking for creative designers with Adobe Suite experience and branding skills.</p>
                    <ul class="list-unstyled">
                        <li><strong>Location:</strong> Mumbai</li>
                        <li><strong>Experience:</strong> 1+ years</li>
                        <li><strong>Type:</strong> Part Time</li>
                    </ul>
                    <a href="#applyForm" class="btn btn-dark mt-2">Apply Now</a>
                </div>
            </div>
        </div>

        <!-- Add more job cards as needed -->
    </div>
</div>

<!-- Application Form -->
<div class="container my-5" id="applyForm">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header custom-color text-white">
                    <h4 class="mb-0 text-light">Apply Now</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="#" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name *</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone *</label>
                                <input type="text" name="phone" id="phone" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="position" class="form-label">Position Applied For *</label>
                                <select name="position" id="position" class="form-select" required>
                                    <option selected disabled value="">Choose a position</option>
                                    <option>Web Developer</option>
                                    <option>Graphic Designer</option>
                                    <option>Digital Marketing Executive</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label">Message (Optional)</label>
                                <textarea name="message" id="message" rows="4" class="form-control"></textarea>
                            </div>
                            <div class="col-12">
                                <label for="resume" class="form-label">Upload Resume *</label>
                                <input type="file" name="resume" id="resume" class="form-control" accept=".pdf,.doc,.docx" required>
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-dark">Submit Application</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
