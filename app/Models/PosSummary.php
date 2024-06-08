<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PosSummary extends Model
{
    protected $table = 'pos_summary';
    public function scopeDate(Builder $query, $date): void
    {
        $query->whereBetween('day', $date);
    }
    public static function prepareFilteredQuery($data) : Builder
    {
        $allColumns = \Schema::getColumnListing('pos_summary');
        $excludeColumns = ['sum_cost', 'company_earning'];
        $columns = array_diff($allColumns, $excludeColumns);
        $query = self::select($columns);
        foreach ($data as $key => $value) {
            if (empty($value)) {
                continue;
            }
            switch ($key) {
                case 'id':
                case 'pos_id':
                case 'rep_id':
                    $query->whereRaw( $key . ' like ?', '%' . strtolower($value) . '%');
                    break;
                case 'date_from':
                case 'date_to':
                    $op = $key === 'date_from' ? '>=' : '<=';
                    $query->where('day', $op, $value);
                    break;
                default:
                    $query->where($key, $value);
            }
        }
        $query->orderBy('day', 'asc');

        return $query;
    }
}
