<?php

namespace Test\Unit;


use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use ReportBuilder\Processors\DailyProcessor;
use ReportBuilder\ReportableCollection;
use ReportBuilder\ReportResults;
use Test\Utilities\FakeRepository;

class ReportResultsTest extends TestCase
{

    protected $results;
    protected $reportables;
    protected $dates;


    protected function setUp()
    {
        $this->reportables = (new ReportableCollection())->add(FakeRepository::class, [ 'popular', 'between']);
        $this->dates = (new DailyProcessor(Carbon::now()->subDays(2), Carbon::now()))->make();
        $this->results = new ReportResults($this->reportables);
        parent::setUp();
    }

    public function testCouldBeInstantiateByStatic()
    {
        $obj = ReportResults::make($this->reportables);
        $this->assertInstanceOf(ReportResults::class, $obj);
    }

    public function testCouldAddParameters()
    {
        $this->results->setParameters(['key', 'value']);
        $this->assertTrue(is_array(getProtectedValue($this->results, 'parameters')));
    }

    public function testCouldAddDates()
    {
        $this->results->setDates(['date', 'date2']);
        $this->assertTrue(is_array(getProtectedValue($this->results, 'dates')));
    }


    // Could Have Dates
    public function testCouldHaveDatesInResultsMethod()
    {
        $this->results->setDates($this->dates);
        $data = $this->results->results();
        $dates = $data['dates'];
        $this->assertEquals($dates, getProtectedValue($this->results, 'dates'));
    }

    public function testCouldNotHaveParametersAndDates()
    {
        $reportables = (new ReportableCollection())->add(FakeRepository::class, 'simple');
        $results = (new ReportResults($reportables))->results();

        $this->assertEquals([ 'results' => [
            'Test\Utilities\FakeRepository' => 'simple'
        ]
        ], $results);
    }

    // Could Have Only Parameters
    public function testCouldHaveOnlyParameter()
    {
        $reportables = (new ReportableCollection())->add(FakeRepository::class, 'simpleWithParameterNoDate');
        $results = (new ReportResults($reportables))->setParameters(['param' => 'value'])->results();

        $this->assertEquals([ 'results' => [
            'Test\Utilities\FakeRepository' =>  'value'
        ]
        ], $results);

    }

    public function testCouldHaveParameterAndDatesInResults()
    {
        $reportables = (new ReportableCollection())->add(FakeRepository::class, 'popular');
        $results = (new ReportResults($reportables))
            ->setParameters(['param' => 'value'])
            ->setDates($this->dates)
            ->results();

        $this->assertArrayHasKey('dates', $results);
        $this->assertArrayHasKey('results', $results);
        $this->assertEquals(
            [
                'data' => 'FakeRepository > popular',
                'startDate' => Carbon::now()->format('d/m/Y 00:00:00'),
                'endDate' => Carbon::now()->format('d/m/Y 23:59:59'),
                'parameter' => 'Parameter value: value'
            ], end($results['results']['Test\Utilities\FakeRepository']));
    }


}