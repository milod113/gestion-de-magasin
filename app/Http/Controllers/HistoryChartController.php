<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class HistoryChartController extends Controller
{
    public function index()
    {
        // Fetch history data with article relation
        $histories = History::with('article')->get();

        // Prepare data for the chart
        $labels = $histories->pluck('article.designation'); // X-axis labels (article names)
        $quantites = $histories->pluck('quantite'); // Quantities
        $prix = $histories->pluck('prix'); // Prices

        return view('admin.history.chart', compact('labels', 'quantites', 'prix'));
    }
}

