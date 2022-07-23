<?php

declare(strict_types=1);

namespace VendingMachine\Item;

use VendingMachine\Exception\ItemNotFoundException;
use VendingMachine\Item\ItemCollectionInterface;

class ItemCollection implements ItemCollectionInterface
{
    public function __construct(
        private array $items,
    ) {}

    public function add(ItemInterface $item): void
    {
        $this->items[] = $item;
    }

    /**
     * @throws ItemNotFoundException
     */
    public function get(ItemCodeInterface $itemCode): ItemInterface
    {
        return $this->$itemCode;
    }

    public function count(ItemCodeInterface $itemCode): int
    {

    }

    public function empty(): void
    {
        $this->items = [];
    }
}
