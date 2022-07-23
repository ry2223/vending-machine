<?php

namespace VendingMachine\Money;

use VendingMachine\Money\MoneyInterface;

class Money implements MoneyInterface
{
    public function __construct(
        private float $value,
        private string $code,
    ) {}

    public function getValue(): float
    {
        return $this->value;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}
