<?php

namespace App\Services;

use App\Models\BalanceRequest;
use App\Models\FinancialTransaction;
use App\Models\PosStatement;
use App\Models\PosSummary;
use App\Models\ReportCollection;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ReportsService
{
    private function prepareDate($dateFrom, $dateTo,$format ="Y-m-d H:i:s"): array
    {
        if (empty($dateFrom)) {
            $dateFrom = Carbon::now()->format($format);
        } else {
            $dateFrom = Carbon::parse($dateFrom)->format($format);
        }

        if (empty($dateTo)) {
            $dateTo = Carbon::parse($dateFrom)->addDay()->format($format);
        } else {
            $dateTo = Carbon::parse($dateTo)->format($format);
        }
        return [$dateFrom, $dateTo];
    }

    public function viewPosStatement(): array
    {
        $defaultSelection = ['' => 'Select One'];
        $repNames = PosStatement::select('representative')->distinct()->pluck('representative')->toArray();
        $categories = PosStatement::select('Category')->distinct()->pluck('Category')->toArray();
        $brands = PosStatement::select('Brand')->distinct()->pluck('Brand')->toArray();
        $channelTypes = PosStatement::select('Channel_Type')->distinct()->pluck('Channel_Type')->toArray();
        $categories = array_combine($categories, $categories);
        $repNames = array_combine($repNames, $repNames);
        $brands = array_combine($brands, $brands);
        $channelTypes = array_combine($channelTypes, $channelTypes);

        return [
            'rep_names' => $defaultSelection + $repNames,
            'categories' => $defaultSelection + $categories,
            'brands' => $defaultSelection + $brands,
            'channel_types' => $defaultSelection + $channelTypes,
        ];
    }

    public function downloadPosStatement(Request $request)
    {
        $data = $request->toArray();
        $fileType = $data['file_type'] ?? 'csv';
        $action = $data['action'] ?? null;
        unset($data['file_type'], $data['action'], $data['_token']);
        if (empty($data)) {
            response()->json();
        }
        [$data['date_from'], $data['date_to']] = $this->prepareDate($data['date_from'] ?? null, $data['date_to'] ?? null);

        $query = PosStatement::prepareFilteredQuery($data);
        if ($action == 'preview') {
            return response()->json($query->limit(20)->get());
        }

        $fileName = 'pos-statement-' . Carbon::now()->format('Y-m-d') . '.' . $fileType;
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            $data  = $query->get();
            if (!empty($data->first())) {
                fputcsv($handle, array_keys($data->first()->getAttributes()));
            }
            $data->each(function ($row) use ($handle) {
                fputcsv($handle, $row->getAttributes());
            });
            fclose($handle);
        }, $fileName, $headers);
    }
    public function viewBalanceRequest(): array
    {
        $defaultSelection = ['' => 'Select One'];
        $customer_name =BalanceRequest::select('customers_name')->distinct()->pluck('customers_name')->toArray();
        $account_name =BalanceRequest::select('account_name')->distinct()->pluck('account_name')->toArray();
        $sales_representative =BalanceRequest::select('sales_representative')->distinct()->pluck('sales_representative')->toArray();
        $status =BalanceRequest::select('status')->distinct()->pluck('status')->toArray();

        return [
               'customer_name' => $defaultSelection + array_combine($customer_name, $customer_name),
               'account_name'=> $defaultSelection + array_combine($account_name, $account_name),
               'sales_representative' => $defaultSelection + array_combine($sales_representative, $sales_representative),
               'status' =>$defaultSelection + array_combine($status, $status),
        ];
    }
    public function downloadBalanceRequest(Request $request)
    {

        $data = $request->toArray();
        $fileType = $data['file_type'] ?? 'csv';
        $action = $data['action'] ?? null;
        unset($data['file_type'], $data['action'], $data['_token']);
        if (empty($data)) {
            response()->json();
        }
        [$data['date_from'], $data['date_to']] = $this->prepareDate($data['date_from'] ?? null, $data['date_to'] ?? null);

        $query = BalanceRequest::prepareFilteredQuery($data);
        if ($action == 'preview') {
            return response()->json($query->limit(20)->get());
        }

        $fileName = 'balance-request-' . Carbon::now()->format('Y-m-d') . '.' . $fileType;
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            $data  = $query->get();
            if (!empty($data->first())) {
                fputcsv($handle, array_keys($data->first()->getAttributes()));
            }
            $data->each(function ($row) use ($handle) {
                fputcsv($handle, $row->getAttributes());
            });
            fclose($handle);
        }, $fileName, $headers);
    }

    public function viewFinancialTransactions(): array
    {
        $defaultSelection = ['' => 'Select One'];
        $senderNames = FinancialTransaction::select('SenderName')->distinct()->pluck('SenderName')->toArray();
        $receiverNames = FinancialTransaction::select('ReceiveName')->distinct()->pluck('ReceiveName')->toArray();
        $senderNames = array_combine($senderNames, $senderNames);
        $receiverNames = array_combine($receiverNames, $receiverNames);

        return [
            'SenderName' => $defaultSelection + $senderNames,
            'ReceiveName' => $defaultSelection + $receiverNames,

        ];
    }

    public function downloadFinancialTransactions(Request $request)
    {
        $data = $request->toArray();
        $fileType = $data['file_type'] ?? 'csv';
        $action = $data['action'] ?? null;
        unset($data['file_type'], $data['action'], $data['_token']);
        if (empty($data)) {
            response()->json();
        }
        [$data['date_from'], $data['date_to']] = $this->prepareDate($data['date_from'] ?? null, $data['date_to'] ?? null);

        $query = FinancialTransaction::prepareFilteredQuery($data);
        if ($action == 'preview') {
            return response()->json($query->limit(20)->get());
        }

        $fileName = 'financial-transaction-' . Carbon::now()->format('Y-m-d') . '.' . $fileType;
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            $data  = $query->get();
            if (!empty($data->first())) {
                fputcsv($handle, array_keys($data->first()->getAttributes()));
            }
            $data->each(function ($row) use ($handle) {
                fputcsv($handle, $row->getAttributes());
            });
            fclose($handle);
        }, $fileName, $headers);
    }

    public function viewPOSSummary(): array
    {
        $defaultSelection = ['' => 'Select One'];
        $pos_name = PosSummary::select('pos_name')->distinct()->pluck('pos_name')->toArray();
        $arabic_name = PosSummary::select('arabic_name')->distinct()->pluck('arabic_name')->toArray();
        $rep_name = PosSummary::select('rep_name')->distinct()->pluck('rep_name')->toArray();
        $channel =  PosSummary::select('channel')->distinct()->pluck('channel')->toArray();
        $region =  PosSummary::select('region')->distinct()->pluck('region')->toArray();
        $city =  PosSummary::select('city')->distinct()->pluck('city')->toArray();

        return [
            'pos_name' => $defaultSelection + array_combine($pos_name, $pos_name),
            'arabic_name' => $defaultSelection + array_combine($arabic_name, $arabic_name),
            'rep_name' => $defaultSelection + array_combine($rep_name, $rep_name),
            'channel' => $defaultSelection + array_combine($channel, $channel),
            'region'=>$defaultSelection + array_combine($region, $region),
            'city'=>$defaultSelection + array_combine($city, $city),
        ];
    }
    public function downloadPOSSummary(Request $request)
    {

        $data = $request->toArray();
        $fileType = $data['file_type'] ?? 'csv';
        $action = $data['action'] ?? null;
        unset($data['file_type'], $data['action'], $data['_token']);
        if (empty($data)) {
            response()->json();
        }

        [$data['date_from'], $data['date_to']] = $this->prepareDate($data['date_from'] ?? null, $data['date_to'] ?? null,'Y-m-d');

        $query = PosSummary::prepareFilteredQuery($data);

        if ($action == 'preview') {
            return response()->json($query->limit(20)->get());
        }

        $fileName = 'pos-summary-' . Carbon::now()->format('Y-m-d') . '.' . $fileType;
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            $data  = $query->get();
            if (!empty($data->first())) {
                fputcsv($handle, array_keys($data->first()->getAttributes()));
            }
            $data->each(function ($row) use ($handle) {
                fputcsv($handle, $row->getAttributes());
            });
            fclose($handle);
        }, $fileName, $headers);
    }


}
