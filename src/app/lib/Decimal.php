<?php

namespace App\lib;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class Decimal implements Jsonable, Arrayable
{
    protected string $num;

    protected int $scale;

    public static function make($num): Decimal
    {
        if ($num instanceof Decimal) {
            return $num;
        }

        return new Decimal($num);
    }

    public function __construct(string|int|float $num = '0', int $scale = 2)
    {
        $this->num = (string)($num ?? 0);

        $this->scale = $scale;
    }

    public function __toString(): string
    {
        return $this->num;
    }

    public function toJson($options = 0): string
    {
        return $this->get();
    }

    public function get(): string
    {
        return $this->num;
    }

    public function add(string|float|Decimal ...$nums): Decimal
    {
        $res = $this->num;

        foreach ($nums as $num) {
            $res = bcadd(
                $res,
                (string)$num
            );
        }

        return static::make($res);
    }

    public function sub(string|float|Decimal ...$nums): Decimal
    {
        $res = $this->num;

        foreach ($nums as $num) {
            $res = bcsub(
                $res,
                (string)$num
            );
        }

        return static::make($res);
    }

    public function div(string|int|float|Decimal $num)
    {
        if ($this->equal($num)) {
            return static::make(0);
        }

        return static::make(
            bcdiv($this->num, (string)$num)
        );
    }

    public function equal(string|int|float|Decimal $num): bool
    {
        return bccomp($this->num, (string)$num) === 0;
    }

    public function min(string|int|float|Decimal $num): Decimal
    {
        return bccomp($this->num, (string)$num) ? static::make($num) : $this;
    }

    public function toArray()
    {
        return $this->get();
    }
}
