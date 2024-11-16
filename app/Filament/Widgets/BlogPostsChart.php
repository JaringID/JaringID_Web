<?php

namespace App\Filament\Widgets;

use App\Models\Harvest;  // Ensure this is the correct model for Harvest
use Filament\Widgets\LineChartWidget;
use Illuminate\Support\Facades\DB;

class BlogPostsChart extends LineChartWidget
{
    public function getHeading(): string
    {
        return 'Harvest Quantities Over Time';
    }

    protected function getData(): array
    {
        // Query the harvest data, grouping by year and month
        $harvestData = Harvest::select(
                DB::raw('YEAR(harvest_date) as year'),
                DB::raw('MONTH(harvest_date) as month'),
                DB::raw('SUM(quantity) as total_quantity')
            )
            ->groupBy(DB::raw('YEAR(harvest_date)'), DB::raw('MONTH(harvest_date)'))
            ->orderBy(DB::raw('YEAR(harvest_date)'), 'asc')
            ->orderBy(DB::raw('MONTH(harvest_date)'), 'asc')
            ->get();

        // Prepare the data for the chart
        $labels = [];
        $data = [];

        // Format the results for the chart
        foreach ($harvestData as $harvest) {
            // Format the month/year as labels
            $monthName = date('M', mktime(0, 0, 0, $harvest->month, 10));
            $labels[] = $monthName . ' ' . $harvest->year;  // Example: 'Jan 2024'
            $data[] = $harvest->total_quantity;  // Sum of the harvest quantity for that month
        }

        // Return the formatted data in the structure required by the chart
        return [
            'datasets' => [
                [
                    'label' => 'Harvest Quantities',
                    'data' => $data,
                    'borderColor' => '#4CAF50',  // Line color
                    'fill' => false,  // Do not fill under the line
                ],
            ],
            'labels' => $labels,
        ];
    }
}
