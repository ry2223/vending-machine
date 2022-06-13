<?php

require_once 'src/Item/Item.php';
require_once 'src/Item/ItemCode.php';
require_once 'src/Exception/InvalidInputException.php';
require_once 'src/Input/InputHandler.php';

use VendingMachine\Item\Item;
use VendingMachine\Item\ItemCode;
use VendingMachine\Exception\InvalidInputException;
use VendingMachine\Input\InputHandler;

$itemArray = [
	new Item(0.65, 1, new ItemCode('A')),
	new Item(1.0, 1, new ItemCode('B')),
	new Item(1.5, 1, new ItemCode('C')),
];

while(true) {
	try {
		$input = $inputHandler->getInput();
		
		// Testy - PHPUnit (assert)
		
		
	}
	catch(InvalidInputException $e) {
		echo "Invalid input, try again...\n";
	}
}