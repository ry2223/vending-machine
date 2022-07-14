<?php

declare(strict_types = 1);

namespace VendingMachine\Action;

use VendingMachine\Money\MoneyCollection;
use VendingMachine\Response\ResponseInterface;
use VendingMachine\Response\Response;
use VendingMachine\VendingMachineInterface;
use VendingMachine\Money\Money;

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
        $coin = $this->name;

        if ($coin === 'N' || $coin === 'D'|| $coin === 'Q' || $coin === 'DOLLAR') {

            $result = '';

            foreach ($this->moneyCollection as $value) {
                $result += $value->getCode();
            }
            $codeArray = explode(' ,', $result);

            foreach ($codeArray as $value) {
                $result = $value;
            }

            return new Response('Current balance: ' . $this->moneyCollection->sum() . $codeArray . PHP_EOL);
        }

        if ($coin === 'RETURN-MONEY') {
            

            return new Response('Response: RETURN-MONEY' . PHP_EOL);
        }

        if ($coin === 'GET-A' || $coin === 'GET-B' || $coin === 'GET-C') {

            return new Response("Response: $coin" . PHP_EOL);
        } else {

            return new Response('Item not found. Please choose another item.' . PHP_EOL);
        }
    }
}
