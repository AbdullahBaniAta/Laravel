<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReportCollection extends Model
{
    protected $table = 'report_collection';

    /**
     * @param Builder $query
     * @param $date
     * @return void
     */
    public function scopeDate(Builder $query, $date): void
    {
        $query->whereBetween('DateTime', $date);
    }

    /**
     * @param $date
     * @return array
     */
    public static function revenuePerCity($date = null): array
    {
        return static::select(DB::raw('SUM(Company_Price - Cost) as revenue'), 'City')
            ->date($date)
            ->groupBy('City')
            ->get()
            ->toArray();
    }

    /**
     * @param $date
     * @return Collection
     */
    public static function revenuePerPos($date = null): Collection
    {
        return static::select(DB::raw('SUM(End_User_Price - Company_Price) as revenue'), 'Rep_name')
            ->date($date)
            ->groupBy('Rep_name')
            ->get();
    }

    /**
     * @param $date
     * @return Collection
     */
    public static function revenuePosPerMonth($date = null): Collection
    {
        return static::select(DB::raw('SUM(End_User_Price - Company_Price) as revenue'), 'Rep_name', DB::raw('MONTH(DateTime) as month'))
            ->date($date)
            ->groupBy('Rep_name', 'month')
            ->orderBy('month')
            ->get();
    }

    /**
     * @param $date
     * @return Collection
     */
    public static function costCommonCompanyAndEndUser($date = null): Collection
    {
        return static::select('Company_Price as x', 'End_User_Price as y')
            ->date($date)
            ->get();
    }

    /**
     * @param $date
     * @return mixed
     */
    public static function costDistribution($date = null)
    {
        return static::selectRaw('City, GROUP_CONCAT(Cost ORDER BY Cost) as Costs')
            ->date($date)
            ->groupBy('City')
            ->get();
    }

    public static function rankProductsByCategoryAndBrand($date = null)
    {
        return static::select('category', 'brand', DB::raw('count(Products) as total'))
            ->date($date)
            ->groupBy('category', 'brand')
            ->get();
    }

    public static function distributionSalesByCategory($date)
    {
        return static::selectRaw('Category, Products, SUM(Company_Price - Cost) as sum_cost')
            ->date($date)
            ->groupBy('Category', 'Products')
            ->orderBy('Products', 'desc')
            ->get();
    }

    public static function salesPerMonthLine($date)
    {
        return static::selectRaw('SUM(Company_Price - Cost) as cost, MONTH(DateTime) as month')
            ->date($date)
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }

    public static function salesPerChannelDonut($date)
    {
        return static::select('Channel_Type')
            ->selectRaw('SUM(Company_Price - Cost) as cost')
            ->date($date)
            ->groupBy('Channel_Type')
            ->get();
    }

    public static function costEffectOnSales($date)
    {
        return ReportCollection::select(['Products', 'Cost', 'Company_Price'])
            ->date($date)
            ->get();
    }


    public static function getSalesByTerminalReport($date)
    {
        return static::where('brand', 'Zain voice')
            ->whereBetween('DateTime', $date)
            ->select(['Products', 'UserID as Terminal', DB::raw('SUM(Company_Price - Cost) as Sales')])
            ->groupBy(['Products', 'Terminal'])
            ->orderBy('Sales', 'DESC')
            ->get();
    }

    public function channelTarget()
    {
        return $this->belongsTo(ChannelTarget::class, 'Channel_Type', 'channel_type');
    }

}

