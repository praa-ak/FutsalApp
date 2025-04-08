<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FutsalResource;
use App\Models\Futsal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FutsalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $futsals = Futsal::where('status', 'active')->get();
        if ($futsals->isEmpty()) {
            return response()->json([
                'message' => 'No futsal found',
            ], 404);
        }
        return response()->json([
            'message' => 'Active Futsals found',
            'futsals' => FutsalResource::collection($futsals),
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|regex:^0\d{1,2}-?\d{5,7}$^|unique:futsals,phone',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rate' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
            'facilities' => 'nullable|string',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validate->errors(),
            ], 422);
        }
        if ($request->hasFile('image')) {
            // $image = $request->file('image');
            // $imageName = time().'_'.$image->getClientOriginalName();
            // $image->move(public_path('images'), $imageName);
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $futsal = Futsal::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'image' => $imagePath,
            'rate' => $request->rate,
            'status' => $request->status,
            'description' => $request->description,
            'facilities' => $request->facilities,
        ]);
        return response()->json([
            'message' => 'Futsal created successfully',
            'futsal' => new FutsalResource($futsal),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Futsal $futsal)
    {
        return response()->json([
            'message' => 'Futsal found',
            'futsal' => new FutsalResource($futsal),
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $futsal = Futsal::findOrFail($id);
        if (!$futsal) {
            return response()->json([
                'message' => 'Futsal not found',
            ], 404);
        }
        return response()->json([
            'message' => 'Futsal to edit found',
            'futsal' => new FutsalResource($futsal),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Futsal $futsal)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|regex:^0\d{1,2}-?\d{5,7}$^|unique:futsals,phone',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rate' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
            'facilities' => 'nullable|string',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validate->errors(),
            ], 422);
        }
        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')->store('images', 'public');
        }

        $futsalupdt = Futsal::findOrFail($futsal->id);
        if (!$futsalupdt) {
            return response()->json([
                'message' => 'Futsal not found',
            ], 404);
        }
        $futsalupdt->name = $request->name;
        $futsalupdt->address = $request->address;
        $futsalupdt->phone = $request->phone;
        $futsalupdt->image = $imagePath ?? $futsalupdt->image;
        $futsalupdt->rate = $request->rate;
        $futsalupdt->status = $request->status;
        $futsalupdt->description = $request->description;
        $futsalupdt->facilities = $request->facilities;
        $futsalupdt->update();
        return response()->json([
            'message' => 'Futsal updated successfully',
            'futsal' => new FutsalResource($futsalupdt),
        ], 200);
    }
    public function allFutsal() {
        $allFutsals = Futsal::all();
        if ($allFutsals->count() == 0) {
            return response()->json([
                'message' => 'No futsal in the database',
            ], 404);
        }
        return response()->json([
            'message' => 'All Futsals found',
            'futsals' => FutsalResource::collection($allFutsals),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Futsal $futsal)
    {
        $futsaldlt = Futsal::findOrFail($futsal->id);
        if (!$futsaldlt) {
            return response()->json([
                'message' => 'Futsal not found',
            ], 404);
        }
        $futsaldlt->delete();
        return response()->json([
            'message' => 'Futsal deleted successfully',
        ], 200);
    }

}
