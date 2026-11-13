<?php

declare(strict_types=1);

namespace App;

use src\Exceptions\LimitExceededException;

class Reader
{
    private string $name;
    private string $id;

    /** @var LibraryItem[] */
    private array $items;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->id = uniqid();
        $this->items = [];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function hasItem(LibraryItem $item): bool
    {
        return in_array($item, $this->items, true);
    }

    public function getAmountOfItems(): int
    {
        return count($this->items);
    }

    /**
     * @throws LimitExceededException
     */
    public function addItem(LibraryItem $item): void
    {
        if ($this->getAmountOfItems() >= 3) {
            throw new LimitExceededException();
        }

        $this->items[] = $item;
    }

    public function removeItem(LibraryItem $item): void
    {
        $key = array_search($item, $this->items, true);
        if ($key !== false) {
            array_splice($this->items, $key, 1);
        }
    }
}