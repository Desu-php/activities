<?php

namespace App\Casts;

use App\DTO\ActivityTimeDTO;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class ActivityTimeCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes): array
    {
        $decoded = json_decode($value, true) ?? [];

        return array_map(function ($item) {
            return new ActivityTimeDTO(
                date: $item['date'],
                time_from: $item['time_from'],
                time_to: $item['time_to']
            );
        }, $decoded);
    }

    public function set($model, string $key, $value, array $attributes): string
    {
        $array = array_map(function (ActivityTimeDTO $dto) {
            return $dto->jsonSerialize();
        }, $value);

        return json_encode($array);
    }
}
