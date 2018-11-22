<?php

namespace ReportBuilder\Factories;

use ReportBuilder\ReportableCollection;
use ReportBuilder\ReportResults;

class ReportResultsFactory
{
    public static function make(ReportableCollection $reportables, array $parameters = null, array $dates = null)
    {
        $results = new ReportResults($reportables);

        $results = !is_null($parameters) ? $results->setParameters($parameters) : $results;
        $results = !is_null($dates) ? $results->setDates($dates) : $results;

        return $results;
    }
}
