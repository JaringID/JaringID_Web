<?php

namespace App\Filament\Widgets;

use App\Models\Harvest;  // Ensure this is the correct model for Harvest
use App\Models\HasilPanen;
use App\Models\Siklus;
use Filament\Widgets\LineChartWidget;
use Illuminate\Support\Facades\DB;

class BlogPostsChart extends LineChartWidget
{
    public function getHeading(): string
    {
        return 'Siklus Tambak';
    }

    protected function getData(): array
    {
        // Query the harvest data, grouping by year and month
        $SiklusData = Siklus::select(
                DB::raw('YEAR(tanggal_tebar) as year'),
                DB::raw('MONTH(tanggal_tebar) as month'),
                DB::raw('SUM(total_tebar) as total_quantity')
            )
            ->groupBy(DB::raw('YEAR(tanggal_tebar)'), DB::raw('MONTH(tanggal_tebar)'))
            ->orderBy(DB::raw('YEAR(tanggal_tebar)'), 'asc')
            ->orderBy(DB::raw('MONTH(tanggal_tebar)'), 'asc')
            ->get();

        // Prepare the data for the chart
        $labels = [];
        $data = [];

        // Format the results for the chart
        foreach ($SiklusData as $siklus) {
            // Format the month/year as labels
            $monthName = date('M', mktime(0, 0, 0, $siklus->month, 10));
            $labels[] = $monthName . ' ' . $siklus->year;  // Example: 'Jan 2024'
            $data[] = $siklus->total_tebar;  // Sum of the harvest quantity for that month
        }

        // Return the formatted data in the structure required by the chart
        return [
            'datasets' => [
                [
                    'label' => 'Siklus',
                    'data' => $data,
                    'borderColor' => '#4CAF50',  // Line color
                    'fill' => false,  // Do not fill under the line
                ],
            ],
            'labels' => $labels,
        ];
    }
}
