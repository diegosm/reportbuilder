<?php

namespace ReportBuilder;

use ReportBuilder\Factories\ReportBuilderFactory;
use ReportBuilder\Factories\ReportResultsFactory;

class ReportBuilder
{
    /**
     * Results will apply methods
     * @var array
     */
    protected $datesInterval = [];

    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * @var ReportableCollection
     */
    protected $reportables;


    public function __construct()
    {
        $this->reportables = new ReportableCollection();
    }

    public static function make()
    {
        return new self();
    }

    /**
     * @param null $startDate
     * @param null $endDate
     * @param null $processor
     * @param int $firstDayWeek
     * @return $this
     */
    public function addPeriod($startDate = null, $endDate = null, $processor = null, $firstDayWeek = 0)
    {
        $processor = is_null($processor) ?
            ReportBuilderFactory::create($startDate, $endDate, $firstDayWeek) :
            new $processor($startDate, $endDate, $firstDayWeek);

        $this->datesInterval = $processor->make();
        return $this;
    }

    /**
     * @param $class
     * @param $methods
     * @return $this
     */
    public function addReportable($class, $methods)
    {
        $this->reportables->add($class, $methods);
        return $this;
    }

    /**
     * Can add many reportable at once
     *
     * @param array $array
     * @return $this
     */
    public function addReportables(array $array): self
    {
        foreach ($array as $class => $methods) {
            $this->addReportable($class, $methods);
        }

        return $this;
    }

    /**
     * Increase parameters
     *
     * @param array $parameters
     * @return ReportBuilder
     */
    public function addParameters(array $parameters): self
    {
        $this->parameters = array_merge($parameters, $this->parameters);
        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return ReportBuilder
     */
    public function addParameter($key, $value)
    {
        return $this->addParameters([ $key => $value ]);
    }

    /**
     * @return array
     */
    public function results(): array
    {
        return (ReportResultsFactory::make($this->reportables, $this->parameters, $this->datesInterval))->results();
    }
}
