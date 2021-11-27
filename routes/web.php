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
Route::get('/agenda/todosAgendamentos', 'AgendaController@visualizarTodosAgendamentos')->name('agenda.VisualizarTodos');
Route::get('/agenda/todosAgendamentosFiltro', 'AgendaController@VisualizarTodosFiltros')->name('agenda.VisualizarFiltro');
Route::get('/agenda/modal', 'AgendaController@AbrirModal')->name('agenda.modal');
Route::post('/agenda/SalvarAgenda', 'AgendaController@SalvarAgenda')->name('agenda.savaragenda');
Route::get('/agenda/PopulaHora/', 'AgendaController@PopulaHora')->name('agenda.populahora');
Route::get('/agenda/PopulaProfissional/', 'AgendaController@PopulaProfissional')->name('agenda.PopulaProfissional');
Route::get('/agenda/ExcluiAgenda/', 'AgendaController@ExcluiAgenda')->name('agenda.deletar');
Route::get('/agenda/listaAgenda/', 'ListaAgendaController@index')->name('agenda.index');
Route::get('/profissional/Profissional', 'ProfissionalController@index')->name('agenda.Profissional');
Route::get('/profissional/AdicionarProfissional', 'ProfissionalController@adicionar')->name('profissional.adicionar');
Route::post('/profissional/AdicionarProfissional', 'ProfissionalController@salvar')->name('profissional.salvar');
Route::get('/servico/AdicionarServico', 'ServicoController@adicionar')->name('servico.adicionar');
Route::post('/servico/AdicionarServico', 'ServicoController@salvar')->name('servico.salvar');
Route::post('/hora/SalvarHora', 'HoraController@SalvarHora')->name('hora.salvar');
Route::get('/hora/AdicionarHora', 'HoraController@index')->name('hora.index');
