<?php

declare(strict_types=1);

namespace App\Models;

use App\Exceptions\HasUnpaidFineException;
use App\Exceptions\LimitExceededException;

class Reader
{
    private string $name;
    private string $id;
    private int $fine;

    /** @var LibraryItem[] */
    private array $items;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->id = uniqid();
        $this->items = [];
        $this->fine = 0;
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
     * @throws HasUnpaidFineException
     * @throws LimitExceededException
 */
    public function addItem(LibraryItem $item): void
    {
        if ($this->hasFine()) {
            throw new HasUnpaidFineException();
        }

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

    public function hasFine(): bool
    {
        return $this->fine > 0;
    }

    public function addFine(): void
    {
        $this->fine++;
    }
}
