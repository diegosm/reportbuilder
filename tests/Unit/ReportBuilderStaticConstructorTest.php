<?php

namespace Test\Unit;

use PHPUnit\Framework\TestCase;
use ReportBuilder\ReportBuilder;

class ReportBuilderStaticConstructorTest extends TestCase
{

    protected $builder;

    protected function setUp()
    {
        $this->builder = ReportBuilder::make();
        parent::setUp();
    }

    public function testItCanMakeNewInstanceFromStatic()
    {
        $this->assertInstanceOf(ReportBuilder::class, $this->builder);
    }

}