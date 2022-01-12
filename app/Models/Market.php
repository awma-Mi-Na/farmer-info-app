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
        $query->when($filters['name'] ?? false, function (Builder $query, string $name) {
            $query->where('name', 'like', '%' . $name . '%');
        })
            ->when($filters['location'] ?? false, function (Builder $query, string $location) {
                $query->where('location', 'like', '%' . $location . '%');
                // $query->whereExists(function ($query) use ($location) {
                // });
            })
            ->when($filters['district'] ?? false, function (Builder $query, string $district) {
                // return DB::table('markets')->join('districts', 'markets.district_id', 'districts.id')->get();

            });
    }
}
