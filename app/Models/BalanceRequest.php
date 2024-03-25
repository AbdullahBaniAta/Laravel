<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class BalanceRequest extends Model
{
    protected $table = 'balance_request';
    public function scopeDate(Builder $query, $date): void
    {
        $query->whereBetween('DateTime', $date);
    }
    public static function prepareFilteredQuery($data) : Builder
    {
        $query = self::select('*');
        foreach ($data as $key => $value) {
            if (empty($value)) {
                continue;
            }
            switch ($key) {
                case 'id':
                case 'account_number':
                case 'rep_id':
                case 'customers_id':
                $query->whereRaw( $key . ' like ?', '%' . strtolower($value) . '%');
                    //                    $col = $key == 'representativeID' ? 'representativeID' : 'CustomersName';
//                    $query->whereRaw('LOWER(' . $key . ') like ?', '%' . strtolower($value) . '%');
                    break;
                case 'date_from':
                case 'date_to':
                    $op = $key === 'date_from' ? '>=' : '<=';
                    $query->where('date_time', $op, $value);
                    break;
                default:
                    $query->where($key, $value);
            }
        }
        $query->orderBy('date_time', 'asc');

        return $query;
    }
}
