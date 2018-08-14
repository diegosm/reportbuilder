<?php

namespace ReportBuilder\Processors;

use ReportBuilder\Contracts\Processor;
use ReportBuilder\Processors\Processor as Base;

class MonthlyProcessor extends Base implements Processor
{


    protected $dates = [];

    public function make(): array
    {

        $final = $this->getFinalDate();

        $sd = (clone $this->startDate)->startOfMonth()->startOfDay();
        $ed = (clone $sd)->endOfMonth()->endOfDay();

        $this->dates[] = [ 'startDate' => $sd, 'endDate' => $ed];

         if ( $final->ne($sd)) {
            $this->addMonth($final, $sd);
        }

        return $this->dates;
    }


    private function getFinalDate()
    {
        return (clone $this->endDate)->startOfMonth()->startOfDay();
    }

    private function addMonth($final, $current)
    {

        $i = $this->getIndice();

        $start = (clone $current)->addMonth(1);
        $end   = (clone $start)->endOfMonth()->endOfDay();

        $this->dates[$i]['startDate'] = $start;
        $this->dates[$i]['endDate'] = $end;

        if ( $final->ne($start) ) {
            $this->addMonth($final, $start);
        }

    }

    private function getIndice()
    {
        return count($this->dates);
    }
}