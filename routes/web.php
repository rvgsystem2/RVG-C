<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\ServiceDetailsController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;




// Route::get('/', function () {
//     return view('front.index');
// });
// Route::get('/contact', function () {
//     return view('front.contact');
// });


// frontend routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/service', [HomeController::class, 'service'])->name('service');
Route::get('/team', [HomeController::class, 'team'])->name('team');
Route::get('/testimonial', [HomeController::class, 'testimonial'])->name('testimonial');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/404', [HomeController::class, 'notFound'])->name('404');
Route::get('/project', [HomeController::class, 'project'])->name('project');
Route::get('/blog', [HomeController::class, 'blog'])->name('blog');
Route::get('/blogdetail', [HomeController::class, 'blogdetail'])->name('blogdetail');
Route::get('/service/{slug}', [HomeController::class, 'servicedetail'])->name('servicedetail');








// DAshboard route

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth','verified'])->name('dashboard');




// Routes that require authentication
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Permission Routes
    Route::get('permission/index',[PermissionController::class,'index'])->name('permission.index');
    Route::get('permission/create',[PermissionController::class,'create'])->name('permission.create');
    Route::post('permission/store',[PermissionController::class,'store'])->name('permission.store');
    Route::get('permission/edit/{permission}',[PermissionController::class,'edit'])->name('permission.edit');
    Route::post('permission/update/{permission}',[PermissionController::class,'update'])->name('permission.update');
    Route::get('permission/delete/{permission}',[PermissionController::class,'delete'])->name('permission.delete');

    // Role Routes
    Route::get('role/index',[RoleController::class,'index'])->name('role.index');
    Route::get('role/create',[RoleController::class,'create'])->name('role.create');
    Route::post('role/store',[RoleController::class,'store'])->name('role.store');
    Route::get('role/edit/{role}',[RoleController::class,'edit'])->name('role.edit');
    Route::post('role/update/{role}',[RoleController::class,'update'])->name('role.update');
    Route::get('role/delete/{role}',[RoleController::class,'delete'])->name('role.delete');

    // User Routes
    Route::get('user/index',[UserController::class,'index'])->name('user.index');
    Route::get('user/create',[UserController::class,'create'])->name('user.create');
    Route::post('user/store',[UserController::class,'store'])->name('user.store');
    Route::get('user/edit/{user}',[UserController::class,'edit'])->name('user.edit');
    Route::post('user/update/{user}',[UserController::class,'update'])->name('user.update');
    Route::get('user/delete/{user}',[UserController::class,'delete'])->name('user.delete');
    Route::get('/user/permissions/{user}', [UserController::class, 'assignPermissionForm'])->name('user.permission.form');
    Route::post('/user/permissions/{user}', [UserController::class, 'assignPermissionToUser'])->name('user.assign-permission');


   // banner routes
    Route::get('banner/index',[BannerController::class,'index'])->name('banner.index');
    Route::get('banner/create',[BannerController::class,'create'])->name('banner.create');
    Route::post('banner/store',[BannerController::class,'store'])->name('banner.store');
    Route::get('banner/edit/{banner}',[BannerController::class,'edit'])->name('banner.edit');
    Route::post('banner/update/{banner}',[BannerController::class,'update'])->name('banner.update');
    Route::get('banner/delete/{banner}',[BannerController::class,'delete'])->name('banner.delete');


    // About Routes
    Route::get('about/index', [App\Http\Controllers\AboutController::class, 'index'])->name('about.index');
    Route::get('about/create', [App\Http\Controllers\AboutController::class, 'create'])->name('about.create');
    Route::post('about/store', [App\Http\Controllers\AboutController::class, 'store'])->name('about.store');
    Route::post('about/update/{about}', [App\Http\Controllers\AboutController::class, 'update'])->name('about.update');
    Route::get('about/delete/{about}', [App\Http\Controllers\AboutController::class, 'delete'])->name('about.delete');

    Route::prefix('service-category')->group(function () {
    Route::get('/', [ServiceCategoryController::class, 'index'])->name('service-category.index');
    Route::post('/store', [ServiceCategoryController::class, 'store'])->name('service-category.store');
    Route::post('/update/{id}', [ServiceCategoryController::class, 'update'])->name('service-category.update');
    Route::get('/delete/{id}', [ServiceCategoryController::class, 'destroy'])->name('service-category.delete');
});


Route::prefix('service-detail')->group(function () {
    Route::get('/', [ServiceDetailsController::class, 'index'])->name('service-detail.index');
    Route::post('/store', [ServiceDetailsController::class, 'store'])->name('service-detail.store');
    Route::post('/update/{id}', [ServiceDetailsController::class, 'update'])->name('service-detail.update');
    Route::get('/delete/{id}', [ServiceDetailsController::class, 'destroy'])->name('service-detail.delete');
});




Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::post('/projects/store', [ProjectController::class, 'store'])->name('projects.store');
Route::post('/projects/update/{id}', [ProjectController::class, 'update'])->name('projects.update');
Route::post('/projects/delete/{id}', [ProjectController::class, 'delete'])->name('projects.delete');


});

require __DIR__.'/auth.php';
