<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/agenda/agenda', 'AgendaController@index')->name('agenda.index');
Route::get('/agenda/modal', 'AgendaController@AbrirModal')->name('agenda.modal');
Route::post('/agenda/SalvarAgenda', 'AgendaController@SalvarAgenda')->name('agenda.savaragenda');
Route::get('/agenda/PopulaHora/', 'AgendaController@PopulaHora')->name('agenda.populahora');
Route::get('/agenda/PopulaProfissional/', 'AgendaController@PopulaProfissional')->name('agenda.PopulaProfissional');
Route::get('/agenda/ExcluiAgenda/', 'AgendaController@ExcluiAgenda')->name('agenda.deletar');
Route::get('/agenda/listaAgenda/', 'ListaAgendaController@index')->name('agenda.index');
Route::get('/agenda/getData/', 'ListaAgendaController@getData')->name('agenda.getData');