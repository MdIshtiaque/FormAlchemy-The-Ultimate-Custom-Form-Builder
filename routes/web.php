<?php

use App\Http\Controllers\Form\FormController;
use App\Http\Controllers\Form\RespondController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/form', [FormController::class, 'index'])->name('index.form');
    Route::post('/form', [FormController::class, 'topicStore'])->name('topic.store');
    Route::get('create-form/{topicId}', [FormController::class, 'createForm'])->name('create.form');
    Route::post('create-form/store', [FormController::class, 'storeForm'])->name('form.store');
    Route::get('form/{code}', [FormController::class, 'preview'])->name('preview.form');
    Route::post('/store', [FormController::class, 'formDataSave'])->name('formData.store');

    Route::get('responds/{uniqueId}', [RespondController::class, 'responds'])->name('responds');
    Route::get('respond/preview/{uniqueId}', [RespondController::class, 'previewRespond'])->name('preview.respond');

});

require __DIR__.'/auth.php';
