<?php

namespace ReportBuilder\Processors;

use ReportBuilder\Contracts\Processor;
use ReportBuilder\Processors\Processor as Base;

class MonthlyProcessor extends Base implements Processor
{

    public function make(): array
    {
        $months = $this->startDate->diffInMonths($this->endDate);

        $ds    = (clone $this->startDate)->startOfMonth();

        $dates = [];

        for ($x=0; $x <= $months; $x++) {
            $dates[$x]['startDate'] = (clone $ds)->addMonths($x);
            $dates[$x]['endDate'] = (clone $dates[$x]['startDate'])->endOfMonth();
        }

        return $dates;
    }
}