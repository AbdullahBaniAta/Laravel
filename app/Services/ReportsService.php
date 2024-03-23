<?php

namespace App\Services;

use App\Models\FinancialTransaction;
use App\Models\PosStatement;
use App\Models\ReportCollection;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ReportsService
{
    private function prepareDate($dateFrom, $dateTo): array
    {
        if (empty($dateFrom)) {
            $dateFrom = Carbon::now()->format('Y-m-d H:i:s');
        } else {
            $dateFrom = Carbon::parse($dateFrom)->format('Y-m-d H:i:s');
        }

        if (empty($dateTo)) {
            $dateTo = Carbon::parse($dateFrom)->addDay()->format('Y-m-d H:i:s');
        } else {
            $dateTo = Carbon::parse($dateTo)->format('Y-m-d H:i:s');
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
    public function downloadBalanceRequest(Request $request)
    {
        $data = $request->toArray();
        $fileType = $data['file_type'] ?? 'csv';
        $action = $data['action'] ?? null;
        unset($data['file_type'], $data['action']);
        if (empty($data)) {
            response()->json();
        }
        [$data['date_from'], $data['date_to']] = $this->prepareDate($data['date_from'] ?? null, $data['date_to'] ?? null);

        $query = ReportCollection::prepareBalanceRequestFilteredQuery($data);
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


}
