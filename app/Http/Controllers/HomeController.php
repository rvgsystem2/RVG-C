<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Career;
use App\Models\Package;
use App\Models\Product;
use App\Models\Project;
use App\Models\Seo;
use App\Models\ServiceCategory;
use App\Models\ServiceDetail;
use App\Models\Team;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use PHPUnit\Event\Code\Test;

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
   $products = Product::where('status', 'active')->get();
   $testimonials = Testimonial::where('status', 'active')->get();
   $seos = Seo::where('page_type', 'home')->first();
    return view('front.index', compact('projects', 'categories', 'serviceCategories', 'abouts', 'banners', 'products', 'testimonials', 'seos'));
}

    public function about(){
         $abouts=About::where('status', 'active')->get();
          $products = Product::where('status', 'active')->get();
          $teams=Team::where('status', 'active')->get();
          $seos = Seo::where('page_type', 'about')->first();
        return view('front.about', compact('abouts', 'products','teams', 'seos'));
    }




    public function service(){
        $serviceCategories = ServiceCategory::with('serviceDetails')->where('status', 'active')->get();
          $projects = Project::latest()->get();
    $categories = $projects->pluck('project_category_name')->unique();
    $testimonials = Testimonial::where('status', 'active')->get();
       $seos = Seo::where('page_type', 'service')->first();
        return view('front.service' , compact('serviceCategories', 'projects', 'categories', 'testimonials', 'seos'));
    }

public function servicedetail($slug)
{
    $category = ServiceCategory::with('serviceDetails')->where('slug', $slug)->firstOrFail();

    $firstService = $category->serviceDetails->first();
    $seos = $firstService
        ? Seo::where('service_id', $firstService->id)->first()
        : null;

    return view('front.servicedetail', [
        'service' => $category,
        'firstService' => $firstService,
        'seos' => $seos,
    ]);
}



    // public function team(){
    //     return view('front.team');
    // }

    // public function testimonial(){
    //     return view('front.testimonial');
    // }

    public function contact(){
        $seos = Seo::where('page_type', 'contact')->first();
        return view('front.contact', compact('seos'));
    }

    public function notFound(){
        return view('front.404');
    }
    public function project(){
        $projects = Project::latest()->get();

    // Extract unique categories for filters
    $categories = $projects->pluck('project_category_name')->unique();
        $seos = Seo::where('page_type', 'project')->first();
        return view('front.project' , compact('projects', 'categories', 'seos'));

    }

public function blog()
{
    $blogs = Blog::with('category')->latest()->paginate(6); // pagination added
    $seos = Seo::where('page_type', 'blog')->first();
    return view('front.blog', compact('blogs', 'seos'));
}

public function blogdetail($slug)
{
    $blog = Blog::with('category')->where('slug', $slug)->firstOrFail();
    $seos = Seo::where('blog_id', $blog->id)->first();
    return view('front.blogdetail', compact('blog', 'seos'));
}



    public function privacy(){
        $seos = Seo::where('page_type', 'privacy_policy')->first();
        return view('front.privacy', compact('seos'));
    }

    public function term(){
        $seos = Seo::where('page_type', 'term_and_condition')->first();
        return view('front.term', compact('seos'));
    }

    public function refund_policy(){
        $seos = Seo::where('page_type', 'refund_policy')->first();
        return view('front.refund_policy', compact('seos'));
    }

    public function career(){
        $seos = Seo::where('page_type', 'career')->first();
         $jobs = Career::where('status', 'active')->orderBy('valid_through', 'desc')->get();
        return view('front.carrer', compact('seos', 'jobs'));
    }


     public function packages(){
        $seos = Seo::where('page_type', 'packages')->first();
        $packages = Package::where('status', 'active')->get();
        return view('front.packages', compact('seos', 'packages'));
    }

    public function packagesDetails($package){
        $package = Package::with([
            'media' => fn($q) => $q->where('status','active')->orderBy('created_at','desc'),
            'faqs'  => fn($q) => $q->where('status','active')->orderBy('created_at','desc'),
        ])
        ->where('status','active')
        ->findOrFail($package);
        $seos = Seo::where('page_type', 'packages')->first();
        return view('front.packages_details', compact('seos', 'package'));
    }

    public function application(){
        return view('front.application');
    }
}
