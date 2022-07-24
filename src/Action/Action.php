<?php

declare(strict_types=1);

namespace VendingMachine\Action;

use VendingMachine\Action\ActionInterface;
use VendingMachine\Exception\ItemNotFoundException;
use VendingMachine\Response\ResponseInterface;
use VendingMachine\Response\Response;
use VendingMachine\VendingMachineInterface;
use VendingMachine\Money\Money;
use VendingMachine\VendingMachine;

class Action implements ActionInterface
{
    private array $itemCodeArray = [];

    public function __construct(
        private string $name,
        private VendingMachine $vendingMachine,
        private Money $money,
        private array &$moneyCode,
        private array $items,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function handle(VendingMachineInterface $vendingMachine): ResponseInterface
    {
        if (preg_match('#\b(N|D|Q|DOLLAR)\b#', $this->name)) {
            $this->moneyCode[] = $this->money->getCode();
            $implodedCode = implode(', ', $this->moneyCode);

            $sumString = strval($this->vendingMachine->getCurrentTransactionMoney()->sum());
            $moneySum = sprintf('%.2f', $sumString);

            return new Response('Current balance: ' . $moneySum . ' (' . $implodedCode . ') ' . PHP_EOL);
        }

        try {
            if (preg_match('#\b(RETURN-MONEY)\b#', $this->name)) {
                $vendingMachine->getInsertedMoney();
                $implodedCode = implode(', ', $this->moneyCode);
                $this->moneyCode = [];

                return new Response($implodedCode . PHP_EOL);
            }

            if (preg_match('#\b(GET-A|GET-B|GET-C)\b#', $this->name)) {
                $explodedAction = explode('-' , $this->name);

                foreach ($this->items as $item) {
                    $this->itemCodeArray[] = $item->getCode();
                }

                foreach ($this->itemCodeArray as $itemCode) {
                    if ($itemCode == $explodedAction[1]) {
                        $this->vendingMachine->dropItem($itemCode);
                    }
                }

                return new Response($explodedAction[1] . PHP_EOL);
            }
        } catch (ItemNotFoundException) {
            return new Response('Item not found. Please choose another item.' . PHP_EOL);
        }
    }
}
