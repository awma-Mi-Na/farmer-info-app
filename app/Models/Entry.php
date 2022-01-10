<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    // protected $casts = [
    //     'from' => 'datetime',
    //     'to' => 'datetime'
    // ];

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
    public function setFromAttribute(string $entryDate)
    {
        if (!$entryDate == '')
            $this->attributes['from'] = Carbon::createFromFormat('Y-m-d', $entryDate)->startOfWeek(Carbon::SUNDAY)->toDateTimeString();
    }

    public function setToAttribute($entryDate)
    {
        if (!$entryDate == '')
            $this->attributes['to'] = Carbon::createFromFormat('Y-m-d', $entryDate)->endOfWeek(Carbon::SATURDAY)->toDateTimeString();
    }
}
