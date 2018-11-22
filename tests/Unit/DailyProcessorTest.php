<?php

namespace Test\Unit;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use ReportBuilder\Processors\DailyProcessor;

class DailyProcessorTest extends TestCase
{
    protected $processor;
    protected $dates;

    protected function setUp()
    {
        $this->processor = new DailyProcessor(Carbon::createFromDate(2018, 8, 7), Carbon::createFromDate(2018, 8, 17), 0);
        $this->dates = $this->processor->make();
        parent::setUp();
    }

    public function testShouldHaveSameLastDay()
    {
        $lastDay = Carbon::createFromDate(2018, 8, 17)->endOfDay();
        $this->assertEquals($lastDay, end($this->dates)['endDate']);
    }

    public function testShouldHaveElevenDays()
    {
        // counting with day 7 + 10 days
        $this->assertEquals(11, count($this->dates));
    }

    public function testShouldHaveSpecificDate()
    {
        $ds   = Carbon::createFromDate(2018, 8, 15)->startOfDay();
        $date = $this->dates[8]['startDate'];
        $this->assertEquals($date, $ds);
    }
}
