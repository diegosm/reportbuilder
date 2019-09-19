<?php

namespace ReportBuilder\Factories;

use Carbon\Carbon;
use ReportBuilder\Processors\DailyProcessor;
use ReportBuilder\Processors\DayProcessor;
use ReportBuilder\Processors\MonthlyProcessor;
use ReportBuilder\Processors\WeeklyProcessor;

class ReportBuilderFactory
{
    public static function create(Carbon $startDate, Carbon $endDate, $firstDayWeek = 0)
    {
        $days = $startDate->diffInDays($endDate);

        if ($days > 30) {
            return new MonthlyProcessor($startDate, $endDate, $firstDayWeek);
        }

        if ($days === 0) {
            return new DayProcessor($startDate, $endDate, $firstDayWeek);
        }

        if ($days > 13 && $days <= 30) {
            return new WeeklyProcessor($startDate, $endDate, $firstDayWeek);
        }

        return new DailyProcessor($startDate, $endDate, $firstDayWeek);
    }
}
