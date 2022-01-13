<?php

namespace App\Models;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Builder;
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

    public function scopeFilter(Builder $query, array $filters)
    {
        $query
            //? get the item id from table:items based on query:item; and retrieve the rows with corresponding item_id from table:entries
            //? or with relations: get rows from table:entries where col:item_id matches the id from some rows of table:items where col:name is like query:item
            ->when($filters['item'] ?? false, function (Builder $query, string $item) {
                // $result_ids = DB::table('items')->select('id')->where('name', 'like', '%' . $item . '%')->pluck('id');
                // $query->whereIn('item_id', $result_ids);
                $query->whereHas('item', function (Builder $query) use ($item) {
                    $query->where('name', 'like', '%' . $item . '%');
                });
            })

            //? get the item id from table:items based on query:market; and retrieve the rows with corresponding market_id from table:entries
            //? or with relations: get rows from table:entries where col:market_id matches the id from some rows of table:markets where col:name is like query:market
            ->when($filters['market'] ?? false, function (Builder $query, string $market) {
                // $result_ids = DB::table('markets')->select('id')->where('name', 'like', '%' . $market . '%')->pluck('id');
                // $query->whereIn('market_id', $result_ids);
                $query->whereHas('market', function (Builder $query) use ($market) {
                    $query->where('name', 'like', '%' . $market . '%');
                });
            });
    }
}
