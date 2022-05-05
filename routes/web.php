<?php

use Illuminate\Support\Facades\Route;
use Helaplus\Laravelmifos\Http\MpesaController;

Route::post('/mpesa/stkReceiver', [MpesaController::class, 'stkReceiver'])->name('mpesa.stkReceiver');
Route::post('/mpesa/c2bReceiver', [MpesaController::class, 'c2bReceiver'])->name('mpesa.c2bReceiver');