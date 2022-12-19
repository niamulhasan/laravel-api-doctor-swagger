<?php

use Illuminate\Support\Facades\Route;
use NiamulHasan\ApiDoctorSwagger\Controllers\ApiDoctorController;

Route::get('api-docs', [ApiDoctorController::class, 'index']);
Route::get('swagger-yaml-file-generated', [ApiDoctorController::class, 'yamlGenerated']);
