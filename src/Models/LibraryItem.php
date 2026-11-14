<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Status;
use App\Exceptions\HasUnpaidFineException;
use App\Exceptions\InvalidReturnException;
use App\Exceptions\ItemNotAvailableException;
use App\Exceptions\LimitExceededException;
use App\Interfaces\Borrowable;
use App\Traits\Logger;
use Carbon\Carbon;

abstract class LibraryItem implements Borrowable
{
    use Logger;

    protected string $id;
    protected string $title;
    protected Status $status;
    protected string $type = 'без статуса';
    protected ?Carbon $borrowDate = null;
    protected ?Carbon $dueDate = null;

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
     * @throws LimitExceededException
     * @throws HasUnpaidFineException
     */
    public function borrowItem(Reader $reader): void
    {
        if ($this->status === Status::Borrowed) {
            throw new ItemNotAvailableException('Издание находится у другого читателя');
        }
        if ($this->status === Status::InRepair) {
            throw new ItemNotAvailableException('Издание на реставрации');
        }
        if ($reader->hasFine()) {
            throw new HasUnpaidFineException();
        }

        $reader->addItem($this);
        $this->status = Status::Borrowed;
        $this->borrowDate = Carbon::now();
        $this->dueDate = (clone $this->borrowDate)->addDays(14);

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
        if ($this->dueDate !== null && $this->dueDate->isPast()) {
            $reader->addFine();
        }

        $reader->removeItem($this);
        $this->status = Status::Available;
        $this->borrowDate = null;
        $this->dueDate = null;

        $this->log($this->type, $this->title, 'возвращен(а)');
    }
}
