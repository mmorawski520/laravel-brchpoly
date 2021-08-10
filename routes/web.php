<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\BoardsController;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\PlayersActionsController;

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
Route::get('lang/change', [LangController::class, 'change'])->name('changeLang');
Route::get('/', function () {
    return view('welcome');
});

Route::get('about', function () {
    return view('about');
})->name("about");
Route::get('contact', function () {
    return view('contact');
})->name("contact");
Route::post('/players/create/', [App\Http\Controllers\PlayersController::class, 'store'])
    ->name('store')
    ->middleware("auth");

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home')
    ->middleware("auth");

Auth::routes();

//--- General Routes
Route::resource('/boards', BoardsController::class)->middleware("auth");
Route::resource('/boards', BoardsController::class)->middleware("auth");
Route::resource('/players', PlayersController::class)->middleware("auth");
Route::resource('/boards', BoardsController::class)->middleware("auth", [App\Http\Controllers\PlayersActionsController::class, 'index']);

Route::get('settings/index', function () {
    return view('settings.index');
})->middleware("auth")->name("settingsPanel");
Route::get('settings/change', function () {
    return view('settings.change');
})->middleware("auth")->name("settingsChange");
Route::get('settings/deleteForm', function () {
    return view('settings.deleteForm');
})->middleware("auth")->name("deleteForm");

Route::resource('/players_actions', PlayersActionsController::class)->middleware("auth");
Route::prefix('/boards/')->group(function () {

    Route::get('players_actions/{id}/board_id/{board_id}/task/{task}', [App\Http\Controllers\PlayersActionsController::class, 'index'])
        ->name('action')->middleware("auth");

    Route::get('players_actions/edit/{id}', [App\Http\Controllers\PlayersActionsController::class, 'edit'])
        ->name("editAction")->middleware("auth");

    Route::get('players_actions/updateAction/{id}', [App\Http\Controllers\PlayersActionsController::class, 'updateAction'])
        ->name("updateAction")->middleware("auth");

    Route::get('currentBoard/{id}', [App\Http\Controllers\BoardsController::class, 'currentBoard'])
        ->name('currentBoard')->middleware("auth");

    Route::get('currentBoard/reset/{id}', [App\Http\Controllers\BoardsController::class, 'reset'])
        ->name('resetBoard')->middleware("auth");

    Route::get('currentBoard/receive/{id}', [App\Http\Controllers\PlayersController::class, 'receive'])
        ->name('receive')->middleware("auth");

    Route::get('currentBoard/receivePanel/{id}', [App\Http\Controllers\PlayersController::class, 'receivePanel'])
        ->name('receivePanel')->middleware("auth");

    Route::get('currentBoard/receiveFromAll/{id}', [App\Http\Controllers\PlayersController::class, 'receiveFromAll'])
        ->name('receiveFromAll')->middleware("auth");

    Route::get('currentBoard/receiveFromAllStore/{id}', [App\Http\Controllers\PlayersController::class, 'receiveFromAllStore'])
        ->name('receiveFromAllStore')->middleware("auth");

    Route::get('edit/{id}', [App\Http\Controllers\BoardsController::class, "edit"])->name("edit")->middleware("auth");
    //--- Players actions in selected board
    Route::prefix('currentBoard/')->group(function () {
        Route::get('receiveStore/{id}', [App\Http\Controllers\PlayersController::class, 'receiveStore'])
            ->name('receiveStore')
            ->middleware("auth");
        Route::get('send/{id}', [App\Http\Controllers\PlayersController::class, 'send'])
            ->name('send')
            ->middleware("auth");
        Route::get('sendBank/{id}', [App\Http\Controllers\PlayersController::class, 'sendBank'])
            ->name('sendBank')
            ->middleware("auth");
        Route::get('sendToEveryone/{id}', [App\Http\Controllers\PlayersController::class, 'sendToEveryone'])
            ->name('sendToEveryone')
            ->middleware("auth");
        Route::get('sendToEveryoneStore/{id}', [App\Http\Controllers\PlayersController::class, 'sendToEveryoneStore'])
            ->name('sendToEveryoneStore')
            ->middleware("auth");
        Route::get('sendBankStore/{id}', [App\Http\Controllers\PlayersController::class, 'sendBankStore'])
            ->name('sendBankStore')->middleware("auth");
        Route::get('sendToAnotherPlayer/{id}', [App\Http\Controllers\PlayersController::class, 'sendToAnotherPlayer'])
            ->name('sendToAnotherPlayer')
            ->middleware("auth");
        Route::get('sendToAnotherPlayerStore/{id}', [App\Http\Controllers\PlayersController::class, 'sendToAnotherPlayerStore'])
            ->name('sendToAnotherPlayerStore')
            ->middleware("auth");
        Route::post('update', [App\Http\Controllers\BoardsController::class, "update"])
            ->name("update")
            ->middleware("auth");
        Route::get('salary/{id}', [App\Http\Controllers\PlayersController::class, 'salary'])
            ->name('salary')
            ->middleware("auth");
    });
});

//--- settings routes
Route::prefix('settings')->group(function () {
    Route::post('/settingsStore', [App\Http\Controllers\SettingsController::class, 'store'])
        ->name('settingsStore')
        ->middleware("auth");
    Route::post("", [App\Http\Controllers\SettingsController::class, 'deleteAccountStore'])
        ->name('deleteAccountStore');
});
