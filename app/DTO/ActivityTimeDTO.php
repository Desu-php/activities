<?php

namespace App\DTO;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

final class ActivityTimeDTO implements JsonSerializable, Arrayable
{
    public function __construct(
        public string $date,
        public string $time_from,
        public string $time_to,
    )
    {
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'date' => $this->date,
            'time_from' => $this->time_from,
            'time_to' => $this->time_to,
        ];
    }
}
