<?php

namespace App\Services\Math\Facade;

use App\Services\Math\Math as MathService;
use Illuminate\Support\Facades\Facade;

/**
 * @mixin MathService
 */
class Math extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MathService::class;
    }
}
