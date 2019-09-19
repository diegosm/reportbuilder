<?php

namespace Test\Unit;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use ReportBuilder\Processors\DailyProcessor;
use ReportBuilder\Processors\DayProcessor;
use ReportBuilder\Processors\MonthlyProcessor;
use ReportBuilder\Processors\WeeklyProcessor;
use ReportBuilder\Factories\ReportBuilderFactory;

class ReportBuilderFactoryTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    public function testDefaultProcessorMustBeDay()
    {
        $obj = ReportBuilderFactory::create(
            Carbon::createFromFormat('Y-m-d H:i:s', '2019-9-19 00:00:00')->startOfDay(),
            Carbon::createFromFormat('Y-m-d H:i:s', '2019-9-19 00:00:00')->endOfDay()
        );

        $this->assertInstanceOf(DayProcessor::class, $obj);
    }

    public function tesProcessorMustBeDaily()
    {
        $obj = ReportBuilderFactory::create(Carbon::now(), Carbon::now()->addDays(13));
        $this->assertInstanceOf(DailyProcessor::class, $obj);
    }

    public function testMustBeWeeklyProcessor()
    {
        $obj = ReportBuilderFactory::create(Carbon::now(), Carbon::now()->addDays(30));
        $this->assertInstanceOf(WeeklyProcessor::class, $obj);
    }

    public function testMustBeMonthlyProcessor()
    {
        $obj = ReportBuilderFactory::create(Carbon::now(), Carbon::now()->addDays(60));
        $this->assertInstanceOf(MonthlyProcessor::class, $obj);
    }
}
