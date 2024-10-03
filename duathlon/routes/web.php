<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FrontController;
use App\Http\Controllers\RaceController;
use App\Http\Controllers\AthleteController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\RankingController;

Route::get('/', [FrontController::class, 'getIndex'])->name('index');
Route::resource('race', RaceController::class);
Route::get('/athletes/{race_id}', [AthleteController::class, 'show'])->name('athlete.showAll');
Route::get('/race/{race}/destroy/confirm', [RaceController::class, 'destroyConfirm'])->name('race.destroyConfirm');
Route::get('/race/{race}', [RaceController::class, 'showDashboard'])->name('race.showDashboard');
Route::resource('athlete', AthleteController::class);
Route::resource('ranking', RankingController::class);

Route::get('/race/{race_id}/athlete/create', [AthleteController::class, 'createOrEdit'])->name('athlete.createNew');
Route::get('/race/{race_id}/athlete/{athlete_id}/edit', [AthleteController::class, 'createOrEditSingolo'])->name('athlete.edit');
Route::get('/race/{race_id}/coppia/{team_id}/edit', [AthleteController::class, 'createOrEditCoppia'])->name('athlete.editCoppia');
Route::post('/athlete', [AthleteController::class, 'store'])->name('athlete.store');
Route::put('/athlete/{athlete}', [AthleteController::class, 'update'])->name('athlete.update');

Route::delete('/race/{race_id}/athlete/{athlete_id}/destroy', [AthleteController::class, 'destroySingolo'])->name('athlete.destroySingolo');
Route::get('/race/{race_id}/athlete/{athlete_id}/destroyAtletaConfirm', [AthleteController::class, 'destroySingoloConfirm'])->name('athlete.destroySingoloConfirm');

Route::get('/race/{race_id}/coppia/{team_id}/destroyCoppiaConfirm', [AthleteController::class, 'destroyCoppiaConfirm'])->name('athlete.destroyCoppiaConfirm');
Route::delete('/race/{race_id}/athlete/{team_id}/destroyCoppia', [AthleteController::class, 'destroyCoppia'])->name('athlete.destroyCoppia');

Route::get('/print-qr-code/singolo/{id}', [QrCodeController::class, 'printQrCode'])->name('qrCode.print');
Route::get('/print-qr-code/coppia/{id}', [QrCodeController::class, 'printQrCodeCoppia'])->name('qrCode.print.coppia');

// Route::get('/scan', function () {
//     return view('races.scan');
// })->name('qr.scan.view');

// Route::post('/scan', [QrCodeController::class, 'scan'])->name('qr.scan');

Route::get('/scan/{race_id}', [QrCodeController::class, 'showScanPage'])->name('qr.scan.view');
Route::post('/scan/{race_id}', [QrCodeController::class, 'scan'])->name('qr.scan');
Route::post('/set-start-time', [QrCodeController::class, 'setStartTime'])->name('set.start_time');

Route::get('/race/{race_id}/rankings', [RankingController::class, 'showRankings'])->name('race.rankings');

Route::post('/race/{race_id}/reset-times', [RaceController::class, 'resetTimes'])->name('reset.times');


