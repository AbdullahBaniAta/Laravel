<?php

namespace App\Services;

use App\helpers\DateHelper;
use App\Models\ChannelTarget;
use App\Models\ReportCollection;
use Carbon\Carbon;
use Facade\FlareClient\Report;
use Illuminate\Support\Facades\DB;


class ChartService
{
    private $date;

    public function __construct($dateFrom = '', $dateTo = '')
    {
        $this->date = DateHelper::normalizeDate($dateFrom, $dateTo);
    }

    public function revenuePerCityChartPie(): array
    {
        $report = ReportCollection::revenuePerCity($this->date);
        $labels = array_column($report, 'City');

        return [
            'labels' => $labels,
            'data' => array_map('floatval', array_column($report, 'revenue')),
            'colors' => [],
            'js_function' => 'buildPieChart'
        ];
    }

    public function revenuePerCityChartBar(): array
    {
        $report = ReportCollection::revenuePerCity($this->date);
        foreach ($report as $row) {
            $labels[] = $row['City'];
            $data[] = [(float)$row['revenue']];
        }
        return [
            'labels' => $labels ?? [],
            'data' => $data ?? [],
            'colors' => [],
            'js_function' => 'buildBarChart',
            'label' => 'Revenue Per City'
        ];
    }

    public function posSalesCompareLine(): array
    {
        $data = ReportCollection::revenuePosPerMonth($this->date);
        $names = $data->pluck('Rep_name')->unique();
        $labels = $data->pluck('month')->unique()->toArray();

        $datasets = [];

        foreach ($names as $name) {
            $values = [];
            foreach ($labels as $monthName) {
                $values[] = (float)($data->where('month', $monthName)->where('Rep_name', $name)->pluck('revenue')->first() ?? 0);
            }
            $datasets[$name] = $values;
        }
        return [
            'labels' => array_values($labels),
            'data' => $datasets,
            'colors' => [],
            'js_function' => 'buildLineChart'
        ];
    }

    public function posSalesBarChart(): array
    {
        $data = ReportCollection::revenuePerPos($this->date);
        $labels = $data->pluck('Rep_name')->unique();
        return [
            'labels' => $labels,
            'data' => array_map('floatval', $data->pluck('revenue')->toArray()),
            'colors' => [],
            'js_function' => 'buildBarChart',
            'label' => 'Revenue Per POS'
        ];
    }

    public function compareCostsScatterChart(): array
    {
        $data = ReportCollection::costCommonCompanyAndEndUser($this->date);

        $res = [];
        foreach ($data as $row) {
            $res[] = [
                'x' => (float)$row->x,
                'y' => (float)$row->y,
            ];
        }
        return [
            'labels' => [],
            'data' => $res,
            'colors' => [],
            'js_function' => 'buildScatterChart'
        ];
    }

    private function percentile($data, $percentile)
    {
        $count = count($data);
        $index = (int)ceil($percentile * $count) - 1;
        return $data[$index]->Cost;
    }

    public function costDistribution()
    {
        return ReportCollection::costDistribution($this->date);
    }

    public function rankProductsByCategoryAndBrand()
    {
        $data = ReportCollection::rankProductsByCategoryAndBrand($this->date);

        $parentArr = $data->pluck('category')->unique();

        $res = [];

        foreach ($parentArr as $parent) {
            $res[] = [
                'id' => $parent,
                'name' => $parent,
                'parent' => '',
            ];
        }
        foreach ($data as $row) {
            $res[] = [
                'id' => $row->brand,
                'name' => $row->brand,
                'parent' => $row->category,
                'value' => $row->total,
            ];
        }

        return $res;
    }

    public function distributionSalesByCategory()
    {
        $data = ReportCollection::distributionSalesByCategory($this->date);
        $dataset = [];
        foreach ($data as $row) {
            $dataset[$row->Category][$row->Products] = (float)$row->sum_cost;
        }

        return [
            'data' => $dataset,
        ];
    }

    public function salesPerMonthLine(): array
    {
        $data = ReportCollection::salesPerMonthLine($this->date);
        $labels = $data->pluck('month')->unique()->toArray();

        $values = [];
        foreach ($labels as $monthName) {
            $values[] = (float)($data->where('month', $monthName)->pluck('cost')->first() ?? 0);
        }

        $datasets['Sales'] = $values;
        return [
            'labels' => $labels,
            'data' => $datasets,
            'colors' => $colors ?? [],
            'js_function' => 'buildLineChart'
        ];
    }

    public function salesPerChannelDonut()
    {
        $data = ReportCollection::salesPerChannelDonut($this->date);

        $res = [];
        foreach ($data as $row) {
            $res[] = [
                'name' => $row->Channel_Type,
                'y' => (float)$row->cost,
            ];
        }
        return $res;
    }

    public function costEffectOnSales(): array
    {
        $data = ReportCollection::costEffectOnSales($this->date);

        $labels = ['Initial'];
        $values = [0];

        foreach ($data as $item) {
            $labels[] = $item->Products;
            $values[] = (float)($item->Company_Price - $item->Cost); // Profit is calculated as (Company_price - Cost)
        }

        $labels[] = 'Total Profit';
        $values[] = array_sum($values);

        return [
            'labels' => $labels,
            'data' => $values,
            'js_function' => 'buildDonutChart'
        ];
    }

    public function salesPerArea()
    {
        $data = ReportCollection::select('AreaName')
            ->selectRaw('SUM(Company_Price - Cost) as cost')
            ->groupBy('AreaName')
            ->date($this->date)
            ->get();

        $res = [];
        foreach ($data as $row) {
            $res[] = [
                'name' => $row->AreaName,
                'value' => (float)$row->cost,
            ];
        }
        return $res;
    }

    public function salesMovementPerProductsRadar()
    {
        $query = ReportCollection::select('Products as product', DB::raw('SUM(Company_Price - Cost) as total_sales'))
            ->groupBy('product')
            ->date($this->date);

        return $query->get();
    }

    public function relationBetweenCostAndSalesAndItemsSold()
    {

        return ReportCollection::select([
            'Products as product_name',
            DB::raw('SUM(Company_Price - Cost) as total_sales'),
            DB::raw('SUM(Cost) as total_cost'),
            DB::raw('count(*) as units_sold')
        ])
            ->groupBy('product_name')
            ->date($this->date)
            ->get();
    }

    public function getSalesForAgents($date)
    {
        $data = ReportCollection::select(['Rep_Name', DB::raw('SUM(End_User_Price - Company_Price) as total_sales')])
            ->date($this->date)
            ->groupBy('Rep_Name')
            ->get();

        return [
            'labels' => $data->pluck('Rep_Name')->unique(),
            'data' => array_map('floatval', $data->pluck('total_sales')->toArray()),
            'colors' => [],
            'js_function' => 'buildBarChart',
            'label' => 'Revenue Per POS'
        ];
    }

    public function getChannelRevenueByDate()
    {
        $query = ReportCollection::select([
            'Channel_Type',
            DB::raw('EXTRACT(MONTH FROM datetime) AS month'),
            DB::raw('SUM(Company_Price - cost) as total_sales')
        ])
            ->date($this->date)
            ->groupBy('Channel_Type', 'month')
            ->orderBy('Channel_Type')
            ->orderBy('month');
        $data = $query->get();

        $labels = $data->unique('month')->pluck('month')->toArray();
        $channelTypes = $data->pluck('Channel_Type')->unique();

        $datasets = [];
        foreach ($channelTypes as $channelType) {
            $values = [];
            foreach ($labels as $monthName) {
                $values[] = (float)($data->where('month', $monthName)->where('Channel_Type', $channelType)->pluck('total_sales')->first() ?? 0);
            }
            $datasets[] = [
                'name' => $channelType,
                'data' => $values,
                'color' => 'rgba(' . rand(0, 255) . ', ' . rand(0, 255) . ', ' . rand(0, 255) . ', 0.2)',
            ];
        }
        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }

    public function getSalesPerWeek()
    {
        $query = ReportCollection::select([
            DB::raw('WEEK(DateTime) AS week_number'),
            DB::raw('DAYOFWEEK(DateTime) AS day_of_week'),
            DB::raw('SUM(Company_Price - cost) as total_sales')

        ])
            ->date($this->date)
            ->groupBy('day_of_week', 'week_number')
            ->orderBy('day_of_week')
            ->orderBy('week_number');

        $data = $query->get();

        $labels = $data->unique('week_number')->pluck('week_number')->toArray();

        $res = [];
        foreach ($data as $datum) {
            $res[] = [
                (int)$datum->day_of_week - 1,
                (int)$datum->week_number,
                (float)$datum->total_sales
            ];
        }

        return [
            'data' => $res,
            'labels' => $labels,
        ];
    }

    public function getAgentPerformanceWithSales()
    {
        $salesData = ReportCollection::selectRaw('Month(DateTime) as month, Rep_Name, SUM(Company_Price - Cost) as profit')
            ->date($this->date)
            ->groupBy('Rep_Name', 'month')
            ->get();

        return [
            'labels' => $salesData->pluck('date')->unique()->toArray(),
            'data' => $salesData->groupBy('Rep_Name')->map(function ($salesmanData) {
                return [
                    'name' => $salesmanData->first()->Rep_Name,
                    'data' => array_map('floatval', $salesmanData->pluck('profit')->toArray()),
                ];
            })->values()->toArray(),
        ];
    }


    public static function getIsTargetAchieved()
    {
        return ReportCollection::selectRaw('Channel_Type, SUM(Company_Price - Cost) as profit')
            ->whereYear('DateTime', now())
            ->groupBy('Channel_Type')
            ->get()
            ->mapWithKeys(function ($reportCollection) {
                return [$reportCollection->Channel_Type => $reportCollection->profit >= $reportCollection->channelTarget->target];
            })
            ->toArray();
    }
}
