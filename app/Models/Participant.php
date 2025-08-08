<?php

namespace App\Models;

use App\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MatanYadaev\EloquentSpatial\Objects\Polygon;

class Participant extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'area' => Polygon::class,
        ];
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }
}
