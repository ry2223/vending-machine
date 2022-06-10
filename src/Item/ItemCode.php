<?php

namespace VendingMachine\Item;

class ItemCode implements ItemCodeInterface
{
	private string $code;

	public function __construct(string $code) {
		$this->code = $code;
	}

    public function __toString(): string {
    	return $this->code;
    }
}