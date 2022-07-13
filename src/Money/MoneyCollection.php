<?php

declare(strict_types = 1);

namespace VendingMachine\Money;

class MoneyCollection implements MoneyCollectionInterface
{
    private array $collectedMoney;

    public function add(MoneyInterface $money): void
    {
        $this->collectedMoney[] = $money;
    }

    public function sum(): float
    {
        $arr = $this->collectedMoney;
        $sum = 0.0;

        foreach ($arr as $value)
            $sum += $value->getValue();

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
