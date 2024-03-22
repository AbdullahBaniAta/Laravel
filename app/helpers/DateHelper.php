<?php

namespace App\helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function normalizeDate(?string $dateFrom = '', ?string $dateTo = ''): array
    {
        $dateFormat = 'Y-m-d H:i:s';
        if (empty($dateFrom)) {
            $dateFrom = now()->startOfDay()->format($dateFormat);
            $dateTo = now()->endOfDay()->format($dateFormat);
        } elseif (empty($dateTo)) {
            $dateFrom = now()->format($dateFormat);
            $dateTo = Carbon::parse($dateFrom)->endOfDay()->format($dateFormat);
        } else {
            $dateFrom = Carbon::parse($dateFrom)->format($dateFormat);
            $dateTo = Carbon::parse($dateTo)->format($dateFormat);
        }
        return [$dateFrom, $dateTo];
    }
}
