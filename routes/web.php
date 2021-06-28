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
Route::match(['get', 'post'], 'login', 'AuthController@login');
Route::get('/logout', 'AuthController@logout');

Route::middleware('auth.admin.login')->group(function () {
    Route::get('/', 'DashboardController@index');

    Route::prefix('admin')->group(function () {
        Route::get('dashboard', 'DashboardController@index');
        Route::post('dashboard/datatable-realtime', 'DashboardController@datatableRealtime');
        Route::post('dashboard/datatable-tuntas', 'DashboardController@datatableTuntas');
        Route::post('dashboard/datatable-upload', 'DashboardController@datatableUpload');

        Route::get('log', 'LogController@index');
        Route::post('log/datatable', 'LogController@datatable');

        Route::get('map', 'MapController@index');
        Route::post('map/store', 'MapController@store');

        Route::get('nasabah/{id}/view', 'NasabahController@view');
        Route::get('nasabah/qc', 'NasabahController@qc');
        Route::get('nasabah/indexing', 'NasabahController@indexing');
        Route::post('nasabah/store', 'NasabahController@store');
        Route::get('nasabah/stream_pdf/{id}', 'NasabahController@streamPdf');

        Route::get('report', 'ReportController@index');
        Route::post('report/datatable', 'ReportController@datatable');
        Route::post('report/set-tanggal-lapor', 'ReportController@setTanggalLapor');
        Route::post('report/export', 'ReportController@export');

        Route::get('import', 'ImportController@index');
        Route::post('import', 'ImportController@import');

        Route::post('select2/provinsi', 'Select2Controller@getProvinsi');
        Route::post('select2/kabupaten', 'Select2Controller@getKabupaten');
        Route::post('select2/kecamatan', 'Select2Controller@getKecamatan');
        Route::post('select2/kelurahan', 'Select2Controller@getKelurahan');
        Route::post('select2/map', 'Select2Controller@getMap');

        Route::get('upload', 'UploadController@index');
        Route::post('upload/store', 'UploadController@store');

        Route::get('user', 'UserController@index');
        Route::post('user/datatable', 'UserController@datatable');
        Route::post('user/store', 'UserController@store');
        Route::get('user/view/{id}', 'UserController@view');
        Route::get('user/setting', 'UserController@setting');

    });
});