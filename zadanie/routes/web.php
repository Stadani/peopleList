<?php

use App\Http\Controllers\PeopleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/people', [PeopleController::class, 'index'])->name('index');


Route::delete('/people/{id}', [PeopleController::class, 'delete'])->name('delete');

Route::get('/people/{id}/edit', [PeopleController::class, 'edit'])->name('edit');
Route::put('/people/{id}', [PeopleController::class, 'update']);



