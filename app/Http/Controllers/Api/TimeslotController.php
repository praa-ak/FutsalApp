<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Timeslot;
use Illuminate\Http\Request;

class TimeslotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $timeslots = Timeslot::all();
        if ($timeslots->isEmpty()) {
            return response()->json([
                'message' => 'No timeslot found',
            ], 404);
        }
        return response()->json([
            'message' => 'Timeslots found',
            'timeslots' => $timeslots,
        ], 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }


}
