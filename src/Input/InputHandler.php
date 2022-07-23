<?php

declare(strict_types=1);

namespace VendingMachine\Input;

use VendingMachine\Input\InputHandlerInterface;
use VendingMachine\Exception\InvalidInputException;
use VendingMachine\Input\InputInterface;
use VendingMachine\Input\Input;
use VendingMachine\Money\MoneyCollection;
use VendingMachine\Money\Money;
use VendingMachine\Action\Action;
use VendingMachine\VendingMachine;
use VendingMachine\Item\Item;
use VendingMachine\Item\ItemCode;

class InputHandler implements InputHandlerInterface
{
    private $moneyCode = [];

    public function __construct(
        private VendingMachine $vendingMachine,
        private MoneyCollection $moneyCollection,
    ) {}

    /**
     * @throws InvalidInputException
     */
    public function getInput(): InputInterface
    {
        $input = strtoupper(readline('Input: '));
        $value = $this->getCoin($input);

        $money = new Money($value, $input);
        $action = new Action(
            $input,
            $this->vendingMachine,
            $money,
            $this->moneyCode
        );

        if (preg_match('#\b(N|D|Q|DOLLAR|RETURN-MONEY|GET-A|GET-B|GET-C)\b#', $input)) {
            $this->vendingMachine->insertMoney($money);
        } else {
            throw new InvalidInputException();
        }

        return new Input($action, $this->moneyCollection);
    }

    private function getCoin(string $selection): float
    {
        $coinValue = match ($selection) {
            'N' => $coinValue = 0.05,
            'D' => $coinValue = 0.1,
            'Q' => $coinValue = 0.25,
            'DOLLAR' => $coinValue = 1.0,
            default => $coinValue = 0.0,
        };

        return $coinValue;
    }

    public function createItems()
    {
        $items = [
            new Item(0.65, 1, new ItemCode('A')),
            new Item(1.0, 1, new ItemCode('B')),
            new Item(1.5, 1, new ItemCode('C'))
        ];
    }
}
