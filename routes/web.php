<?php

use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebsiteController::class, 'index'])->name('home');
foreach (['solutions', 'products', 'work', 'about', 'contact', 'privacy'] as $page) {
    Route::get('/'.$page, [WebsiteController::class, 'page'])->defaults('page', $page)->name($page);
}
Route::post('/inquiries', [WebsiteController::class, 'store'])->middleware('throttle:5,1')->name('inquiries.store');

Route::get('/sitemap.xml', [WebsiteController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [WebsiteController::class, 'robots'])->name('robots');

Route::get('/products/{slug}', [WebsiteController::class, 'product'])->name('products.show');
