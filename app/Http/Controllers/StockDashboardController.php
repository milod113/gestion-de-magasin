<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Categorie;
use App\Models\Reception;
use App\Models\History;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StockDashboardController extends Controller
{
    public function index()
    {
        // --- KPIs ---
        $totalArticles = Article::count();

        $totalStock = Article::sum('quantite_en_stock');

        $stockValue = Article::select(DB::raw('SUM(quantite_en_stock * prix) as total'))
            ->value('total');

        $lowStockThreshold = 10;
        $lowStockCount = Article::where('quantite_en_stock', '<', $lowStockThreshold)->count();

        $outOfStockCount = Article::where('quantite_en_stock', '<=', 0)->count();

        // --- Top low stock list ---
        $lowStockArticles = Article::with('categorie')
            ->where('quantite_en_stock', '<', $lowStockThreshold)
            ->orderBy('quantite_en_stock', 'asc')
            ->limit(10)
            ->get();

        // --- Stock by category ---
        $stockByCategory = Categorie::withCount('articles')
            ->withSum('articles as stock_total', 'quantite_en_stock')
            ->orderByDesc('stock_total')
            ->get(['id_categorie', 'designation']);

        // --- Monthly receptions totals (last 6 months) ---
        $months = collect(range(0, 5))->map(function ($i) {
            return Carbon::now()->subMonths($i)->startOfMonth();
        })->reverse();

        $monthlyReceptions = $months->map(function ($month) {
            $start = $month->copy()->startOfMonth();
            $end   = $month->copy()->endOfMonth();

            $total = Reception::whereBetween('date_reception', [$start, $end])
                ->sum('Total');

            return [
                'label' => $month->locale('fr')->translatedFormat('M Y'),
                'total' => (float) $total
            ];
        });

        // --- Movements (entries/exits) last 30 days ---
        $start30 = Carbon::now()->subDays(30);

        $entries30 = History::where('type_mouvement', 'Entrée')
            ->where('date_changement', '>=', $start30)
            ->sum('quantite');

        $exits30 = History::where('type_mouvement', 'Sortie')
            ->where('date_changement', '>=', $start30)
            ->sum('quantite');

        // --- Last movements ---
        $lastMovements = History::with('article')
            ->orderByDesc('date_changement')
            ->limit(12)
            ->get();

        return view('admin.dashboard.stock', compact(
            'totalArticles',
            'totalStock',
            'stockValue',
            'lowStockCount',
            'outOfStockCount',
            'lowStockArticles',
            'stockByCategory',
            'monthlyReceptions',
            'entries30',
            'exits30',
            'lastMovements'
        ));
    }
}
