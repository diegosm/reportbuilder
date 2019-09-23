<?php

namespace Test\Unit;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use ReportBuilder\Processors\DailyProcessor;

class DayProcessorTest extends TestCase
{
    protected $processor;
    protected $dates;

    protected function setUp()
    {
        $this->processor = new DailyProcessor(
            Carbon::createFromDate(2018, 8, 7)->startOfDay(),
            Carbon::createFromDate(2018, 8, 7)->endOfDay(),
            0
        );
        $this->dates = $this->processor->make();
        parent::setUp();
    }

    public function testShouldHaveSameLastDay()
    {
        $lastDay = Carbon::createFromDate(2018, 8, 7)->endOfDay();
        $this->assertEquals($lastDay, end($this->dates)['endDate']);
    }

    public function testShouldHaveOneDay()
    {
        $this->assertEquals(1, count($this->dates));
    }
}
