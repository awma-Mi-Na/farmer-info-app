<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class EntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return response()->json(Entry::with('item', 'market')->get(), 200);
        return response()->json(Entry::filter(request()->all())->paginate(request('per_page') ?? 20), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => ['required', Rule::exists('items', 'id')],
            'market_id' => ['required', Rule::exists('markets', 'id')],
            'cost' => ['numeric', 'required'],
            'quantity' => ['required', 'numeric']
        ]);
        if ($validator->fails()) {
            return response()->json([
                'messages' => getErrorMessages($validator->messages()->getMessages())
            ], 422);
        }

        try {
            $validated = array_merge($validator->validated(), ['from' => now()->toDateString(), 'to' => now()->toDateString()]);
            return response()->json([
                'added_item' => Entry::create($validated)
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function show(Entry $entry)
    {
        return response()->json($entry, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entry $entry)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => ['required', 'exists:items,id'],
            'market_id' => ['required', 'exists:markets,id'],
            'cost' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'entry_date' => ['nullable', 'date_format:Y-m-d'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'messages' => getErrorMessages($validator->messages()->getMessages())
            ], 422);
        }
        if ($request->filled('entry_date')) {
            $entry_date = $validator->safe()->only('entry_date')['entry_date'];
        }
        $validated = array_filter($validator->validated(), function ($value, $field) {
            return $field != 'entry_date';
        }, 1);
        $validated = array_merge($validated, ['from' => $entry_date ?? '', 'to' => $entry_date ?? '']);
        try {
            $entry->update($validated);
            return response()->json(['message' => 'Entry updated successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entry $entry)
    {
        try {
            $entry->delete();
            return response()->json([
                'message' => 'Entry deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Entry deleted successfully'
            ], 400);
        }
    }
}
