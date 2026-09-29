<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::home')->name('home');
Route::livewire('/gumikereso', 'pages::tire')->name('filter');
Route::livewire('/kosar', 'pages::cart')->name('cart');
Route::livewire('/adatellenorzes', 'pages::shipping-and-billing-check')->name('dataCheck');
Route::livewire('/szallitas-es-fizetes', 'pages::payment')->name('pymentAndShipping');
Route::livewire('/osszegzes', 'pages::checkout')->name('checkout');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
