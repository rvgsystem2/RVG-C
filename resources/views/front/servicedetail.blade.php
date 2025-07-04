@extends('component.main', ['seos' => $seos])
@section('content')

<!-- Page Header Start -->
<div class="container-fluid custom-color py-5">
    <div class="container text-center py-5">
        <h1 class="display-2 text-white mb-4 animated slideInDown">Service Detail</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $service->name }}</li>
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
                @php
                    $firstDetail = $service->serviceDetails->first();
                @endphp
                <!-- Banner Image -->
                <div class="position-relative mb-4">
                    <img src="{{ asset('storage/' . ($firstDetail->image ?? 'default.jpg')) }}" class="img-fluid-service rounded shadow" alt="{{ $firstDetail->image_alt ?? 'Service Image' }}">
                    <span class="position-absolute top-0 end-0 custom-color text-white px-4 py-2 rounded-bottom-start">
                        {{ $service->name }}
                    </span>
                </div>

                <!-- Title & Meta -->
                <h1 class="mb-3 fw-bold">{{ $service->name }}</h1>
                <p class="text-muted mb-4"><i class="fa fa-calendar-alt me-2"></i>Last Updated: {{ $firstDetail->updated_at->format('d M Y') }}</p>

                <!-- Service Description -->
                <p class="lead">{{ $firstDetail->sort_description }}</p>
                <p>{!! $firstDetail->description !!}</p>

                <!-- Call to Action -->
                <div class="bg-white p-4 rounded shadow-sm mt-4">
                    <h5 class="fw-bold mb-3">Let’s Get Started Today!</h5>
                    <p>Looking for reliable service solutions? Contact us today to bring your ideas to life.</p>
                    <a href="{{ url('/contact') }}" class="btn btn-dark px-4 py-2 rounded-pill">Contact Our Team</a>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Related Services -->
                <div class="mb-5 p-4 bg-white rounded shadow-sm">
                    <h5 class="fw-bold mb-3">Other Services</h5>
                    <ul class="list-unstyled">
                        @foreach(App\Models\ServiceCategory::where('id', '!=', $service->id)->limit(5)->get() as $item)
                        <li class="mb-2">
                            <a href="{{ route('servicedetail', $item->slug) }}" class="text-decoration-none text-dark">
                                <i class="fas fa-angle-right me-2"></i>{{ $item->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Quick Contact -->
                <div class="p-4 bg-success rounded shadow-sm">
                    <h5 class="fw-bold mb-3">Need Help?</h5>
                    <p class="mb-3 text-white">Get in touch with our experts to find out how we can boost your digital presence.</p>
                    <a href="tel:+917753800444" class="btn btn-custom w-100 mb-2">Request a Call Back</a>
                    <a href="mailto:realvictorygroups@gmail.com" class="btn btn-custom w-100">Email Us</a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
