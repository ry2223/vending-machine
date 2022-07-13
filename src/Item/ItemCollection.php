<?php

declare(strict_types = 1);

namespace VendingMachine\Item;

use VendingMachine\Exception\ItemNotFoundException;
use VendingMachine\Item\ItemCollectionInterface;

class ItemCollection implements ItemCollectionInterface
{
    public function add(ItemInterface $item): void
    {
        
    }

    /**
     * @throws ItemNotFoundException
     */
    public function get(ItemCodeInterface $itemCode): ItemInterface
    {

    }

    public function count(ItemCodeInterface $itemCode): int
    {

    }

    public function empty(): void
    {
        
    }
}
