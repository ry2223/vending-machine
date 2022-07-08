<?php

namespace VendingMachine\Money;

use VendingMachine\Money\Money;

class MoneyCollection implements MoneyCollectionInterface
{
    private array $collectedMoney;

    public function __construct() {
        $this->empty();
    }

    public function add(MoneyInterface $money): void
    {
        $this->collectedMoney[] = $money;

        //var_dump($money);
    }

    public function sum(): float
    {
        $sum = array_sum($this->collectedMoney);

        //var_dump($sum);

        return $sum;
    }

    public function merge(MoneyCollectionInterface $moneyCollection): void
    {
        
    }

    public function empty(): void
    {
        $this->collectedMoney = [];
    }

    /**
     * @return MoneyInterface[]
     */
    public function toArray(): array
    {
        return $this->collectedMoney;
    }
}
