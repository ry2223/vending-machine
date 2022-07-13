<?php

declare(strict_types = 1);

namespace VendingMachine\Input;

use VendingMachine\Exception\InvalidInputException;
use VendingMachine\Input\InputInterface;
use VendingMachine\Input\Input;
use VendingMachine\Input\InputHandlerInterface;
use VendingMachine\Money\MoneyCollection;
use VendingMachine\Money\Money;
use VendingMachine\Action\Action;
use VendingMachine\VendingMachine;

class InputHandler implements InputHandlerInterface
{
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

        $action = new Action($input, $this->moneyCollection);

        if (preg_match('#\b(N|D|Q|DOLLAR|RETURN-MONEY|GET-A|GET-B|GET-C)\b#', $input)) {
            $this->vendingMachine->insertMoney(new Money($value, $input));
            $action->handle($this->vendingMachine);
        } else {
            throw new InvalidInputException();
        }
        
        return new Input($action, $this->moneyCollection);
    }

    private function getCoin(string $selection): float
    {
        $coinValue = 0.0;

        $coinValue = match ($selection) {
            'N' => $coinValue = 0.05,
            'D' => $coinValue = 0.1,
            'Q' => $coinValue = 0.25,
            'DOLLAR' => $coinValue = 1.0,
            default => $coinValue = 0.0,
        };

        return $coinValue;
    }
}
