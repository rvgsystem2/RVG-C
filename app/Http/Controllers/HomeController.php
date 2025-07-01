<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
   public function index()
{
    $projects = \App\Models\Project::latest()->get();

    // Extract unique categories for filters
    $categories = $projects->pluck('project_category_name')->unique();

    return view('front.index', compact('projects', 'categories'));
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

    public function blog(){
        return view('front.blog');
    }

    public function blogdetail(){
        return view('front.blogdetail');
    }


    public function servicedetail(){
        return view('front.servicedeatail');
    }
}
