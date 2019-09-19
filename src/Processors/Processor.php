<?php

namespace ReportBuilder\Processors;

use Carbon\Carbon;

class Processor
{
    protected $startDate;
    protected $endDate;

    public function __construct(Carbon $startDate = null, Carbon $endDate = null, $firstDayWeek = 0)
    {
        Carbon::setWeekStartsAt($firstDayWeek);
        $this->startDate = $startDate ?: Carbon::now();
        $this->endDate = $endDate ?: Carbon::now()->addDays(30);

        // verifica se data inicial é maior ou igual a final, se for retorna erro.
        if ($this->startDate->gte($this->endDate)) {
            throw new \Exception('Error, start date must be inferior end date');
        }
    }
}
