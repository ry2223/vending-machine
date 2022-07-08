<?php

require __DIR__ . "/vendor/autoload.php";

use VendingMachine\Item\Item;
use VendingMachine\Item\ItemCode;
use VendingMachine\Exception\InvalidInputException;
use VendingMachine\Input\InputHandler;
use VendingMachine\Money\Money;
use VendingMachine\Money\MoneyCollection;
use VendingMachine\VendingMachine;

$itemArray = [
	new Item(0.65, 1, new ItemCode('A')),
	new Item(1.0, 1, new ItemCode('B')),
	new Item(1.5, 1, new ItemCode('C')),
];

$moneyCollection = new MoneyCollection();
$vendingMachine = new VendingMachine($itemArray, $moneyCollection);
$inputHandler = new InputHandler($vendingMachine);

while (true) {
	try {
		$input = $inputHandler->getInput();

		// $this->vendingMachine->getCurrentTransactionMoney();
		
	} catch (InvalidInputException $e) {
		echo "Invalid input, try again...\n";
	}
}
