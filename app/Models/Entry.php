<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function market()
    {
        return $this->belongsTo(Market::class);
    }
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}
