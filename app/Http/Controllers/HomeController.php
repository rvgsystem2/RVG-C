<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('front.index');
    }

    public function about(){
        return view('front.about');
    }

    public function service(){
        return view('front.service');
    }

    public function team(){
        return view('front.team');
    }

    public function testimonial(){
        return view('front.testimonial');
    }

    public function contact(){
        return view('front.contact');
    }

    public function notFound(){
        return view('front.404');
    }
    public function project(){
        return view('front.project');
    }

    
}
