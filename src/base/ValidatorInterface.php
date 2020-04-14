<?php
namespace exactdata\validators\base;

interface ValidatorInterface
{
    public function config(array $config = []): void;

    public function validate(array $item = []): bool;
}