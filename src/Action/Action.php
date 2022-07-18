<?php

declare(strict_types=1);

namespace VendingMachine\Action;

use VendingMachine\Exception\ItemNotFoundException;
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
        private Money $money,
        private array &$moneyCode,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function handle(VendingMachineInterface $vendingMachine): ResponseInterface
    {
        $coin = $this->name;

        if (preg_match('#\b(N|D|Q|DOLLAR)\b#', $coin)) {
            $this->moneyCode[] = $this->money->getCode();
            $implodedCode = implode(', ', $this->moneyCode);
            
            $sumString = strval($this->moneyCollection->sum());
            $moneySum = sprintf('%.2f', $sumString);

            return new Response('Current balance: ' . $moneySum . ' (' . $implodedCode . ') ' . PHP_EOL);
        }

        try {
            if (preg_match('#\b(RETURN-MONEY)\b#', $coin)) {


                return new Response('Response: RETURN-MONEY' . PHP_EOL);
            }

            if (preg_match('#\b(GET-A|GET-B|GET-C)\b#', $coin)) {

                // else {
                //     throw new ItemNotFoundException();
                // }

                return new Response("Response: $coin" . PHP_EOL);
            }
        } catch (ItemNotFoundException) {
            echo 'Item not found. Please choose another item.' . PHP_EOL;
        }
    }
}
