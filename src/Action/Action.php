<?php

declare(strict_types=1);

namespace VendingMachine\Action;

use VendingMachine\Exception\ItemNotFoundException;
use VendingMachine\Response\ResponseInterface;
use VendingMachine\Response\Response;
use VendingMachine\VendingMachineInterface;
use VendingMachine\Money\Money;
use VendingMachine\VendingMachine;
use VendingMachine\Action\ActionInterface;
use VendingMachine\Money\MoneyCollection;

class Action implements ActionInterface
{
    public function __construct(
        private string $name,
        private VendingMachine $vendingMachine,
        private Money $money,
        private array &$moneyCode,
        private array $items,
        private array $coinArray,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function handle(VendingMachineInterface $vendingMachine): ResponseInterface
    {
        if (preg_match('#^(N|D|Q|DOLLAR)$#', $this->name)) {
            $this->moneyCode[] = $this->money->getCode();
            $implodedCode = implode(', ', $this->moneyCode);
            $sumString = strval($this->vendingMachine->getCurrentTransactionMoney()->sum() / 100);
            $moneySum = sprintf('%.2f', $sumString);

            return new Response('Current balance: ' . $moneySum . ' (' . $implodedCode . ') ' . PHP_EOL);
        }

        try {
            if (preg_match('#^(RETURN-MONEY)$#', $this->name)) {
                $sum = $this->vendingMachine->getCurrentTransactionMoney()->sum();
                $coinChange = [];

                while ($sum > 0) {
                    foreach ($this->coinArray as $coin => $value) {
                        if ($sum >= $value) {
                            $sum -= $value;
                            $coinChange[] = $coin;
                            break;
                        }
                    }
                }

                $implodedCode = implode(', ', $coinChange);
                $this->vendingMachine->getInsertedMoney();
                $this->moneyCode = [];

                return new Response($implodedCode . PHP_EOL);
            }

            if (preg_match('#^(GET-[A-C])$#', $this->name)) {
                $explodedAction = explode('-' , $this->name);

                foreach ($this->items as $item) {
                    if ($item->getCode() == $explodedAction[1]) {
                        if ($this->vendingMachine->getCurrentTransactionMoney()->sum() >= $item->getPrice()) {
                            $this->vendingMachine->dropItem($item->getCode());
                            $this->money->setValue($item->getPrice() * -1);
                            $this->vendingMachine->insertMoney($this->money);
                            $this->moneyCode = [];

                            return new Response($explodedAction[1] . PHP_EOL);
                        }
                    }
                }

                return new Response('Not enough money.' . PHP_EOL);
            }
        } catch (ItemNotFoundException) {
            return new Response('Item not found. Please choose another item.' . PHP_EOL);
        }
    }
}
