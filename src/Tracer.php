<?php

class Tracer
{
    public function __construct()
    {
        //
    }

    public static function make(...$args): self
    {
        return new self(...$args);
    }
}
