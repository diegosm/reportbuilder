<?php

namespace ReportBuilder;

class ReportableCollection
{
    private $items = [];

    public function add($class, $methods)
    {
        $this->items[$class] = $methods;
        return $this;
    }

    public function get()
    {
        return $this->items;
    }
}
