<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\LivraisonController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\ReceptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\ConventionController;
use App\Http\Controllers\StockDashboardController;
use App\Models\Livraison;

use App\Http\Controllers\Immobilier\EquipmentCategoryController;
use App\Http\Controllers\Immobilier\EquipmentController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [StockDashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// routes/web.php

Route::get('/livraisons/create/{commande_ref}', [LivraisonController::class, 'create'])
    ->where('commande_ref', '.*')
    ->name('livraisons.create');

    Route::get('/livraisons/{commande_ref}', [LivraisonController::class, 'show'])
    ->where('commande_ref', '.*') // allows slashes in ref_commande
    ->name('livraisons.show');

Route::get('/statistiques/consommation', [LivraisonController::class, 'consommationParService'])
    ->name('statistiques.consommation');

Route::get('/statistiques/details-services', [LivraisonController::class, 'detailsLivraisonsParService'])
    ->name('statistiques.details_services');

    Route::get('/statistiques/details/pdf', [LivraisonController::class, 'exportDetailsParServicePdf'])
    ->name('statistiques.details.pdf');


// routes/web.php
Route::get('/statistiques/consommation/pdf', [LivraisonController::class, 'exportConsommationParServicePDF'])->name('statistiques.consommation.pdf');


Route::post('/livraisons', [LivraisonController::class, 'store'])->name('livraisons.store');



Route::middleware('auth')->group(function () {

    // Routes des ressources
    Route::resource('articles', ArticleController::class);

Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');

    Route::get('/articles/export', [ArticleController::class, 'export'])
    ->name('articles.export');

    Route::resource('categories', CategorieController::class);
    Route::get('/categories/{id}', [CategorieController::class, 'show'])->name('categories.show');

    Route::resource('services', ServiceController::class);
    Route::resource('commandes', CommandeController::class);
});

Route::resource('fournisseurs', FournisseurController::class);

Route::resource('receptions', ReceptionController::class);
Route::get('/history/chart', [App\Http\Controllers\HistoryChartController::class, 'index'])->name('history.chart');



// routes/web.php



Route::get('/dashboard-stock', [StockDashboardController::class, 'index'])
    ->name('stock.dashboard');


Route::resource('conventions', ConventionController::class);

// si tu veux une route spécifique pour voir les articles d’un marché :
Route::get('conventions/{convention}/articles', [ConventionController::class, 'articles'])
    ->name('conventions.articles');



Route::resource('users', UserController::class);




Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('permissions', PermissionController::class);
});



Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('roles', RolePermissionController::class);
});
Route::get('/roles/{role}', [RolePermissionController::class, 'show'])->name('admin.roles.show');

// Catégories d’équipements  routes************************************************************************************

Route::middleware(['auth'])->prefix('immobilier')->name('immobilier.')->group(function () {

    // Catégories d’équipements
    Route::resource('categories-equipements', EquipmentCategoryController::class);

    // Équipements
    Route::resource('equipements', EquipmentController::class);
});

use App\Http\Controllers\Immobilier\EquipmentUnitController;

Route::prefix('immobilier')->name('immobilier.')->group(function () {
    Route::resource('equipment-units', EquipmentUnitController::class)
        ->parameters(['equipment-units' => 'equipmentUnit']); // pour typer correctement le modèle
});


require __DIR__.'/auth.php';
