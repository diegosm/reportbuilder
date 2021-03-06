<?php

namespace Test\Unit;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use ReportBuilder\Processors\MonthlyProcessor;
use ReportBuilder\Processors\WeeklyProcessor;
use ReportBuilder\ReportableCollection;
use ReportBuilder\ReportBuilder;
use Test\Utilities\FakeRepository;

class ReportBuilderTest extends TestCase
{
    protected $builder;

    protected function setUp() : void
    {
        $this->builder = new ReportBuilder();
        $this->builder->addPeriod(Carbon::parse("2018-10-11"), Carbon::parse("2018-10-16"), null, 1);
        parent::setUp();
    }

    public function testShouldHaveDatesInterval()
    {
        $this->assertAttributeNotEmpty('datesInterval', $this->builder);
    }

    public function testShouldHaveSixDaysInDatesInterval()
    {
        $dates = getProtectedValue($this->builder, 'datesInterval');
        $this->assertEquals(6, count($dates));
    }

    public function testShouldAddPeriodWithMonthlyProcessor()
    {
        $this->builder->addPeriod(Carbon::parse("2018-11-22"), Carbon::parse("2018-12-20"), MonthlyProcessor::class, 0);
        $dates = getProtectedValue($this->builder, 'datesInterval');
        $this->assertEquals(2, count($dates));
    }

    public function testMustHaveReportableCollection()
    {
        $reportable = getProtectedValue($this->builder, 'reportables');
        $this->assertInstanceOf(ReportableCollection::class, $reportable);
    }


    public function testShouldAddParameter()
    {
        $this->builder->addParameter('key', 'value');

        $parameters = getProtectedValue($this->builder, 'parameters');
        $this->assertEquals([ 'key' => 'value'], $parameters);
    }


    public function testShouldAddArrayOfReportables()
    {
        $reportables = [
            'FakeRepository::class' => ['all', 'between'],
            'OtherClass::class' => 'myMethod'
        ];

        $this->builder->addReportables($reportables);

        $expected = getProtectedValue($this->builder, 'reportables');

        $this->assertEquals($expected->get(), $reportables);
    }
}
