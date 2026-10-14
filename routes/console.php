<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('plotpoint:about', function () {
    $this->comment('PlotPoint Tanzania — Find Your Plot. Know Its Location. Make Your Move.');
})->purpose('Display PlotPoint project information');
