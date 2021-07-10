<?php

Route::get('/', [App\Http\Controllers\HomeController::class, 'welcome'])->name('index');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
