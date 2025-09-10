<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogCategoryControlloer;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DirectMessageController;
use App\Http\Controllers\DmAccessController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PackageFaqController;
use App\Http\Controllers\PackageMediaController;
use App\Http\Controllers\PaymentLinkController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\ServiceDetailsController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Database\Query\IndexHint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;





Route::get('/packages/{package}/buy', [CheckoutController::class,'show'])->name('packages.buy');
Route::get('/packages/details/{package}', [HomeController::class, 'packagesDetails'])->name('packages.details');
Route::post('/checkout/order',  [CheckoutController::class,'createOrder'])->name('checkout.order');
Route::post('/checkout/verify', [CheckoutController::class,'verify'])->name('checkout.verify');


Route::prefix('paylink')->name('paylink.')->group(function () {
    Route::get('/', [PaymentLinkController::class, 'index'])->name('index');
    Route::get('/create', [PaymentLinkController::class, 'create'])->name('create');
    Route::post('/', [PaymentLinkController::class, 'store'])->name('store');
    Route::get('/{paymentLink}/edit', [PaymentLinkController::class, 'edit'])->name('edit');
    Route::put('/{paymentLink}', [PaymentLinkController::class, 'update'])->name('update');
    Route::get('/{paymentLink}', [PaymentLinkController::class, 'destroy'])->name('destroy');
});

// routes/web.php
Route::post('/pay/verify', [PaymentLinkController::class,'verifyAjax'])
    ->name('paylink.verify');

// 2) Then the token-based routes (add constraints)
Route::get('/pay/{token}', [PaymentLinkController::class,'phoneForm'])
    ->where('token', '^(?!verify$)[A-Za-z0-9_-]{20,64}$')   // disallow "verify"
    ->name('paylink.phone');

Route::post('/pay/{token}/check', [PaymentLinkController::class,'checkPhone'])
    ->where('token', '^(?!verify$)[A-Za-z0-9_-]{20,64}$')
    ->name('paylink.check');

Route::post('/pay/{token}', [PaymentLinkController::class,'initiate'])
    ->where('token', '^(?!verify$)[A-Za-z0-9_-]{20,64}$')
    ->name('paylink.initiate');

Route::get('/payment-page/thank-you', [PaymentLinkController::class,'thankyoupage'])->name('paylink.thankyou');


// Simple static view route
Route::view('/thank-you', 'front.thankyou')->name('thankyou');

// frontend routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/service', [HomeController::class, 'service'])->name('service');
Route::get('/packages', [HomeController::class, 'packages'])->name('packages');
// Route::get('/team', [HomeController::class, 'team'])->name('team');
// Route::get('/testimonial', [HomeController::class, 'testimonial'])->name('testimonial');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/404', [HomeController::class, 'notFound'])->name('404');
Route::get('/project', [HomeController::class, 'project'])->name('project');
Route::get('/blogs', [HomeController::class, 'blog'])->name('blog');
Route::get('/blogdetail/{slug}', [HomeController::class, 'blogdetail'])->name('blogdetail');
Route::get('/services/{slug}', [HomeController::class, 'servicedetail'])->name('servicedetail');
Route::get('/privacy-policy', [HomeController::class, 'privacy'])->name('privacy-policy');
Route::get('/terms-and-conditions', [HomeController::class, 'term'])->name('term');
Route::get('/cancellation-refund-policy', [HomeController::class, 'refund_policy'])->name('refund_policy');
Route::get('/career', [HomeController::class, 'career'])->name('career');

Route::get('/application', [HomeController::class, 'application'])->name('application');
Route::post('/application/store', [\App\Http\Controllers\JobApplicationController::class, 'store'])->name('application.store');

Route::post('/contact/store', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

// SITEMAPS URLS
Route::get('/sitemap.xml', function(){
    return response()->view('sitemap')->header('Content-Type', 'application/xml');
});

Route::get('/blog-sitemap.xml', function(){
    return response()->view('blog-sitemap')->header('Content-Type', 'application/xml');
});






// DAshboard route

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth','verified'])->name('dashboard');


// Route::middleware('auth')->group(function () {
//     Route::get('/dm/{user}',  [DirectMessageController::class, 'show'])->name('dm.show');
//     Route::post('/dm/{user}', [DirectMessageController::class, 'store'])->name('dm.store');
// });

Route::middleware(['auth','role:Super Admin'])->group(function () {
  Route::get('/admin/users/{user}/dm-access', [DmAccessController::class,'edit'])->name('admin.dm.edit');
  Route::post('/admin/users/{user}/dm-access', [DmAccessController::class,'update'])->name('admin.dm.update');
  // NEW: people directory to start a chat with anyone
    
});


Route::get('/admin/purchases', [CheckoutController::class, 'index'])->name('purchases.index');
Route::get('/admin/purchases/{po}', [CheckoutController::class, 'showed'])->name('purchases.show');



Route::middleware('auth')->group(function () {
    Route::get('/dm/{user}',  [DirectMessageController::class, 'show'])->name('dm.show');
    Route::post('/dm/{user}', [DirectMessageController::class, 'store'])->name('dm.store');
    // NEW: people directory to start a chat with anyone

     Route::get('/people', [DmAccessController::class, 'index'])
        ->middleware('permission:chat-anyone')
        ->name('dm.people');

          Route::get('/messages', [DirectMessageController::class, 'index'])->name('dm.inbox'); // for everyone

    Route::get('/support-chat', function () {
        $adminId = (int) env('CHAT_SUPER_ADMIN_ID', 1);
        $admin   = User::findOrFail($adminId);
        return redirect()->route('dm.show', $admin->id);
    })->name('dm.admin');
});

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


Route::prefix('team')->group(function () {
    Route::get('/', [TeamController::class, 'index'])->name('team.index');
    Route::post('/store', [TeamController::class, 'store'])->name('team.store');
    Route::post('/update/{id}', [TeamController::class, 'update'])->name('team.update');
    Route::get('/delete/{id}', [TeamController::class, 'destroy'])->name('team.delete');
});


 Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
    Route::post('/testimonials/store', [TestimonialController::class, 'store'])->name('testimonials.store');
    Route::post('/testimonials/update/{testimonial}', [TestimonialController::class, 'update'])->name('testimonials.update');
    Route::get('/testimonials/delete/{testimonial}', [TestimonialController::class, 'destroy'])->name('testimonials.delete');
});


Route::prefix('product')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('product.index');
    Route::post('/store', [ProductController::class, 'store'])->name('product.store');
    Route::post('/update/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
});

Route::prefix('blog-category')->group(function () {
    Route::get('/', [BlogCategoryController::class, 'index'])->name('blog-category.index');
    Route::post('/store', [BlogCategoryController::class, 'store'])->name('blog-category.store');
    Route::post('/update/{id}', [BlogCategoryController::class, 'update'])->name('blog-category.update');
    Route::get('/delete/{id}', [BlogCategoryController::class, 'delete'])->name('blog-category.delete');
});

Route::prefix('blog')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('blog.index');
    Route::post('/store', [BlogController::class, 'store'])->name('blog.store');
    Route::post('/update/{id}', [BlogController::class, 'update'])->name('blog.update');
    Route::get('/delete/{id}', [BlogController::class, 'delete'])->name('blog.delete');
});

Route::get('/contact/index', [App\Http\Controllers\ContactController::class, 'index'])->name('contact.index');
Route::get('/contact/delete/{id}', [App\Http\Controllers\ContactController::class, 'destroy'])->name('contact.delete');


// SEO Routes
Route::get('seo/index', [SeoController::class, 'index'])->name('seo.index');
Route::get('seo/create', [SeoController::class, 'create'])->name('seo.create');
Route::post('seo/store', [SeoController::class, 'store'])->name('seo.store');
Route::get('seo/edit/{seo}', [SeoController::class, 'edit'])->name('seo.edit');
Route::post('seo/update/{seo}', [SeoController::class, 'update'])->name('seo.update');
Route::get('seo/delete/{seo}', [SeoController::class, 'delete'])->name('seo.delete');

// Career Routes
Route::get('career/index', [CareerController::class, 'index'])->name('careers.index');
Route::get('career/create', [CareerController::class, 'create'])->name('careers.create');
Route::post('career/store', [CareerController::class, 'store'])->name('careers.store');
Route::get('career/edit/{career}', [CareerController::class, 'edit'])->name('careers.edit');
Route::post('career/update/{career}', [CareerController::class, 'update'])->name('careers.update');
Route::get('career/delete/{career}', [CareerController::class, 'destroy'])->name('careers.delete');


Route::controller(\App\Http\Controllers\JobApplicationController::class)->name('applications.')->prefix('applications')->group(function(){
   Route::get('/', 'index')->name('index');
   Route::get('show/{application}', 'show')->name('show');
   Route::post('delete/{application}', 'delete')->name('delete');
});

//paclkage routes

Route::prefix('package')->group(function () {
    Route::get('/', [PackageController::class, 'index'])->name('package.index');
    Route::get('/create', [PackageController::class, 'create'])->name('package.create');
    Route::post('/store', [PackageController::class, 'store'])->name('package.store');
    Route::get('/edit/{package}', [PackageController::class, 'edit'])->name('package.edit');
    Route::post('/update/{package}', [PackageController::class, 'update'])->name('package.update');
    Route::get('/delete/{package}', [PackageController::class, 'delete'])->name('package.delete');
    Route::get('/{package}', [PackageController::class, 'show'])->name('packageshow');
});



Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('package-media', [PackageMediaController::class, 'index'])->name('package_media.index');
    Route::get('package-media/create', [PackageMediaController::class, 'create'])->name('package_media.create');
    Route::post('package-media', [PackageMediaController::class, 'store'])->name('package_media.store');
    Route::get('package-media/{packageMedium}/edit', [PackageMediaController::class, 'edit'])->name('package_media.edit');
    Route::put('package-media/{packageMedium}', [PackageMediaController::class, 'update'])->name('package_media.update');
    Route::delete('package-media/{packageMedium}', [PackageMediaController::class, 'destroy'])->name('package_media.destroy');

});


Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('package-faqs',                 [PackageFaqController::class, 'index'])->name('package_faqs.index');
    Route::get('package-faqs/create',          [PackageFaqController::class, 'create'])->name('package_faqs.create');
    Route::post('package-faqs',                [PackageFaqController::class, 'store'])->name('package_faqs.store');
    Route::get('package-faqs/{packageFaq}/edit',[PackageFaqController::class, 'edit'])->name('package_faqs.edit');
    Route::put('package-faqs/{packageFaq}',    [PackageFaqController::class, 'update'])->name('package_faqs.update');
    Route::delete('package-faqs/{packageFaq}', [PackageFaqController::class, 'destroy'])->name('package_faqs.destroy');
});

require __DIR__.'/auth.php';
