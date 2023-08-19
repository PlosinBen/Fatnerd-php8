<?php

namespace App\Contracts;

trait InstanceTrait
{
    public static function make(): static
    {
        return app()->get(static::class);
    }
}
