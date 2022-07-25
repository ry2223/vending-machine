<?php

require __DIR__ . "/vendor/autoload.php";

use VendingMachine\Exception\InvalidInputException;
use VendingMachine\Input\InputHandler;
use VendingMachine\Item\Item;
use VendingMachine\Item\ItemCode;
use VendingMachine\Item\ItemCollection;
use VendingMachine\Money\MoneyCollection;
use VendingMachine\VendingMachine;

$items = [
	new Item(0.65, 1, new ItemCode('A')),
	new Item(1.0, 1, new ItemCode('B')),
	new Item(1.5, 1, new ItemCode('C'))
];

$itemCollection = new ItemCollection();
$moneyCollection = new MoneyCollection();
$vendingMachine = new VendingMachine($moneyCollection, $itemCollection);
$moneyCollection->empty();
$inputHandler = new InputHandler($vendingMachine, $moneyCollection, $items);

foreach ($items as $item) {
	$vendingMachine->addItem($item);
}

while (true) {
	try {
		$input = $inputHandler->getInput();
		$action = $input->getAction();
		echo $action->handle($vendingMachine);
	} catch (InvalidInputException) {
		echo "WARNING! Action not allowed.\n\n";
	}
}
