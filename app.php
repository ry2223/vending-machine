<?php

require __DIR__ . "/vendor/autoload.php";

use VendingMachine\Item\Item;
use VendingMachine\Item\ItemCode;
use VendingMachine\Exception\InvalidInputException;
use VendingMachine\Input\InputHandler;
use VendingMachine\Item\ItemCollection;
use VendingMachine\Money\MoneyCollection;
use VendingMachine\VendingMachine;

$items = [
	new Item(0.65, 1, new ItemCode('A')),
	new Item(1.0, 1, new ItemCode('B')),
	new Item(1.5, 1, new ItemCode('C')),
];

foreach ($items as $item) {
	$item;
	$itemCode = $item->getCode();
}

$moneyCollection = new MoneyCollection();
$moneyCollection->empty();
$itemCollection = new ItemCollection($items);
$vendingMachine = new VendingMachine($moneyCollection, $itemCollection);
$inputHandler = new InputHandler(
	$vendingMachine,
	$moneyCollection,
	$itemCollection,
	$item,
	$itemCode
);

while (true) {
	try {
		$input = $inputHandler->getInput();
		$action = $input->getAction();
		echo $action->handle($vendingMachine);
	} catch (InvalidInputException) {
		echo "WARNING! Action not allowed...\n\n";
	}
}
