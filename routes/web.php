<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockDashboardController;
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
use App\Http\Controllers\MessageController;

use App\Http\Controllers\Immobilier\EquipmentCategoryController;
use App\Http\Controllers\Immobilier\EquipmentController;
use App\Http\Controllers\Immobilier\EquipmentUnitController;

Route::get('/', function () {
    return view('welcome');
});

// ✅ ALL protected routes here
Route::middleware(['auth'])->group(function () {

    // Dashboard (auth + verified)
    Route::get('/dashboard', [StockDashboardController::class, 'index'])
        ->middleware(['verified'])
        ->name('dashboard');

    Route::get('/dashboard-stock', [StockDashboardController::class, 'index'])
        ->name('stock.dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Livraisons + Stats
    Route::get('/livraisons/create/{commande_ref}', [LivraisonController::class, 'create'])
        ->where('commande_ref', '.*')
        ->name('livraisons.create');

    Route::get('/livraisons/{commande_ref}', [LivraisonController::class, 'show'])
        ->where('commande_ref', '.*')
        ->name('livraisons.show');

    Route::post('/livraisons', [LivraisonController::class, 'store'])
        ->name('livraisons.store');

    Route::get('/statistiques/consommation', [LivraisonController::class, 'consommationParService'])
        ->name('statistiques.consommation');

    Route::get('/statistiques/consommation/pdf', [LivraisonController::class, 'exportConsommationParServicePDF'])
        ->name('statistiques.consommation.pdf');

    Route::get('/statistiques/details-services', [LivraisonController::class, 'detailsLivraisonsParService'])
        ->name('statistiques.details_services');

    Route::get('/statistiques/details/pdf', [LivraisonController::class, 'exportDetailsParServicePdf'])
        ->name('statistiques.details.pdf');

    // Articles / Categories / Services / Commandes
    Route::resource('articles', ArticleController::class);
    Route::get('/articles/export', [ArticleController::class, 'export'])->name('articles.export');
    Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show'); // optional (resource already has show)

    Route::resource('categories', CategorieController::class);
    Route::get('/categories/{id}', [CategorieController::class, 'show'])->name('categories.show'); // optional

    Route::resource('services', ServiceController::class);
    Route::resource('commandes', CommandeController::class);

    // Fournisseurs / Receptions
    Route::resource('fournisseurs', FournisseurController::class);
    Route::resource('receptions', ReceptionController::class);

    Route::get('/receptions/{id}/pdf', [ReceptionController::class, 'pdf'])->name('receptions.pdf');
    Route::get('/history/chart', [App\Http\Controllers\HistoryChartController::class, 'index'])->name('history.chart');

    // Messages
Route::get('/messages/inbox', [MessageController::class, 'inbox'])->name('messages.inbox');
Route::get('/messages/sent', [MessageController::class, 'sent'])->name('messages.sent');

Route::resource('messages', MessageController::class);

Route::post('/messages/bulk-read', [MessageController::class, 'bulkMarkAsRead'])
    ->name('messages.bulkMarkAsRead');

Route::delete('/messages/bulk-delete', [MessageController::class, 'bulkDelete'])
    ->name('messages.bulkDelete');

Route::post('/messages/{message}/mark-as-read', [MessageController::class, 'markAsRead'])
    ->name('messages.markAsRead');


    // Conventions
    Route::resource('conventions', ConventionController::class);
    Route::get('conventions/{convention}/articles', [ConventionController::class, 'articles'])->name('conventions.articles');
    Route::get('/conventions/{convention}/items', [ConventionController::class, 'items'])->name('conventions.items');

    // Users
    Route::resource('users', UserController::class);

    // Admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('permissions', PermissionController::class);
        Route::resource('roles', RolePermissionController::class);
    });

    Route::get('/roles/{role}', [RolePermissionController::class, 'show'])
        ->name('admin.roles.show');

    // Immobilier
    Route::prefix('immobilier')->name('immobilier.')->group(function () {
        Route::resource('categories-equipements', EquipmentCategoryController::class);
        Route::resource('equipements', EquipmentController::class);

        Route::resource('equipment-units', EquipmentUnitController::class)
            ->parameters(['equipment-units' => 'equipmentUnit']);
    });

});

require __DIR__.'/auth.php';
