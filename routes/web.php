<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Route::get('/test', function (Request $request) {
    $public_ip = file_get_contents('https://api64.ipify.org?format=json');
$public_ip = json_decode($public_ip)->ip;
echo $public_ip;
dd($public_ip);

    Log::alert($request->all());
    return response()->json($request->all());
});
