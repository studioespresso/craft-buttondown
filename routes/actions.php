<?php

use Illuminate\Support\Facades\Route;
use studioespresso\buttondown\controllers\SubscriberController;

// Front-end subscribe form: {{ actionInput('buttondown/subscriber') }}, `subscriber/add` kept for Craft 5 forms
Route::post('subscriber', SubscriberController::class);
Route::post('subscriber/add', SubscriberController::class);
