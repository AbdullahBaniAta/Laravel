<?php

namespace App\Services;

use App\Models\CustomersTable;
use App\Models\OperationTableTemp;
use App\Models\ProductsPrice;
use App\Models\ReportCollection;
use Illuminate\Support\Facades\DB;

class ReportService
{

    protected $perPage = 100;
    public function getSalesReportByTerminal(array $date, $isExport = false): array
    {
        $query = ReportCollection::where('brand', 'like', '%Zain%')
            ->date($date)
            ->select(['Products', 'UserID as Terminal', DB::raw('SUM(Company_Price - Cost) as Sales')])
            ->groupBy(['Products', 'Terminal'])
            ->orderBy('Sales', 'DESC');
           if ($isExport) {
               $data = $query->get();
           } else {
               $data = $query->paginate($this->perPage, ['*'], 'page');
               $data->appends(request()->query());
           }

        return [
            'data' => $data,
            'report_title' => 'Sales Report By Terminal',
        ];
    }
    public function getBalanceStatementReport(array $date, $isExport = false): array
    {
        $query = OperationTableTemp::where('Description', 'like', '%ZAIN%')
            ->where('Service_Name', 'E-Voucher')
            ->select(['UserID','Username','Date_Time','Balance_Before','Debit','Credit','Balance_After','Operation','Description'])
            ->whereBetween('Date_Time',$date);

//        dd($query->toSql(), );
        if ($isExport) {
            $data = $query->get();
        } else {
            $data = $query->paginate($this->perPage, ['*'], 'page');
            $data->appends(request()->query());
        }

        return [
            'data' => $data,
            'report_title' => 'Balance Statement Report',
        ];
    }
    public function getSalesReportByVoucher(array $date, $isExport = false): array
    {
        $query = ReportCollection::where('brand', 'like', '%Zain%')
            ->date($date)
            ->select(['Products', DB::raw('SUM(Company_Price - Cost) as Sales')])
            ->groupBy(['Products'])
            ->orderBy('Sales', 'DESC');
            if ($isExport) {
                $data = $query->get();
            } else {
                $data = $query->paginate($this->perPage, ['*'], 'page');
                $data->appends(request()->query());
            }

        return [
            'data' => $data,
            'report_title' => 'Sales Report by Voucher',
        ];
    }

    public function getVoucherStockReport($isExport = false): array
    {
        $query = ProductsPrice::where('brand', 'like', '%Zain%')
            ->select(['Category', 'Prodacts', 'Count'])
            ->orderBy('Count', 'DESC');
        if ($isExport) {
            $data = $query->get();
        } else {
            $data = $query->paginate($this->perPage, ['*'], 'page');
            $data->appends(request()->query());
        }
        return [
            'data' => $data,
            'report_title' => 'Voucher Stock Reports',
        ];
    }

    public function getEntitiesReport($filter, $isExport = false): array
    {
        $query = CustomersTable::select(['CustomersName', 'City', 'AreaName', 'district'])
            ->where($filter['name'], $filter['value']);
        if ($isExport) {
            $data = $query->get();
        } else {
            $data = $query->paginate($this->perPage, ['*'], 'page');
            $data->appends(request()->query());
        }
        return [
            'data' => $data,
            'report_title' => 'Entities Report',
        ];
    }

}
