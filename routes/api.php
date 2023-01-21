<?php

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\SetsController;
use Illuminate\Support\Facades\Route;

Route::controller(CurrencyController::class)
	->prefix('currency')
	->group(function () {
		Route::get('/rates/{date?}', 'ratesByDate');
		Route::get('/{code}/{date?}', 'rateByDate');
	});

Route::controller(SetsController::class)
	->prefix('sets')
	->group(function () {
		Route::post('/', 'create');
		Route::post('/{id}', 'update');
		Route::get('/{id}/{date?}', 'get');
	});
