<?php

namespace ReportBuilder\Laravel;

use Illuminate\Support\ServiceProvider;
use ReportBuilder\ReportBuilder;

class ReportBuilderServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind('ReportBuilder', function () {
            return ReportBuilder::make();
        });
    }


}