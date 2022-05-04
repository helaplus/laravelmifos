<?php

use Illuminate\Support\Facades\Route;
use Helaplus\Laravelmifos\Http\MpesaController;

Route::post('/mpesa/c2bReceiver', [MpesaController::class, 'stkReceiver'])->name('mpesa.stkReceiver');