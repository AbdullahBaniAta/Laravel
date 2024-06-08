<?php

namespace App\Http\Controllers;

use App\Services\ChartService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChartsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('role:admin');
    }


    public function index()
    {
        return view('charts.index-new', config('charts'));
    }

    public function fetchChartData(Request $request)
    {
        $chartName = $request->query('chart_name');
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');
        $rg = $request->query('rg');

        $chartService = new ChartService($dateFrom, $dateTo, $rg);
        if ($chartName && method_exists($chartService, $chartName)) {
            $chartInfo = $chartService->$chartName([$dateFrom, $dateTo]);

            return response()->json($chartInfo);
        } else {
            return response()->json(['error' => 'Bad Request'], 400);
        }
    }
}
