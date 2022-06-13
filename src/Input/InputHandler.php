<?php

namespace VendingMachine\Input;

use VendingMachine\Exception\InvalidInputException;
use VendingMachine\Input\InputInterface;
use VendingMachine\Money\MoneyCollection;
use VendingMachine\Money\Money;

class InputHandler implements InputHandlerInterface
{
    private MoneyCollection $moneyCollection;

    /**
     * @throws InvalidInputException
     */
	public function getInput(): InputInterface
    {
        $value = 0.0;

        $input = readline('Input: ');
        $value = $this->getValue($input);

        $this->moneyCollection->add(new Money($value, $input));

        // if($input) {
            
        // }
    }

    private function getValue(string $selection): float
    {
        switch($selection) {
            case 'N':
                $value = 0.05;
                break;
            case 'D':
                $value = 0.1;
                break;
            case 'Q':
                $value = 0.25;
                break;
            case 'DOLLAR':
                $value = 1.0;
                break;
        }

        return $value;
    }
}
