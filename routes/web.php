<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{SiteController,AdminController};
Route::get('/',[SiteController::class,'home'])->name('home');
Route::get('/toalety/{product}',[SiteController::class,'product'])->name('product');
Route::post('/kontakt',[SiteController::class,'contact'])->middleware('throttle:5,1')->name('contact');
Route::view('/polityka-prywatnosci','site.privacy')->name('privacy');
Route::get('/sitemap.xml',function(){return response()->view('site.sitemap',['products'=>\App\Models\Product::where('active',true)->get()])->header('Content-Type','application/xml');});
Route::get('/robots.txt',fn()=>response("User-agent: *\nAllow: /\nDisallow: /admin\nSitemap: ".url('/sitemap.xml'))->header('Content-Type','text/plain'));
Route::middleware('guest')->group(function(){
 Route::view('/admin/login','admin.login')->name('login');
 Route::post('/admin/login',[AdminController::class,'login'])->middleware('throttle:5,1');
});
Route::middleware(['auth','admin'])->prefix('admin')->group(function(){
 Route::get('/',[AdminController::class,'index'])->name('admin');
 Route::post('/logout',[AdminController::class,'logout']);
 Route::get('/produkty/nowy',[AdminController::class,'create']);
 Route::post('/produkty',[AdminController::class,'store']);
 Route::get('/produkty/{product}',[AdminController::class,'edit']);
 Route::put('/produkty/{product}',[AdminController::class,'update']);
 Route::patch('/zapytania/{inquiry}',[AdminController::class,'inquiry']);
 Route::delete('/zapytania/{inquiry}',[AdminController::class,'deleteInquiry']);
 Route::put('/ustawienia',[AdminController::class,'settings']);
});
