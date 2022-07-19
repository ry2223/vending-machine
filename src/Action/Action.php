<?php

declare(strict_types=1);

namespace VendingMachine\Action;

use VendingMachine\Exception\ItemNotFoundException;
use VendingMachine\Money\MoneyCollection;
use VendingMachine\Response\ResponseInterface;
use VendingMachine\Response\Response;
use VendingMachine\VendingMachineInterface;
use VendingMachine\Money\Money;
use VendingMachine\VendingMachine;

class Action implements ActionInterface
{
    public function __construct(
        private string $name,
        private MoneyCollection $moneyCollection,
        private VendingMachine $vendingMachine,
        private Money $money,
        private array &$moneyCode,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function handle(VendingMachineInterface $vendingMachine): ResponseInterface
    {
        $action = $this->name;

        if (preg_match('#\b(N|D|Q|DOLLAR)\b#', $action)) {
            $this->moneyCode[] = $this->money->getCode();
            $implodedCode = implode(', ', $this->moneyCode);
            
            $sumString = strval($this->vendingMachine->getCurrentTransactionMoney()->sum());
            $moneySum = sprintf('%.2f', $sumString);

            return new Response('Current balance: ' . $moneySum . ' (' . $implodedCode . ') ' . PHP_EOL);
        }

        try {
            if (preg_match('#\b(RETURN-MONEY)\b#', $action)) {
                $vendingMachine->getInsertedMoney();
                $implodedCode = implode(', ', $this->moneyCode);
                $this->moneyCode = []; // TO-DO: change passing data by reference to passing by value

                return new Response($implodedCode . PHP_EOL);
            }

            if (preg_match('#\b(GET-A|GET-B|GET-C)\b#', $action)) {

                // else {
                //     throw new ItemNotFoundException();
                // }

                return new Response("Response: $action" . PHP_EOL);
            }
        } catch (ItemNotFoundException) {
            echo 'Item not found. Please choose another item.' . PHP_EOL;
        }
    }
}
