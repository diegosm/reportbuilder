<?php

namespace ReportBuilder\Factories;


use Carbon\Carbon;
use ReportBuilder\Processors\DailyProcessor;
use ReportBuilder\Processors\MonthlyProcessor;
use ReportBuilder\Processors\WeeklyProcessor;

class ReportBuilderFactory
{

    public static function create(Carbon $startDate, Carbon $endDate, $firstDayWeek=0)
    {
        $days = $startDate->diffInDays($endDate);

        switch($days) {

            case ($days > 30 ) :
                return new MonthlyProcessor($startDate, $endDate, $firstDayWeek);
            break;

            case ($days > 13 && $days <= 30):
                return new WeeklyProcessor($startDate, $endDate, $firstDayWeek);
            break;

            default:
                return new DailyProcessor($startDate, $endDate, $firstDayWeek);
        }

    }
}