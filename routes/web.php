<?php

use App\Models\Faculty;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Livewire\FormPetition;
use App\Http\Livewire\MakePetition;

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


Route::redirect('/', 'login');

Route::group(['middleware' => ['web', 'guest'], 'namespace' => 'App\Http\Controllers\Auth'], function () {
    Route::get('login', 'AuthController@login')->name('login');
    Route::get('connect', 'AuthController@connect')->name('connect');
});

Route::group([
    'middleware' => ['web', 'MsGraphAuthenticated','checkFacultyId'],
    'prefix' => 'app',
    'namespace' => 'App\Http\Controllers',
    'namespace' => 'App\Http\Livewire',
], function () {
    Route::prefix('petition')->group(function () {

        // Ruta para mostrar el formulario de creación de la petición
        Route::get('/petition-make', MakePetitionController::class)->name('petition-make');
        Route::get('/petition-form/{petition}', FormPetition::class)->name('petition-form');

        // Ruta para procesar el envío del formulario de creación de la petición
        // Route::post('do-petition', [PetitionController::class, 'store'])->name('petition.store');

        Route::get('/petition-list', ListPetitionController::class)->name('petition-list');
    });

    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/user', UserController::class)->name('user');
        Route::get('/faculty', FacultyController::class)->name('faculty');
        Route::prefix('setting')->group(function () {
            // Ruta para mostrar el formulario de creación de la petición
            Route::get('/setting-make-petition', PetitionController::class)->name('setting-make-petition');
            // Ruta para procesar el envío del formulario de creación de la petición
            // Route::post('do-petition', [PetitionController::class, 'store'])->name('petition.store');
        });
    });

    Route::group(['middleware' => ['role:admin|commission']], function () {

        Route::get('/course', AreaKnowledgeController::class)->name('course');
        Route::get('/configuration', ConfigurationController::class)->name('configuration');
        Route::get('/curricula', ShowCurricula::class)->name('curriculas');
        Route::get('/petition_process_list', PetitionProcess::class)->name('petition_process_list');
        Route::get('/petition_process_make/{petition}', MakePetition::class)->name('petition_process_make');
    });
    //   Route::get('/make-petition', PetitionController::class)->name('petition');
    Route::get('/dashboard',  Home::class)->name('app');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout'); //se modifico a post
    Route::get('/', Home::class)->name('home');
});
