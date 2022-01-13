<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    public function markets()
    {
        return $this->hasMany(Market::class);
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        $query->when($filters['name'] ?? false, function (Builder $query, string $district) {
            $query->where('name', 'like', '%' . $district . '%');
        });
    }
}
