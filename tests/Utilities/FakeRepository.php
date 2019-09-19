<?php

namespace Test\Utilities;

class FakeRepository
{
    public function between($startDate = null, $endDate = null)
    {
        return [
            'data'      => 'FakeRepository > between',
            'startDate' => $startDate,
            'endDate'   => $endDate
        ];
    }

    public function popular($startDate = null, $endDate = null, $param = null)
    {
        return [
            'data'      => 'FakeRepository > popular',
            'startDate' => isset($startDate) ? $startDate->format('d/m/Y 00:00:00') : $startDate,
            'endDate'   => isset($endDate) ? $endDate->format('d/m/Y 23:59:59') : $endDate,
            'parameter' => 'Parameter value: ' . $param
        ];
    }

    public function simpleWithParameterNoDate($param)
    {
        return $param;
    }

    public function simple()
    {
        return 'simple';
    }
}
