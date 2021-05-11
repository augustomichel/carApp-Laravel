<?php

//use Illuminate\Routing\Route;

//Routes FrontEnd
Route::get('/', 'Front\DashboardFrontController@manager');
Route::get('/contato', 'Front\HomeController@contato');
Route::get('/condutor', 'Front\HomeController@condutor');
Route::post('/condutor', 'Front\HomeController@condutorStore');
Route::get('/modelo/{id}', 'Front\HomeController@modelo');
Route::get('/manager', 'Front\DashboardFrontController@manager');
Route::get('/forgot', 'Front\DashboardFrontController@forgot');
Route::Resource('/veiculos', 'Front\VeiculoController');
Route::get('/home', 'Front\HomeController@index');
Route::Resource('/usuarioservico', 'Front\ServicoController');
Route::Resource('/checkin', 'Front\CheckinController');
Route::Resource('/graph', 'Front\GraphController');

//Routes Admin
Route::get('/dashboard', 'Admin\DashboardController@index');
Route::Resource('/cliente', 'Admin\ClienteController');
Route::Resource('/usuario', 'Admin\UsuarioController');
Route::Resource('/servico', 'Admin\ServicoController');
Route::Resource('/produto', 'Admin\ProdutoController');

Route::get('/cliente/status/{id}', 'Admin\ClienteController@status');
Route::get('/usuario/status/{id}', 'Admin\UsuarioController@status');
Route::get('/produto/status/{id}', 'Admin\ProdutoController@status');
Route::get('/servico/status/{id}', 'Admin\ServicoController@status');
Route::post('/auth', 'Auth\AuthController@auth');
Route::post('/forgot-pass', 'Auth\AuthController@forgot');
Route::get('/logout', 'Auth\AuthController@logout');
Route::Resource('/relatorio', 'Admin\RelatorioController');
Route::post('/result', 'Admin\RelatorioController@result');
