<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});




























































// $rules = array(
//     "name" => "required",
//     "email" => "required",
//     "phone" => "required",
//     "email" => "required",
//     "password" => "required",
//     'roles' => 'required|array',
//     'roles.*' => 'exists:roles,id'
// );
// $validator = Validator::make($request->all(), $rules);
// if ($validator->fails()) {
//     return $validator->errors();
// }

