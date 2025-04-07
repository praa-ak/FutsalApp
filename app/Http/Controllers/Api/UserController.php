<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CostumerResource;
use App\Http\Resources\UserResource;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        if ($users->count() == 0) {
            return response()->json(['message' => 'No users found'], 200);
        }
        else
        {
            return response()->json([
                'message' => 'Users found',
                'users' => UserResource::collection($users),
            ], 200);

        }
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
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required','string','email','max:255','unique:users'],
            'phone' => ['required','string' , 'regex:^(98|97)\d{8}$^', 'unique:users,phone'],
            'role' => 'required',
            'password' => ['required','string','min:8'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }
        $customer = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'email_verified_at' => now(),
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'users' => new UserResource($customer),
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $users = User::where('id', $user->id)->first();
        if ($users->count() == 0) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }
    return response()->json([
        'message' => 'User found',
        'user' => new UserResource($users),
    ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }
        return response()->json([
            'message' => 'User found',
            'user' => new UserResource($user),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $user)
    {
        $validator = Validator::make($request->all(),[

            'name' => ['required','string','max:255'],
            'email'=>['required','string','email','max:255','unique:users,email,'.$user],
            'phone'=>['required','string','regex:^(98|97)\d{8}$^','unique:users,phone,'.$user],
            'role'=>'required',
            'password'=>['required','string','min:8'],
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>'Validation failed',
                'errors'=>$validator->errors(),
            ],422);
        }
        $users = User::find($user);
        if (!$users) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }
        $users->name = $request->name;
        $users->email = $request->email;
        $users->phone = $request->phone;
        $users->role = $request->role;
        $users->password = bcrypt($request->password);
        $users->update();
        return response()->json([
            'message' => 'User updated successfully',
            'user' => new UserResource($users),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $user)
    {
        $users = User::find($user);
        if(!$users){
            return response()->json([
                'message' => "User not found",
            ], 404);
        }
        $users->delete();
        return response()->json([
            'message'=> 'User deleted successfully',
        ]);
    }
}
