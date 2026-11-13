<?php

declare(strict_types=1);

namespace App;

use src\Enums\Status;
use src\Exceptions\ItemNotAvailableException;
use src\Exceptions\InvalidReturnException;
use src\Interfaces\Borrowable;
use src\Traits\Logger;

abstract class LibraryItem implements Borrowable
{
    use Logger;

    protected string $id;
    protected string $title;
    protected Status $status;
    protected string $type = 'без статуса';

    public function __construct(string $title, Status|string $status)
    {
        $this->title = $title;
        $this->id = uniqid();
        $this->status = is_string($status) ? Status::from($status) : $status;

        $this->log($this->type, $this->title, 'создан(а)');
    }
    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @throws ItemNotAvailableException
     */
    public function borrowItem(Reader $reader): void
    {
        if ($this->status === Status::Borrowed) {
            throw new ItemNotAvailableException('Издание находится у другого читателя');
        }
        if ($this->status === Status::InRepair) {
            throw new ItemNotAvailableException('Издание на реставрации');
        }
        $reader->addItem($this);
        $this->status = Status::Borrowed;

        $this->log($this->type, $this->title, 'выдан(а)');
    }

    /**
     * @throws InvalidReturnException
     */
    public function returnItem(Reader $reader): void
    {
        if ($this->status !== Status::Borrowed || !$reader->hasItem($this)) {
            throw new InvalidReturnException();
        }
        $reader->removeItem($this);
        $this->status = Status::Available;

        $this->log($this->type, $this->title, 'возвращен(а)');
    }
}