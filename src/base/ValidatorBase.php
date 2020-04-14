<?php
namespace exactdata\validators\base;

class ValidatorBase
{
    public function __construct(array $config = [])
    {
        $this->config($config);
    }
}