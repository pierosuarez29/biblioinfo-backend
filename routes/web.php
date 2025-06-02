<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

// Route::get('/', function () {
//     return "Hola Mundo";
// });

require __DIR__.'/auth.php';
