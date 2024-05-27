<?php

use App\Http\Controllers\ApplicationController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
   /* $user = User::create([
        'name' => 'Abbass',
        'email' => 'abbassmortazavi011@gmail.com',
        'password' => bcrypt('12345678'),
    ]);*/
    $user = User::query()->where('id', '=', 25)->first();
    $token = $user->createToken('Token Name')->accessToken;

    dd($token);
    return view('welcome');
});
//
//Route::get('/admin/dashboard', function (){
//    return view('dashboard');
//});

Route::get('{view}', ApplicationController::class)->where('view', '(.*)');
