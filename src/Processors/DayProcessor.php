<?php

namespace ReportBuilder\Processors;

// use Carbon\CarbonPeriod;
use Carbon\Carbon;
use ReportBuilder\Contracts\Processor;
use ReportBuilder\Processors\Processor as Base;

class DayProcessor extends Base implements Processor
{
    public function make(): array
    {
        return [
            [
                'startDate' => (clone $this->startDate)->startOfDay(),
                'endDate'   => (clone $this->startDate)->endOfDay()
            ]
        ];
    }
}
