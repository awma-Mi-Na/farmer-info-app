<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    use HasFactory;
    public function entries()
    {
        return $this->hasMany(Entry::class);
    }
    public function district()
    {
        return $this->belongsTo(District::class);
    }
    public function scopeFilter(Builder $query, array $filters)
    {
        $query->when($filters['name'] ?? false, function () {
        });
    }
}
