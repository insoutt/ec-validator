<?php

namespace Insoutt\EcValidator\Traits;

trait Makeable
{
    public static function make(...$args)
    {
        return new static(...$args);
    }
}
