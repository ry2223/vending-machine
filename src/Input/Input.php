<?php

namespace VendingMachine\Input;

use VendingMachine\Action\ActionInterface;
use VendingMachine\Money\MoneyCollectionInterface;

class Input implements InputInterface
{
    private ActionInterface $action;
    private MoneyCollectionInterface $moneyCollection;

    public function __construct(ActionInterface $action, MoneyCollectionInterface $moneyCollection)
    {
        $this->action = $action;
        $this->moneyCollection = $moneyCollection;
    }

	public function getAction(): ActionInterface
    {
        return $this->action;
    }

	public function getMoneyCollection(): MoneyCollectionInterface
    {
        return $this->moneyCollection;
    }
}
