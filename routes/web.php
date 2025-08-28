<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/birthdays', function () { return view('pages.birthdays.index'); });
