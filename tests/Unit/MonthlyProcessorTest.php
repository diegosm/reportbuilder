<?php

namespace Test\Unit;


use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use ReportBuilder\Processors\MonthlyProcessor;

class MonthlyProcessorTest extends TestCase
{

    protected $processor;
    protected $dates;

    protected function setUp()
    {
        $this->processor = new MonthlyProcessor(Carbon::now(), Carbon::now()->addDays(45), 0);
        $this->dates = $this->processor->make();
        parent::setUp();
    }

    public function testShouldHaveSameStartDate()
    {
        $start = Carbon::now()->startOfMonth();
        $this->assertEquals($start, $this->dates[0]['startDate']);
    }

    public function testShouldHaveSameEndDate()
    {
        $end = Carbon::now()->addDays(45)->endOfMonth();
        $this->assertEquals($end, end($this->dates)['endDate']);
    }

}