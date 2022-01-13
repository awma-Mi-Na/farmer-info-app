<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;
    public function entry()
    {
        return $this->belongsTo(Entry::class);
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        $query->when($filters['entry_id'] ?? false, function (Builder $query, string $entry_id) {
            $query->where('entry_id', $entry_id);
        });
    }
}
