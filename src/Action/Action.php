<?php

declare(strict_types=1);

namespace VendingMachine\Action;

use VendingMachine\Action\ActionInterface;
use VendingMachine\Exception\ItemNotFoundException;
use VendingMachine\Item\ItemCollection;
use VendingMachine\Money\MoneyCollection;
use VendingMachine\Response\ResponseInterface;
use VendingMachine\Response\Response;
use VendingMachine\VendingMachineInterface;
use VendingMachine\Money\Money;
use VendingMachine\VendingMachine;

class Action implements ActionInterface
{
    private array $itemCodeArray = [];

    public function __construct(
        private string $name,
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
        if (preg_match('#\b(N|D|Q|DOLLAR)\b#', $this->name)) {
            $this->moneyCode[] = $this->money->getCode();
            $implodedCode = implode(', ', $this->moneyCode);

            $sumString = strval($this->vendingMachine->getCurrentTransactionMoney()->sum());
            $moneySum = sprintf('%.2f', $sumString);

            return new Response('Current balance: ' . $moneySum . ' (' . $implodedCode . ') ' . PHP_EOL);
        }

        try {
            if (preg_match('#\b(RETURN-MONEY)\b#', $this->name)) {
                $vendingMachine->getInsertedMoney();
                $implodedCode = implode(', ', $this->moneyCode);
                $this->moneyCode = [];

                return new Response($implodedCode . PHP_EOL);
            }

            if (preg_match('#\b(GET-A|GET-B|GET-C)\b#', $this->name)) {
                if ($this->name === 'GET-A') {


                    return new Response('You have bought: A!' . PHP_EOL);
                } elseif ($this->name === 'GET-B') {

                    return new Response($this->name . PHP_EOL);
                } elseif ($this->name === 'GET-C') {

                    return new Response($this->name . PHP_EOL);
                }

                // else {
                //     throw new ItemNotFoundException();
                // }
            }
        } catch (ItemNotFoundException) {
            echo 'Item not found. Please choose another item.' . PHP_EOL;
        }
    }
}
