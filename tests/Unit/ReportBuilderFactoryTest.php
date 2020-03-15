<?php

namespace Test\Unit;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use ReportBuilder\Processors\DailyProcessor;
use ReportBuilder\Processors\MonthlyProcessor;
use ReportBuilder\Processors\WeeklyProcessor;
use ReportBuilder\Factories\ReportBuilderFactory;

class ReportBuilderFactoryTest extends TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
    }

    public function testDefaultProcessorMustBeDaily()
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
