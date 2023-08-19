<?php

echo 1111111;
exit;

function bcadds(string|int|float $num, string|int|float ...$nums): string
{
    foreach ($nums as $v) {
        $num = bcadd($num, $v);
    }

    return $num;
}

function bcsubs(string|int|float $num, string|int|float ...$nums): string
{
    foreach ($nums as $v) {
        $num = bcsub($num, $v);
    }

    return $num;
}
