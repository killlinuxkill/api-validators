<?php
namespace exactdata\validators\base;

interface ValidatorInterface
{
    public function config($config = []);

    public function validate($item = []);
}