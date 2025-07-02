<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DGital - Digital Agency HTML Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Jost:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('front-asset/lib/animate/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('front-asset/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('front-asset/lib/lightbox/css/lightbox.min.css')}}" rel="stylesheet">

 
<!-- Your custom style -->
<style>
    .testimonial-item {
        transition: all 0.3s ease-in-out;
    }

    .testimonial-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .transition-scale {
    transition: transform 0.3s ease-in-out;
}
.transition-scale:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
}
    .transition-scale {
    transition: transform 0.4s ease-in-out;
}
.transition-scale:hover {
    transform: scale(1.05);
}

.product-card:hover {
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
}

.portfolio-overlay {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background: rgba(0, 0, 0, 0.6);
    opacity: 0;
    transition: all 0.4s ease;
}

.project-card:hover .portfolio-overlay {
    opacity: 1;
}

#portfolio-flters button {
    transition: 0.3s;
    border-radius: 50px;
    padding: 6px 18px;
}

#portfolio-flters button.active,
#portfolio-flters button:hover {
    background-color: #dc3545;
    color: #fff;
    border-color: #dc3545;
}

</style>

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('front-asset/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('front-asset/css/style.css')}}" rel="stylesheet">
</head>

<body>


    @include('component.header')

    @yield('content')

    @include('component.footer')


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('front-asset/lib/wow/wow.min.js')}}"></script>
    <script src="{{asset('front-asset/lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('front-asset/lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('front-asset/lib/counterup/counterup.min.js')}}"></script>
    <script src="{{asset('front-asset/lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('front-asset/lib/isotope/isotope.pkgd.min.js')}}"></script>
    <script src="{{asset('front-asset/lib/lightbox/js/lightbox.min.js')}}"></script>

    <!-- Template Javascript -->
    <script src="{{asset('front-asset/js/main.js')}}"></script>
</body>

</html>
