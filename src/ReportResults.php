<?php

namespace ReportBuilder;

class ReportResults
{
    protected $reportables;
    protected $dates;
    protected $parameters;

    /**
     * ReportResults constructor.
     * @param ReportableCollection $reportables
     */
    public function __construct(ReportableCollection $reportables)
    {
        $this->reportables = $reportables;
    }
    
    public static function make(ReportableCollection $reportables = null)
    {
        return new self($reportables);
    }

    /**
     * @param array $parameters
     * @return ReportResults
     */
    public function setParameters(array $parameters): self
    {
        $this->parameters = $parameters;
        return $this;
    }

    /**
     * @param array $dates
     * @return ReportResults
     */
    public function setDates(array $dates): self
    {
        $this->dates = $dates;
        return $this;
    }

    /**
     * Verify type of methods of all repositories and return results
     *
     * @return array
     */
    public function results()
    {
        return (isset($this->dates) && count($this->dates) > 0) ?
            $this->resultsWithDates() :
            $this->resultsWithoutDates();
    }

    /**
     *
     */
    private function resultsWithDates()
    {
        $data = [];

        for ($x = 0; $x < count($this->dates); $x++) {
            foreach ($this->reportables->get() as $reportable => $methods) {
                if (is_array($methods)) {
                    for ($y=0; $y<count($methods); $y++) {
                        $data[$reportable][$methods[$y]][] = $this->getResult(
                            $reportable,
                            $methods[$y],
                            $this->dates[$x]['startDate'],
                            $this->dates[$x]['endDate']
                        );
                    }
                } else {
                    $data[$reportable][] = $this->getResult(
                        $reportable,
                        $methods,
                        $this->dates[$x]['startDate'],
                        $this->dates[$x]['endDate']
                    );
                }
            }
        }

        return [ 'dates' => $this->dates, 'results' => $data];
    }


    private function resultsWithoutDates()
    {
        $data = [];

        foreach ($this->reportables->get() as $reportable => $methods) {
            if (is_array($methods)) {
                for ($y=0; $y<count($methods); $y++) {
                    $data[$reportable][$methods[$y]][] = $this->getResult($reportable, $methods[$y]);
                }
            } else {
                $data[$reportable] = $this->getResult($reportable, $methods);
            }
        }

        return [ 'results' => $data];
    }

    /**
     * Get result from repository method with parameters when exists
     *
     * @param $class
     * @param $method
     * @param null $startDate
     * @param null $endDate
     * @return mixed
     * @throws \ReflectionException
     */
    private function getResult($class, $method, $startDate = null, $endDate = null)
    {
        // Get Parameters from class and method
        $rClass = (new \ReflectionClass(new $class));
        $rClassParameters = $rClass->getMethod($method)->getParameters();

        $parameters = $this->getParameters($startDate, $endDate);

        $parameters2Method = [];

        // Put parameters in order according to order of method
        foreach ($rClassParameters as $param) {
            if ($parameters) {
                foreach ($parameters as $key => $value) {
                    if ($key == $param->name) {
                        $parameters2Method[] = $value;
                    }
                }
            }
        }

        return (new $class)->$method(...$parameters2Method);
    }

    private function getParameters($startDate = null, $endDate = null)
    {
        // if is only parameters
        if (isset($this->parameters) && !isset($startDate, $endDate)) {
            $parameters = $this->parameters;

        // if is parameters and dates
        } elseif (isset($this->parameters) && isset($startDate, $endDate)) {
            $parameters = array_merge([ 'startDate' => $startDate, 'endDate' => $endDate], $this->parameters);
        // if is only dates
        } elseif (isset($startDate, $endDate)) {
            $parameters = [ 'startDate' => $startDate, 'endDate' => $endDate];
        // if is without dates and parameters
        } else {
            $parameters = null;
        }

        return $parameters;
    }
}
