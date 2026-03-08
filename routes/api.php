<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwilioController;

Route::post('/twilio/status-callback', [TwilioController::class, 'statusCallback']);