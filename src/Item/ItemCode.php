<?php

namespace VendingMachine\Item;

use VendingMachine\Item\ItemCodeInterface;

class ItemCode implements ItemCodeInterface
{
	public function __construct(
		private string $code,
	) {}
	
    public function __toString(): string {
    	return $this->code;
    }
}