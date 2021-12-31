<?php

use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Features\UserImpersonation;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::group([
//     'prefix' => '/{tenant}',
//     'middleware' => [InitializeTenancyByPath::class , 'auth'],
// ], function () {
//     Route::get('/', function () {
//         // dd('khalid');
//         // dd(User::all());

//         return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
//     });
// });
