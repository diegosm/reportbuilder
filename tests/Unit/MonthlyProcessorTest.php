<?php

namespace Test\Unit;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use ReportBuilder\Processors\MonthlyProcessor;

class MonthlyProcessorTest extends TestCase
{
    public function testShouldHave1Month()
    {
        $start = Carbon::createFromDate(2018, 7, 15);
        $end   = Carbon::createFromDate(2018, 7, 31);

        $dates = (new MonthlyProcessor($start, $end))->make();
        $this->assertEquals(1, count($dates));
    }

    public function testShouldHave2Months()
    {
        $start = Carbon::createFromDate(2018, 7, 15);
        $end   = Carbon::createFromDate(2018, 8, 31);

        $dates = (new MonthlyProcessor($start, $end))->make();
        $this->assertEquals(2, count($dates));
    }

    public function testShouldHaveSameStartDate()
    {
        for ($x=0; $x < rand(0, 50); $x++) {
            $startOfWeek = rand(0, 6);
            Carbon::setWeekStartsAt($startOfWeek);
            $start = Carbon::now()->subDays(rand(40, 120))->startOfDay();
            $end = Carbon::now()->subDays(rand(0, 39));

            $dates  = (new MonthlyProcessor($start, $end, $startOfWeek))->make();

            $expected = (clone $start)->startOfMonth()->startOfDay();
            $this->assertEquals($dates[0]['startDate'], $expected);
        }
    }


    public function testShoudHaveSameEndDate()
    {
        for ($x=0; $x < rand(0, 50); $x++) {
            $startOfWeek = rand(0, 6);
            Carbon::setWeekStartsAt($startOfWeek);
            $start = Carbon::now()->subDays(rand(40, 120))->startOfDay();
            $end = Carbon::now()->subDays(rand(0, 39));

            $dates  = (new MonthlyProcessor($start, $end, $startOfWeek))->make();

            $expected = (clone $end)->endOfMonth()->endOfDay();
            $this->assertEquals(end($dates)['endDate'], $expected);
        }
    }
}
