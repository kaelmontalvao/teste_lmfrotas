<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ProductFilter;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', ProductFilter::class);
