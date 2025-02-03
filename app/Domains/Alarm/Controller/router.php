<?php declare(strict_types=1);

namespace App\Domains\Alarm\Controller;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Route::group(['middleware' => ['user-auth']], static function () {
    Route::get('/test', function (Request $request) {
        $public_ip = file_get_contents('https://api64.ipify.org?format=json');
    $public_ip = json_decode($public_ip)->ip;
    echo $public_ip;
    dd($public_ip);
    
        Log::alert($request->all());
        return response()->json($request->all());
    });
    Route::get('/alarm', Index::class)->name('alarm.index');
    Route::any('/alarm/create', Create::class)->name('alarm.create');
    Route::any('/alarm/{id}', Update::class)->name('alarm.update');
    Route::any('/alarm/{id}/alarm-notification', UpdateAlarmNotification::class)->name('alarm.update.alarm-notification');
    Route::any('/alarm/{id}/vehicle', UpdateVehicle::class)->name('alarm.update.vehicle');
    Route::any('/alarm/{id}/boolean/{column}', UpdateBoolean::class)->name('alarm.update.boolean');
});
