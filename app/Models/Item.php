<?php

namespace App\Models;

use DB;
use Doctrine\DBAL\Query\QueryBuilder;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function scopeFilter(Builder $query, $filters)
    {
        $query->when($filters['name'] ?? false, function (Builder $query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        });
    }
}
