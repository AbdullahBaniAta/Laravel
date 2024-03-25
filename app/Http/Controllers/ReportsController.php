<?php

namespace App\Http\Controllers;

use App\Models\BalanceRequest;
use App\Services\ReportsService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public ReportsService $service;
    public function __construct()
    {
        $this->middleware('auth');
        $this->service = new ReportsService();
    }

    public function viewPosStatement()
    {

        return view('reports.pos-statement', [
            'dataToView' => $this->service->viewPosStatement(),
        ]);
    }

    public function downloadPosStatement(Request $request)
    {
        return $this->service->downloadPosStatement($request);
    }

    public function viewBalanceRequest()
    {
        return view('reports.balance-request', [
            'dataToView' => $this->service->viewBalanceRequest(),
        ]);
    }

    public function downloadBalanceRequest(Request $request)
    {
        return $this->service->downloadBalanceRequest($request);
    }

    public function viewFinancialTransactions()
    {
        return view('reports.financial-transactions', [
            'dataToView' => $this->service->viewFinancialTransactions(),
        ]);
    }

    public function downloadFinancialTransactions(Request $request)
    {
        return $this->service->downloadFinancialTransactions($request);
    }
}
