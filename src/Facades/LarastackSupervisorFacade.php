<?php

namespace Ariadata\LarastackSupervisor\Facades;

use Illuminate\Support\Facades\Facade;
class LarastackSupervisorFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'larastack-supervisor';
    }
}
