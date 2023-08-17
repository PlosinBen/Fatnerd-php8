<?php

namespace App\Contracts;

trait InstanceTrait
{
    public static function make()
    {
        return app()->get(static::class);
    }
}
