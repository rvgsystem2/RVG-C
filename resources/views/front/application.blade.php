@extends('component.main')
@section('content')
 <!-- Page Header Start -->
 <div class="container-fluid custom-color  my-lg-5 py-md-4 py-sm-3 py-2">
    <div class="container text-center py-5">
        <h1 class="display-2 text-white mb-4 animated slideInDown">Our App</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>

                <li class="breadcrumb-item" aria-current="page"><a href="">App</a></li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- App Buttons Start -->
<div class="container my-5 lg:py-5">
    <div class="row py-5 justify-content-center g-4">

        <span class="text-center fs-1 font-bold text-dark">Download it Now !</span>

        <!-- App Store Button -->
        <div class="col-12 col-md-6 col-lg-5">
            <a href="https://apps.apple.com/in/app/real-victory-groups-daily-post/id6746252505"
                class="d-flex align-items-center justify-content-center gap-3 bg-dark text-white rounded-4 px-4 py-4 shadow-lg text-decoration-none hover-scale"
                style="transition: transform 0.3s ease;">
                <i class="fab fa-apple fa-3x"></i>
                <div class="text-start">
                    <small class="d-block fs-6 text-white">Download on the</small>
                    <strong class="fs-4">App Store</strong>
                </div>
            </a>
        </div>

        <!-- Google Play Button -->
        <div class="col-12 col-md-6 col-lg-5">
            <a href="https://play.google.com/store/apps/details?id=com.rvg.chat_real_victory&pcampaignid=web_share"
                class="d-flex align-items-center justify-content-center gap-3 bg-dark text-white rounded-4 px-4 py-4 shadow-lg text-decoration-none hover-scale"
                style="transition: transform 0.3s ease;">
                <i class="fab fa-google-play fa-3x"></i>
                <div class="text-start">
                    <small class="d-block fs-6 text-light">Get it on</small>
                    <strong class="fs-4">Google Play</strong>
                </div>
            </a>
        </div>
    </div>
</div>
<!-- App Buttons End -->

<!-- Custom Hover & Animation Styles -->
<style>
    .hover-scale:hover {
        transform: scale(1.05);
        background: linear-gradient(145deg, #232323, #1a1a1a);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    @media (max-width: 576px) {
        .display-4 {
            font-size: 2rem !important;
        }
    }
</style>

@endsection
