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

class InputHandler implements InputHandlerInterface
{
    private array $moneyCode = [];

    public function __construct(
        private VendingMachine $vendingMachine,
        private MoneyCollection $moneyCollection,
        private array $items,
    ) {}

    /**
     * @throws InvalidInputException
     */
    public function getInput(): InputInterface
    {
        $coinArray = [
            'DOLLAR' => 100,
            'Q' => 25,
            'D' => 10,
            'N' => 5
        ];

        $value = 0;
        $input = strtoupper(readline('Input: '));

        foreach ($coinArray as $coin => $coinValue) {
            if ($coin === $input) {
                $value = $coinValue;
            }
        }

        $money = new Money($value, $input);
        $action = new Action(
            $input,
            $this->vendingMachine,
            $money,
            $this->moneyCode,
            $this->items,
            $coinArray
        );

        if (preg_match('#^(N|D|Q|DOLLAR|RETURN-MONEY|GET-[A-C])$#', $input)) {
            if (preg_match('#^(N|D|Q|DOLLAR)$#', $input)) {
                $this->vendingMachine->insertMoney($money);
            }        
        } else {
            throw new InvalidInputException();
        }   

        return new Input($action, $this->moneyCollection);
    }
}
