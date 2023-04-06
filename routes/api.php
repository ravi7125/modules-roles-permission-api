<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModulesController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ModulePermissionController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRolesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\EmployeeController;
use App\Http\Middleware\Webguard;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Auth route
Route::controller(AuthController::class)->prefix('auth')->group(function(){
        Route::post("register", 'add');
        Route::post('login', 'login');
     
        Route::post('password/email', 'sendresetlinkemail')->middleware('auth:sanctum');

        Route::post('/forgotPasswordLink', 'forgotPasswordLink');
        Route::post('/forgotPassword', 'forgotPassword');
});
/*
 *This is a protected route that requires authentication.
 *Only authenticated users can access this route.
*/
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::controller(UserController::class)->prefix('user')->group(function () {
        Route::get ("view", 'view');
        Route::delete("delete/{id}", 'Delete');
        Route::put("update/{id}", 'update');
        Route::post('logout', 'logout');
        Route::post('changepassword', 'changepassword');
        Route::post("list", 'list');
    });
        //job route
    Route::controller(JobController::class)->prefix('job')->group(function(){
        Route::post("create",'add')->middleware('Webguard:job,add_access');
        Route::get("view",'view')->middleware('Webguard:job,view_access');
        Route::put("update",'update')->middleware('Webguard:job,edit_access');
        Route::delete("delete/{id}",'Delete')->middleware('Webguard:job,delete_access');
    });

    //Employee route
    Route::controller(EmployeeController::class)->prefix('employee')->group(function(){
        Route::post("create",'add')->middleware('Webguard:employee,add_access');
        Route::get("view",'view')->middleware('Webguard:employee,view_access');
        Route::put("update/{id}",'update')->middleware('Webguard:employee,edit_access');
        Route::delete("delete/{id}",'Delete')->middleware('Webguard:employee,delete_access');
});
});

//Module Route.
    Route::controller(ModulesController::class)->prefix('modules')->group(function(){
        Route::post("list",'list');
        Route::post("create",'add');
        Route::get("view",'view');
        Route::delete("delete/{id}",'Delete');
        Route::put("update/{id}",'update');
    });

// Permission Route.
    Route::controller(PermissionController::class)->prefix('permission')->group(function () {
        Route::post("create",'add');
        Route::get("view/{id?}",'view');
        Route::delete("delete/{id}",'Delete');
        Route::put("update/{id}",'update');
        Route::post("list",'list');
    });

//Role route
    Route::controller(RoleController::class)->prefix('role')->group(function () {
        Route::post("create", 'add');
        Route::get("view/{id?}", 'view');
        Route::delete("delete/{id}", 'Delete');
        Route::put("update", 'update');
        Route::post("list", 'list');   
    });
        Route::get('role_permission',[RolePermissionController::class,'index']);
        Route::get('user_role',[UserRolesController::class,'data']);
//job listing route
    Route::controller(JobController::class)->prefix('job')->group(function(){
        Route::post("list",'list');
    
    });

   

