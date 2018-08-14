<?php

namespace Test\Unit;


use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use ReportBuilder\Factories\ReportResultsFactory;
use ReportBuilder\Processors\DailyProcessor;
use ReportBuilder\ReportableCollection;
use ReportBuilder\ReportResults;
use Tests\Utilities\FakeRepository;

class ReportResultsFactoryTest extends TestCase
{

    protected $reportables;
    protected $dates;
    protected $parameters;

    protected function setUp()
    {
        $this->reportables = (new ReportableCollection())->add(FakeRepository::class, 'popular');
        $this->dates = (new DailyProcessor(Carbon::createFromDate(2018,8,7), Carbon::createFromDate(2018,8,17), 0))->make();
        $this->parameters =  [
            'param' => 'val',
            'parameter' => 'value'
        ];

        parent::setUp();
    }

    public function testMustReturnInstanceOfReportResults()
    {
        $factory = ReportResultsFactory::make($this->reportables);
        $this->assertInstanceOf(ReportResults::class, $factory);
    }

    public function testShouldAddParameters()
    {
        $factory = ReportResultsFactory::make($this->reportables, $this->parameters);

        $parameters = getProtectedValue($factory, 'parameters');

        $this->assertEquals($this->parameters, $parameters);
    }


    public function testShouldAddDates()
    {
        $factory = ReportResultsFactory::make($this->reportables, null, $this->dates );
        $datesFromFactory = getProtectedValue($factory, 'dates');
        $this->assertEquals(11, count($datesFromFactory));
        $this->assertInstanceOf(Carbon::class, $datesFromFactory[0]['startDate']);
    }


    public function testShouldAddParametersAndDates()
    {

        $factory = ReportResultsFactory::make($this->reportables, $this->parameters, $this->dates );
        $parameters = getProtectedValue($factory, 'parameters');
        $dates = getProtectedValue($factory, 'dates');

        $this->assertEquals($this->parameters, $parameters);
        $this->assertEquals(11, count($dates));
        $this->assertInstanceOf(Carbon::class, $dates[0]['startDate']);
    }


}