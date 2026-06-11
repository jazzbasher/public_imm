<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NBDController;
use App\Http\Controllers\AdminNBDController;
use App\Http\Controllers\Admin\UserController;

Auth::routes(['register' => false]);


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');

    Route::get('/admin/nbd/dashboard', [AdminNBDController::class, 'nbddashboard'])->name('admin.nbd.dashboard');

    Route::get('/admin/ndb/sales/{id}', [AdminNBDController::class, 'usersales'])->name('sales.user');

    Route::post('/admin/destroylead', [NBDController::class, 'sdeletelead'])->name('admin.sdelete.lead');

    Route::post('/admin/destroyopportunity', [NBDController::class, 'sdeleteopp'])->name('admin.sdelete.opp');

    Route::post('/admin/destroyjointcall', [NBDController::class, 'sdeletecall'])->name('admin.sdelete.call');

    Route::post('/admin/destroyconversion', [NBDController::class, 'sdeleteconversion'])->name('admin.sdelete.conversion');

    Route::post('/admin/destroypipeline', [NBDController::class, 'sdeletepipeline'])->name('admin.sdelete.pipeline');

});


Route::middleware(['auth'])->group(function () {
Route::get('/', function () {
    return redirect('nbd/newleads');
});

// Route::get('/nbd', [NBDController::class, 'index'])->name('nbd');

// Route::resource('nbd', NBDController::class);

Route::get('nbd/newleads', [NBDController::class, 'newleads'])->name('nbd.newleads');

Route::get('nbd/newleads/create', [NBDController::class, 'createnewlead'])->name('nbd.create.createlead');

Route::post('nbd/newleads/store', [NBDController::class, 'storelead'])->name('nbd.storelead');

Route::get('nbd/newleads/edit/{id}', [NBDController::class, 'editnewlead'])->name('edit.newlead');

Route::post('nbd/editleads/store{id}', [NBDController::class, 'updatelead'])->name('edit.updatelead');



Route::get('nbd/newopportunities', [NBDController::class, 'newopportunities'])->name('nbd.newopportunities');

Route::get('nbd/newopportunities/create', [NBDController::class, 'createnewopportunity'])->name('nbd.create.createopportunity');

Route::post('nbd/newopportunity/store', [NBDController::class, 'storeopportunity'])->name('nbd.storeopportunity');

Route::get('nbd/newopportunities/edit/{id}', [NBDController::class, 'editopportunity'])->name('edit.opportunity');

Route::post('nbd/editopportunity/store{id}', [NBDController::class, 'updateopportunity'])->name('edit.updateopportunity');




Route::get('nbd/jointcalls', [NBDController::class, 'jointcalls'])->name('nbd.jointcalls');

Route::get('nbd/jointcalls/create', [NBDController::class, 'createnewjointcall'])->name('nbd.create.createjointcall');

Route::post('nbd/jointcalls/store', [NBDController::class, 'storejointcall'])->name('nbd.storejointcall');

Route::get('nbd/jointcalls/edit/{id}', [NBDController::class, 'editjointcall'])->name('edit.jointcall');

Route::post('nbd/editjointcalls/store{id}', [NBDController::class, 'updatejointcall'])->name('edit.updatejointcall');





Route::get('nbd/conversions', [NBDController::class, 'conversions'])->name('nbd.conversions');

Route::get('nbd/conversions/create', [NBDController::class, 'createnewconversion'])->name('nbd.create.createconversion');

Route::post('nbd/conversions/store', [NBDController::class, 'storeconversion'])->name('nbd.storeconversion');

Route::get('nbd/conversions/edit/{id}', [NBDController::class, 'editconversion'])->name('edit.conversion');

Route::post('nbd/editconversions/store{id}', [NBDController::class, 'updateconversion'])->name('edit.updateconversion');


Route::get('nbd/currentpromo', [NBDController::class, 'currentpromo'])->name('nbd.currentpromo');

Route::get('nbd/currentpromo/create', [NBDController::class, 'createnewpromo'])->name('nbd.create.createpromo');

Route::post('nbd/currentpromo/store', [NBDController::class, 'storepromo'])->name('nbd.storepromo');



Route::get('nbd/vendingpipeline', [NBDController::class, 'vendingpipeline'])->name('nbd.vendingpipeline');

Route::get('nbd/vendingpipeline/create', [NBDController::class, 'createnewpipeline'])->name('nbd.create.createpipeline');

Route::post('nbd/vendingpipeline/store', [NBDController::class, 'storepipeline'])->name('nbd.storepipeline');

Route::get('nbd/vendingpipeline/edit/{id}', [NBDController::class, 'editpipeline'])->name('edit.pipeline');

Route::post('nbd/editpipelines/store{id}', [NBDController::class, 'updatepipeline'])->name('edit.updatepipeline');


// Route::get('nbd/create', [NBDController::class, 'create'])->name('nbd.create');



// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});