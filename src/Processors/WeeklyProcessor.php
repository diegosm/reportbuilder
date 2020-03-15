<?php

namespace ReportBuilder\Processors;

use Carbon\Carbon;
use ReportBuilder\Contracts\Processor;
use ReportBuilder\Processors\Processor as Base;

class WeeklyProcessor extends Base implements Processor
{
    protected $dates = [];

    public function make(): array
    {
        $final = $this->getFinalDate();

        $sd = (clone $this->startDate)->startOfWeek();
        $ed = (clone $sd)->addDays(6)->endOfDay();

        $this->dates[] = [ 'startDate' => $sd, 'endDate' => $ed];

        if ($final->ne($sd)) {
            $this->addWeek($final, $sd);
        }

        return $this->dates;
    }

    /**
     * return date to stop loop
     * @return Carbon
     */
    private function getFinalDate()
    {
        return (clone $this->endDate)->startOfWeek()->startOfDay();
    }

    /**
     * Recursive method to verify if needed adds a week
     * @param $final
     * @param $current
     */
    private function addWeek($final, $current)
    {
        $i = $this->getIndice();

        $start = (clone $current)->addWeek(1);
        $end   = (clone $start)->addDays(6)->endOfDay();

        $this->dates[$i]['startDate'] = $start;
        $this->dates[$i]['endDate'] = $end;

        if ($final->ne($start)) {
            $this->addWeek($final, $start);
        }
    }

    private function getIndice()
    {
        return count($this->dates);
    }
}
