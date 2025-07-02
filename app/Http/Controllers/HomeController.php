<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Banner;
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

    $serviceCategories = ServiceCategory::with('serviceDetails')->where('status', 'active')->get();
    // dd($serviceCategories);
   $abouts=About::where('status', 'active')->get();
   $banners =Banner::where('status', 'active')->get();
    return view('front.index', compact('projects', 'categories', 'serviceCategories', 'abouts', 'banners'));
}


public function servicedetail($slug)
{
    $service = ServiceCategory::with('serviceDetails')->where('slug', $slug)->firstOrFail();

    return view('front.servicedetail', compact('service'));
}


    public function about(){
         $abouts=About::where('status', 'active')->get();
        return view('front.about', compact('abouts'));
    }

    public function service(){
        $serviceCategories = ServiceCategory::with('serviceDetails')->where('status', 'active')->get();
          $projects = Project::latest()->get();
    $categories = $projects->pluck('project_category_name')->unique();
        return view('front.service' , compact('serviceCategories', 'projects', 'categories'));
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

    public function blogs(){
        return view('front.blogs');
    }

    public function blogdetail(){
        return view('front.blogdetail');
    }


    public function privacy(){
        return view('front.privacy');
    }

    public function term(){
        return view('front.term');
    }

    public function refund_policy(){
        return view('front.refund_policy');
    }

    public function carrer(){
        return view('front.carrer');
    }
}
