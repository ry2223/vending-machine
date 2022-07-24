<?php

declare(strict_types=1);

namespace VendingMachine\Item;

use VendingMachine\Exception\ItemNotFoundException;
use VendingMachine\Item\ItemCollectionInterface;

class ItemCollection implements ItemCollectionInterface
{
    private array $items;

    public function add(ItemInterface $item): void
    {
        $this->items[] = $item;
    }

    /**
     * @throws ItemNotFoundException
     */
    public function get(ItemCodeInterface $itemCode): ItemInterface
    {
        foreach ($this->items as $item) {
            if ($item->getCode() == $itemCode) {
                $selectedItem = $item;
            }
        }

        if ($this->count($itemCode) < 1) {
            throw new ItemNotFoundException();
        }
        
        return $selectedItem;
    }

    public function count(ItemCodeInterface $itemCode): int
    {
        $itemCount = 1;

        foreach ($this->items as $item) {
            if ($item->getCode() == $itemCode) {
                $selectedItemCount = $item->getCount();
            }
        }

        return $selectedItemCount;
    }

    public function empty(): void
    {
        $this->items = [];
    }
}
