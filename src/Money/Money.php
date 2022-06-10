<?php

namespace VendingMachine\Money;

class Money implements MoneyInterface
{
    private float $value;
	private string $code;

    public function __construct(float $value, string $code) {
		$this->value = $value;
		$this->code = $code;
	}

    public function getValue(): float
    {
        return $this->value;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}
