<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TimeslotResource;
use App\Models\Timeslot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Type\Time;

class TimeslotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $timeslots = Timeslot::all();
        if ($timeslots->count() == 0) {
            return response()->json([
                'message' => 'No timeslot found',
            ], 404);
        }
        return response()->json([
            'message' => 'Timeslots found',
            'timeslots' => TimeslotResource::collection($timeslots),
        ], 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'status' => 'required',
            'futsal_id' => 'required|exists:futsals,id',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validate->errors(),
            ], 422);}
       $timeslot = Timeslot::create([
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => $request->status,
            'futsal_id' => Auth::user()->futsal->id,
        ]);
        return response()->json([
            'message' => 'Timeslot created successfully',
            'timeslot' => new TimeslotResource($timeslot),
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }


}
