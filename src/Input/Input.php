<?php

namespace VendingMachine\Input;

use VendingMachine\Input\InputInterface;
use VendingMachine\Action\ActionInterface;
use VendingMachine\Money\MoneyCollectionInterface;

class Input implements InputInterface
{
    public function __construct(
        private ActionInterface $action,
        private MoneyCollectionInterface $moneyCollection,
    ) {}

	public function getAction(): ActionInterface
    {
        return $this->action;
    }

	public function getMoneyCollection(): MoneyCollectionInterface
    {
        return $this->moneyCollection;
    }
}
