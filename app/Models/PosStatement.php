<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosStatement extends Model
{
    public function scopeDate(Builder $query, $date): void
    {
        $query->whereBetween('DateTime', $date);
    }
    public static function prepareFilteredQuery($data) : Builder
    {
        $query = PosStatement::select('*');
        foreach ($data as $key => $value) {
            if (empty($value)) {
                continue;
            }
            switch ($key) {
                case 'representativeID':
                case 'CustomersName':
                    $col = $key == 'representativeID' ? 'representativeID' : 'CustomersName';
                    $query->whereRaw('LOWER(' . $col . ') like ?', '%' . strtolower($value) . '%');
                    break;
                case 'date_from':
                case 'date_to':
                    $op = $key == 'date_from' ? '>=' : '<=';
                    $query->where('DateTime', $op, $value);
                    break;
                default:
                    $query->where($key, $value);
            }
        }
        $query->orderBy('DateTime', 'asc');
        return $query;
    }

}
