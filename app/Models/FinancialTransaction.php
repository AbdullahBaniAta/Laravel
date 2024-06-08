<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialTransaction extends Model
{
    public function scopeDate(Builder $query, $date): void
    {
        $query->whereBetween('DateTime', $date);
    }
    public static function prepareFilteredQuery($data) : Builder
    {
        $query = FinancialTransaction::select('*');
        foreach ($data as $key => $value) {
            if (empty($value)) {
                continue;
            }
            switch ($key) {
                case 'IDReceive':
                case 'SenderID':
                    $col = $key == 'SenderID' ? 'SenderID' : 'IDReceive';
                    $query->whereRaw('LOWER(' . $col . ') like ?', '%' . strtolower($value) . '%');
                    break;
                case 'date_from':
                case 'date_to':
                    $op = $key == 'date_from' ? '>=' : '<=';
                    $query->where('DateTime', $op, $value);
                    break;
                case 'SenderType':
                    $query->whereRaw('LOWER(SenderID) like ?', strtolower($value) . '%');
                    break;
                default:
                    $query->where($key, $value);
            }
        }
        $query->orderBy('DateTime', 'asc');
        return $query;
    }
}
