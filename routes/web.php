<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortalPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/systems', [PortalPageController::class, 'systems'])->name('systems.index');
Route::get('/news', [PortalPageController::class, 'news'])->name('news.index');
Route::get('/documents', [PortalPageController::class, 'documents'])->name('documents.index');
Route::get('/about', [PortalPageController::class, 'about'])->name('about');
Route::get('/contact', [PortalPageController::class, 'contact'])->name('contact');
