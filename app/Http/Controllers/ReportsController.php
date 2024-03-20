<?php

namespace App\Http\Controllers;

use App\Services\ReportsService;
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
            'dataToView' => $this->service->viewPosStatement(),
        ]);
    }

    public function downloadBalanceRequest(Request $request)
    {
        return $this->service->downloadBalanceRequest($request);
    }


}
