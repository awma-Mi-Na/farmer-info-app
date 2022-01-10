<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Item::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required|unique:items,name',
            'unit' => 'nullable'
        ]);

        try {
            $item = Item::create($attributes);
            return response()->json([
                'message' => 'Item added successfully',
                'added_item' => $item
            ]);
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return $item;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        // dd($request->all());
        try {
            $attributes = $request->validate([
                'name' => [Rule::unique('items', 'name')->ignore($item->id)],
                'unit' => 'nullable',
            ]);
            // return $request->all();
            $updated_item = $item->update($attributes);
            return response()->json([
                'message' => "Item updated successfully",
                'updated_item' => $updated_item
            ]);
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        try {
            $item->delete();
            return response()->json([
                'message' => 'The item has been deleted successfully'
            ]);
        } catch (\Exception $e) {
            return $e;
        }
    }
}
