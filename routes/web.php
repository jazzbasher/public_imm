<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NBDController;

Auth::routes();

Route::middleware(['auth'])->group(function () {
Route::get('/', function () {
    return view('welcome');
});

// Route::get('/nbd', [NBDController::class, 'index'])->name('nbd');

// Route::resource('nbd', NBDController::class);

Route::get('nbd/newleads', [NBDController::class, 'newleads'])->name('nbd.newleads');

Route::get('nbd/newleads/create', [NBDController::class, 'createnewlead'])->name('nbd.create.createlead');

Route::post('nbd/newleads/store', [NBDController::class, 'storelead'])->name('nbd.storelead');

Route::get('nbd/newopportunities', [NBDController::class, 'newopportunities'])->name('nbd.newopportunities');

Route::get('nbd/newopportunities/create', [NBDController::class, 'createnewopportunity'])->name('nbd.create.createopportunity');

Route::post('nbd/newopportunity/store', [NBDController::class, 'storeopportunity'])->name('nbd.storeopportunity');

Route::get('nbd/jointcalls', [NBDController::class, 'jointcalls'])->name('nbd.jointcalls');

Route::get('nbd/jointcalls/create', [NBDController::class, 'createnewjointcall'])->name('nbd.create.createjointcall');

Route::post('nbd/jointcalls/store', [NBDController::class, 'storejointcall'])->name('nbd.storejointcall');

Route::get('nbd/conversions', [NBDController::class, 'conversions'])->name('nbd.conversions');

Route::get('nbd/conversions/create', [NBDController::class, 'createnewconversion'])->name('nbd.create.createconversion');

Route::post('nbd/conversions/store', [NBDController::class, 'storeconversion'])->name('nbd.storeconversion');

Route::get('nbd/currentpromo', [NBDController::class, 'currentpromo'])->name('nbd.currentpromo');

Route::get('nbd/currentpromo/create', [NBDController::class, 'createnewpromo'])->name('nbd.create.createpromo');

Route::post('nbd/currentpromo/store', [NBDController::class, 'storepromo'])->name('nbd.storepromo');

Route::get('nbd/vendingpipeline', [NBDController::class, 'vendingpipeline'])->name('nbd.vendingpipeline');

Route::get('nbd/vendingpipeline/create', [NBDController::class, 'createnewpipeline'])->name('nbd.create.createpipeline');

Route::post('nbd/vendingpipeline/store', [NBDController::class, 'storepipeline'])->name('nbd.storepipeline');

// Route::get('nbd/create', [NBDController::class, 'create'])->name('nbd.create');



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});