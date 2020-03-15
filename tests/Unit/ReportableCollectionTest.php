<?php

namespace Test\Unit;

use PHPUnit\Framework\TestCase;
use ReportBuilder\ReportableCollection;
use Tests\Utilities\FakeRepository;

class ReportableCollectionTest extends TestCase
{
    protected $collection;

    protected function setUp() : void
    {
        $this->collection = new ReportableCollection();
        parent::setUp();
    }

    public function testShouldHaveArrayOfItems()
    {
        $items = getProtectedValue($this->collection, 'items');
        $this->assertTrue(is_array($items));
    }

    public function testCanAddAndGetItems()
    {
        $this->collection->add(FakeRepository::class, 'popular');
        $items = [ FakeRepository::class => 'popular' ];
        $this->assertEquals($items, $this->collection->get());
    }

    public function testShouldAddArrayMethodsInItemsAndGet()
    {
        $items = [ FakeRepository::class => [ 'popular', 'between' ]];
        $this->collection->add(FakeRepository::class, [ 'popular', 'between']);
        $this->assertEquals($items, $this->collection->get());
    }
}
