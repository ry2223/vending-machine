<?php

namespace VendingMachine\Input;

use VendingMachine\Exception\InvalidInputException;
use VendingMachine\Input\InputInterface;
use VendingMachine\Input\Input;
use VendingMachine\Input\InputHandlerInterface;
use VendingMachine\Money\MoneyCollection;
use VendingMachine\Money\Money;
use VendingMachine\Action\Action;
use VendingMachine\Response\Response;
use VendingMachine\VendingMachine;

class InputHandler implements InputHandlerInterface
{
    public function __construct(
        private VendingMachine $vendingMachine,
    ) {}

    /**
     * @throws InvalidInputException
     */
    public function getInput(): InputInterface
    {
        $input = strtoupper(readline('Input: '));
        $value = $this->getCoin($input);

        if (preg_match("/N|D|Q|DOLLAR/", $input) & $value != 0.0) {
            $this->vendingMachine->insertMoney(new Money($value, $input));
            
        } else if (preg_match("/GET-A|GET-B|GET-C|RETURN-MONEY/", $input)) {
            $action = new Action($input);
            $action->handle($this->vendingMachine);
        }

        return new Input($action, new MoneyCollection());
    }

    private function getCoin(string $selection): float
    {
        $coinValue = 0.0;
        
        switch ($selection) {
            case 'N':
                $coinValue = 0.05;
                break;
            case 'D':
                $coinValue = 0.1;
                break;
            case 'Q':
                $coinValue = 0.25;
                break;
            case 'DOLLAR':
                $coinValue = 1.0;
                break;
        }

        return $coinValue;
    }
}
