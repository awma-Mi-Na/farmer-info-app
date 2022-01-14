<?php

namespace App\Http\Controllers;

use App\Models\Market;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class MarketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Market::filter(request()->all())->with('district')->paginate(request('per_page') ?? 20), 200);

        //! include try-catch?
        // try {
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'message' => $e->getMessage()
        //     ], 400);
        // }
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
            'name' => ['required'],
            'location' => ['required'],
            'district_id' => ['required', Rule::exists('districts', 'id')]
        ]);
        if ($validator->fails()) {
            return response()->json([
                'messages' => getErrorMessages($validator->messages()->getMessages())
            ], 422);
        }
        try {
            return response()->json([
                'message' => 'Market added successfully',
                'added_market' => Market::create($validator->validated()),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function show(Market $market)
    {
        return response()->json($market, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Market $market)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required'],
                'location' => ['required'],
                'district_id' => ['required', Rule::exists('districts', 'id')]
            ]
        );
        // return $validator->messages()->getMessages();
        if ($validator->fails()) {
            return response()->json([
                'messages' => getErrorMessages($validator->messages()->getMessages())
            ], 422);
        }
        try {
            $market->update($validator->validated());
            return response()->json(['message' => 'Updated successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function destroy(Market $market)
    {
        try {
            $market->delete();
            return response()->json(['message' => 'Market deleted successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
