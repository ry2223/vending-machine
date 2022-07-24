<?php

declare(strict_types=1);

namespace VendingMachine;

use VendingMachine\VendingMachineInterface;
use VendingMachine\Item\ItemCodeInterface;
use VendingMachine\Item\ItemCollection;
use VendingMachine\Item\ItemInterface;
use VendingMachine\Money\MoneyCollection;
use VendingMachine\Money\MoneyCollectionInterface;
use VendingMachine\Money\MoneyInterface;

class VendingMachine implements VendingMachineInterface
{
    public function __construct(
        private MoneyCollection $moneyCollection,
        private ItemCollection $itemCollection,
    ) {}

    public function addItem(ItemInterface $item): void
    {
        $this->itemCollection->add($item);
    }

    public function dropItem(ItemCodeInterface $itemCode): void
    {
        $this->itemCollection->get($itemCode);
        $this->itemCollection->count($itemCode);
    }

    public function insertMoney(MoneyInterface $money): void
    {
        $this->moneyCollection->add($money);
    }

    public function getCurrentTransactionMoney(): MoneyCollectionInterface
    {
        return $this->moneyCollection;
    }

    public function getInsertedMoney(): MoneyCollectionInterface
    {
        $money = clone $this->moneyCollection;
        $this->moneyCollection->empty();

        return $money;
    }
}
