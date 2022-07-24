<?php

require __DIR__ . "/vendor/autoload.php";

use VendingMachine\Exception\InvalidInputException;
use VendingMachine\Input\InputHandler;
use VendingMachine\Item\ItemCollection;
use VendingMachine\Money\MoneyCollection;
use VendingMachine\VendingMachine;

$itemCollection = new ItemCollection();
$moneyCollection = new MoneyCollection();
$vendingMachine = new VendingMachine($moneyCollection, $itemCollection);
$moneyCollection->empty();
$inputHandler = new InputHandler($vendingMachine, $moneyCollection);
$inputHandler->createItems();
$inputHandler->addItems();

while (true) {
	try {
		$input = $inputHandler->getInput();
		$action = $input->getAction();
		echo $action->handle($vendingMachine);
	} catch (InvalidInputException) {
		echo "WARNING! Action not allowed...\n\n";
	}
}
