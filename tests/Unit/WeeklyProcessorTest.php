<?php

namespace Test\Unit;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use ReportBuilder\Contracts\Processor;
use ReportBuilder\Processors\WeeklyProcessor;

class WeeklyProcessorTest extends TestCase
{
    protected $processor;

    protected function setUp() : void
    {
        $this->processor = new WeeklyProcessor(
            Carbon::createFromDate(2018, 7, 31),
            Carbon::createFromDate(2018, 8, 6),
            0
        );

        parent::setUp();
    }

    public function testMustImplementProcessorContract()
    {
        $this->assertInstanceOf(Processor::class, $this->processor);
    }

    public function testMakeMethodShouldReturnArray()
    {
        $this->assertTrue(is_array($this->processor->make()));
    }

    public function testMustStartInSunday()
    {
        $dates = $this->processor->make();
        $this->assertEquals($dates[0]['startDate']->dayOfWeek, Carbon::SUNDAY);
    }

    public function testMustTerminateInSameDate()
    {
        for ($x=0; $x< 50; $x++) {
            $startWeek = rand(0, 5);
            Carbon::setWeekStartsAt($startWeek);

            $start = Carbon::now()->subDays(rand(21, 80));
            $end = Carbon::now()->subDays(rand(0, 20));

            $expected = (clone $end)->startOfWeek()->addDays(6)->endOfDay();

            $dates = (new WeeklyProcessor($start, $end, $startWeek))->make();

            $this->assertEquals($expected, end($dates)['endDate']);
        }
    }
}
