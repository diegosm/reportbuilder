<?php

namespace ReportBuilder\Contracts;

interface Processor
{
    public function make() : array;
}
