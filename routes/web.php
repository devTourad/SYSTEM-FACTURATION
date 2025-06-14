<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\FactureController;

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
    return redirect()->route('factures.index');
});

Route::resource('clients', ClientController::class);

Route::resource('produits', ProduitController::class);

Route::resource('factures', FactureController::class);

Route::get('factures/{facture}/pdf', [FactureController::class, 'generatePdf'])->name('factures.pdf');
Route::get('factures/{facture}/print', [FactureController::class, 'print'])->name('factures.print');

// Routes pour les langues
Route::get('language/{locale}', [App\Http\Controllers\LanguageController::class, 'changeLanguage'])->name('language.change');
