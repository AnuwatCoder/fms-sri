<?php

use App\Http\Controllers\Admin\AboutPageController;
use App\Http\Controllers\Admin\AboutResponsibilityController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsItemController;
use App\Http\Controllers\Admin\PersonnelController;
use App\Http\Controllers\Admin\PortalDocumentController;
use App\Http\Controllers\Admin\PortalEventController;
use App\Http\Controllers\Admin\PortalSystemController;
use App\Http\Controllers\Admin\SeoSettingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortalPageController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/search', SearchController::class)->name('search.index');
Route::get('/systems', [PortalPageController::class, 'systems'])->name('systems.index');
Route::get('/news', [PortalPageController::class, 'news'])->name('news.index');
Route::get('/news/{newsItem}', [PortalPageController::class, 'showNews'])->name('news.show');
Route::get('/documents', [PortalPageController::class, 'documents'])->name('documents.index');
Route::get('/about', [PortalPageController::class, 'about'])->name('about');
Route::get('/contact', [PortalPageController::class, 'contact'])->name('contact');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'create'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'store'])->name('login.store');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');
        Route::resource('systems', PortalSystemController::class)->except('show');
        Route::resource('news', NewsItemController::class)->parameters(['news' => 'newsItem'])->except('show');
        Route::resource('events', PortalEventController::class)->except('show');
        Route::resource('documents', PortalDocumentController::class)->except('show');
        Route::get('seo', [SeoSettingController::class, 'edit'])->name('seo.edit');
        Route::put('seo', [SeoSettingController::class, 'update'])->name('seo.update');
        Route::get('about', [AboutPageController::class, 'edit'])->name('about.edit');
        Route::put('about', [AboutPageController::class, 'update'])->name('about.update');
        Route::resource('about/responsibilities', AboutResponsibilityController::class)
            ->except('show')
            ->names('about.responsibilities');
        Route::resource('about/personnel', PersonnelController::class)
            ->except('show')
            ->parameters(['personnel' => 'person'])
            ->names('about.personnel');
    });
});
