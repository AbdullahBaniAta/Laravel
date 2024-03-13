<?php

namespace App\helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function normalizeDate(?string $dateFrom = '', ?string $dateTo = '')
    {
        if (empty($dateFrom)) {
            $dateFrom = now()->firstOfMonth()->format('Y-m-d');
            $dateTo = now()->lastOfMonth()->format('Y-m-d');
        } elseif (empty($dateTo)) {
            $dateFrom = now()->format('Y-m-d');
            $dateTo = Carbon::parse($dateFrom)->lastOfMonth()->format('Y-m-d');
        } else {
            $dateFrom = Carbon::parse($dateFrom)->format('Y-m-d');
            $dateTo = Carbon::parse($dateTo)->lastOfMonth()->format('Y-m-d');
        }
        return [$dateFrom, $dateTo];
    }
}
