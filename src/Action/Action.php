<?php

namespace VendingMachine\Action;

use VendingMachine\Money\MoneyCollection;
use VendingMachine\Response\ResponseInterface;
use VendingMachine\Response\Response;
use VendingMachine\VendingMachineInterface;

class Action implements ActionInterface
{
    public function __construct(
        private string $name,
        private MoneyCollection $moneyCollection,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function handle(VendingMachineInterface $vendingMachine): ResponseInterface
    {
        if ($this->name == 'N' || $this->name == 'D'|| $this->name == 'Q' || $this->name == 'DOLLAR') {
            
            return new Response('Current balance: ' . $this->moneyCollection->sum() . PHP_EOL);
        }

        if ($this->name == 'RETURN-MONEY') {

            return new Response('Response: RETURN-MONEY' . PHP_EOL);
        } else {

            return new Response('Response: NOT RETURN-MONEY' . PHP_EOL);
        }
    }
}
