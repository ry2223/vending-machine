<?php

declare(strict_types=1);

namespace VendingMachine\Money;

use VendingMachine\Money\MoneyCollectionInterface;

class MoneyCollection implements MoneyCollectionInterface
{
    private array $collectedMoney = [];

    public function add(MoneyInterface $money): void
    {
        $this->collectedMoney[] = $money;
    }
 
    public function sum(): float
    {
        $sum = 0;

        foreach ($this->collectedMoney as $value) {
            $sum += $value->getValue();
        }

        return $sum;
    }

    public function merge(MoneyCollectionInterface $moneyCollection): void
    {
        $this->collectedMoney = array_merge($this->collectedMoney, $this->toArray($moneyCollection));
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
