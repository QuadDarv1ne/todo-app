<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

class PreventRequestsDuringMaintenance extends Middleware
{
    /**
     * URI, которые должны быть доступны во время режима обслуживания.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}