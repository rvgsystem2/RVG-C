@extends('component.main' , ['seos' => $seos])
@section('content')
    <div class="container-fluid bg-white p-0">
 <!-- Page Header -->
<div class="container-fluid custom-color  mt-lg-5 py-md-4 py-sm-3 py-2">
    <div class="container text-center py-5">
        <h1 class="display-3 text-white mb-3 animated slideInDown ">Contact us</h1>
        <nav aria-label="breadcrumb" class="animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page"><a href="{{route('contact')}}">contact us</a></li>
            </ol>
        </nav>
    </div>
</div>




<!-- Contact Start -->
@include('front.contentcomponent')



    </div>

@endsection
