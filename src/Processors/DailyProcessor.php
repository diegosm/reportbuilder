<?php

namespace ReportBuilder\Processors;

// use Carbon\CarbonPeriod;
use Carbon\Carbon;
use ReportBuilder\Contracts\Processor;
use ReportBuilder\Processors\Processor as Base;

class DailyProcessor extends Base implements Processor
{


    public function make(): array
    {

        $days = $this->startDate->diffInDays($this->endDate);
        $ds    = (clone $this->startDate)->startOfDay();

        $dates = [];

        for ($x=0; $x <= $days; $x++) {
            $dates[$x]['startDate'] = (clone $ds)->addDays($x);
            $dates[$x]['endDate'] = (clone $dates[$x]['startDate'])->endOfDay();
        }

        return $dates;

    }


}