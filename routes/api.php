<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(
    [
        'prefix' => 'note',
        'namespace' => 'App\Http\Controllers\Note',
        'middleware' => 'checkUser'
    ],
    function () {
        Route::get('/getAll', 'NoteController@index')->name('note.getAll');
        Route::get('/getOne/{noteId}', 'NoteController@get')->name('note.getOne');
        Route::post('/create', 'NoteController@create')->name('note.create');
        Route::post('/update/{noteId}', 'NoteController@update')->name('note.update');
        Route::get('/delete/{noteId}', 'NoteController@delete')->name('note.delete');
    });
