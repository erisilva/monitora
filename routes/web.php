<?php

use Illuminate\Support\Facades\Route;

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


// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['prefix' => 'admin','namespace' => 'Auth'],function(){
    // Authentication Routes...
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')->name('logout');
});

Route::get('/', 'HomeController@index')->name('home');

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('admin')->namespace('Admin')->group(function () {
	/*  Operadores */
	// nota mental :: as rotas extras devem ser declaradas antes de se declarar as rotas resources
    Route::get('/users/password', 'ChangePasswordController@showPasswordUpdateForm')->name('users.password');
	Route::put('/users/password/update', 'ChangePasswordController@passwordUpdate')->name('users.passwordupdate');
    Route::get('/users/export/csv', 'UserController@exportcsv')->name('users.export.csv');
	Route::get('/users/export/pdf', 'UserController@exportpdf')->name('users.export.pdf');
    Route::resource('/users', 'UserController');

	/* Permissões */
    Route::get('/permissions/export/csv', 'PermissionController@exportcsv')->name('permissions.export.csv');
	Route::get('/permissions/export/pdf', 'PermissionController@exportpdf')->name('permissions.export.pdf');
    Route::resource('/permissions', 'PermissionController');

    /* Perfis */
    Route::get('/roles/export/csv', 'RoleController@exportcsv')->name('roles.export.csv');
    Route::get('/roles/export/pdf', 'RoleController@exportpdf')->name('roles.export.pdf');
    Route::resource('/roles', 'RoleController');
});

/* Distritos */
Route::get('/distritos/export/csv', 'DistritoController@exportcsv')->name('distritos.export.csv');
Route::get('/distritos/export/pdf', 'DistritoController@exportpdf')->name('distritos.export.pdf');
Route::resource('/distritos', 'DistritoController');

/* Unidades */
Route::get('/unidades/export/csv', 'UnidadeController@exportcsv')->name('unidades.export.csv');
Route::get('/unidades/export/pdf', 'UnidadeController@exportpdf')->name('unidades.export.pdf');
Route::get('/unidades/autocomplete', 'UnidadeController@autocomplete')->name('unidades.autocomplete');
Route::resource('/unidades', 'UnidadeController');

/* Sintomas */
Route::get('/sintomas/export/csv', 'SintomaController@exportcsv')->name('sintomas.export.csv');
Route::get('/sintomas/export/pdf', 'SintomaController@exportpdf')->name('sintomas.export.pdf');
Route::resource('/sintomas', 'SintomaController');

/* Sintomas do cadastro*/
Route::get('/sintomascadastros/export/csv', 'SintomasCadastroController@exportcsv')->name('sintomascadastros.export.csv');
Route::get('/sintomascadastros/export/pdf', 'SintomasCadastroController@exportpdf')->name('sintomascadastros.export.pdf');
Route::resource('/sintomascadastros', 'SintomasCadastroController');

/* Sintomas do cadastro*/
Route::get('/doencasbases/export/csv', 'DoencasBaseController@exportcsv')->name('doencasbases.export.csv');
Route::get('/doencasbases/export/pdf', 'DoencasBaseController@exportpdf')->name('doencasbases.export.pdf');
Route::resource('/doencasbases', 'DoencasBaseController');

/* Comorbidades */
Route::get('/comorbidades/export/csv', 'ComorbidadeController@exportcsv')->name('comorbidades.export.csv');
Route::get('/comorbidades/export/pdf', 'ComorbidadeController@exportpdf')->name('comorbidades.export.pdf');
Route::resource('/comorbidades', 'ComorbidadeController');

/* Pacientes */
Route::get('/pacientes/export/csv', 'PacienteController@exportcsv')->name('pacientes.export.csv');
Route::get('/pacientes/export/pdf', 'PacienteController@exportpdf')->name('pacientes.export.pdf');
Route::resource('/pacientes', 'PacienteController');

/* Monitoramento */
Route::get('/monitoramentos/export/csv', 'MonitoramentoController@exportcsv')->name('monitoramentos.export.csv');
Route::get('/monitoramentos/export/pdf', 'MonitoramentoController@exportpdf')->name('monitoramentos.export.pdf');
Route::resource('/monitoramentos', 'MonitoramentoController');