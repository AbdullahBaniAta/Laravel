<?php

namespace App\Http\Controllers;

use App\helpers\DateHelper;
use App\Models\CustomersTable;
use App\Models\SalesReport;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Excel;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:zain');
    }

    public function index()
    {
        $cities = CustomersTable::select('City')->distinct()->get()->pluck('City')->toArray();
        $list = array_combine($cities, $cities);
        return view('report.index', [
            'reports' => [
                'getSalesReportByTerminal' => 'Sales Report By Terminal',
                'getSalesReportByVoucher' => 'Sales Report by Voucher',
                'getVoucherStockReport' => 'Voucher Stock Reports',
                'getEntitiesReport' => 'Entities Report',
                'getBalanceStatementReport' => 'Balance Statement Report',
            ],
            'cities' => $list,
        ]);
    }

    private function handleRequestData(Request $request)
    {
        $report = $request->query('report');
        $filterType = $request->query('filter_type');
        $isExport = $request->query('export');
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');
        $filterName = $request->query('filter_name');
        $filterValue = $request->query('filter_value');

        $filter = [];
        if ($filterType == 'City') {
            $filter = ['name' => $filterName, 'value' => $filterValue];
        } else if ($filterType == 'date') {
            $filter = DateHelper::normalizeDate($dateFrom, $dateTo);
        }
        return [$report, $filterType, $isExport, $filter];
    }
    public function report(Request $request)
    {
        [$report, $filterType, $isExport, $filter] = $this->handleRequestData($request);

        $reportService = new ReportService();

        if ($report && method_exists($reportService, $report)) {
            $reportInfo = empty($filterType)
                ? $reportService->$report($isExport)
                : $reportService->$report($filter, $isExport);

            if ($isExport) {
                $fileName = $reportInfo['report_title'] . '.xlsx';
                $salesReport = new SalesReport($reportInfo['data'], array_keys($reportInfo['data']->first()->getAttributes()));
                Excel::store($salesReport, $fileName);
                $headers = [
                    'Cache-Control' => 'no-cache, must-revalidate , no-store'
                ];

                return response()
                    ->download(storage_path("app/$fileName"), $fileName, $headers)
                    ->deleteFileAfterSend();
            }
            return response()->json($reportInfo);
        } else {
            return response()->json(['error' => 'Bad Request'], 400);
        }
    }
}
