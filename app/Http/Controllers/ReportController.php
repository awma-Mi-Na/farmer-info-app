<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function weekly(Request $request)
    {
        try {
            $result = DB::table('entries')
                ->when($request->filled('from'), function (Builder $query) use ($request) {
                    $query
                        ->whereDate('from', $request->input('from'));
                })
                ->when($request->filled('to'), function (Builder $query) use ($request) {
                    $query->whereDate('to', $request->input('to'));
                });
            return response()->json($result->paginate(15));
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
