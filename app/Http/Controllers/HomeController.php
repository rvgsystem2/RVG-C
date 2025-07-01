<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ServiceCategory;
use App\Models\ServiceDetail;
use Illuminate\Http\Request;

class HomeController extends Controller
{
public function index()
{
    $projects = Project::latest()->get();
    $categories = $projects->pluck('project_category_name')->unique();

    $serviceCategories = ServiceCategory::with('serviceDetails')->get();

    return view('front.index', compact('projects', 'categories', 'serviceCategories'));
}


public function servicedetail($slug)
{
    $service = ServiceCategory::with('serviceDetails')->where('slug', $slug)->firstOrFail();
    return view('front.servicedetail', compact('service'));
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
        $projects = \App\Models\Project::latest()->get();

    // Extract unique categories for filters
    $categories = $projects->pluck('project_category_name')->unique();
        return view('front.project' , compact('projects', 'categories'));
    }

    public function blog(){
        return view('front.blog');
    }

    public function blogdetail(){
        return view('front.blogdetail');
    }




}
