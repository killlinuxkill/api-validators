<?php
namespace exactdata\validators\base;

class ValidatorBase
{
    public function __construct($config = [])
    {
        $this->config($config);
    }
}