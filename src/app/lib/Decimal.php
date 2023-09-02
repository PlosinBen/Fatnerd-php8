<?php

namespace App\lib;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class Decimal implements Jsonable, Arrayable
{
    protected string $num;

    protected int $scale;

    public static function make($num = 0): Decimal
    {
        if ($num instanceof Decimal) {
            return $num;
        }

        return new Decimal($num);
    }

    public function __construct(string|int|float|null $num, int $scale = 2)
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

    /**
     * 加法
     * @param string|float|Decimal ...$nums
     * @return Decimal
     */
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

    /**
     * 減法
     * @param string|float|Decimal ...$nums
     * @return Decimal
     */
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

    /**
     * 乘法
     * @param string|int|float|Decimal $num
     * @return Decimal
     */
    public function mul(string|int|float|Decimal $num)
    {
        return static::make(
            bcmul($this->num, (string)$num)
        );
    }

    /**
     * 除法
     * @param string|int|float|Decimal $num
     * @return Decimal
     */
    public function div(string|int|float|Decimal $num)
    {
        if ($this->equal($num)) {
            return static::make(0);
        }

        return static::make(
            bcdiv($this->num, (string)$num)
        );
    }

    public function mod(string|int|float|Decimal $num)
    {
        return static::make(
            bcmod($this->num, (string)$num)
        );
    }

    public function equal(string|int|float|Decimal $num): bool
    {
        return bccomp($this->num, (string)$num) === 0;
    }

    public function moreThan(string|int|float|Decimal $num): bool
    {
        return bccomp($this->num, (string)$num) === 1;
    }

    public function lessThan(string|int|float|Decimal $num): bool
    {
        return bccomp($this->num, (string)$num) === -1;
    }

    public function min(string|int|float|Decimal $num): Decimal
    {
        return bccomp($this->num, (string)$num) === 1 ? static::make($num) : $this;
    }

    public function max(string|int|float|Decimal $num): Decimal
    {
        return bccomp($this->num, (string)$num) === -1 ? static::make($num) : $this;
    }

    public function floor(): Decimal
    {
        $remainder = bcmod($this->num, 1);

        $res = bcsub($this->num, $remainder);

        if ($remainder < 0) {
            $res = bcsub($res, 1);
        }

        return static::make($res);
    }

    public function toArray()
    {
        return $this->get();
    }
}
