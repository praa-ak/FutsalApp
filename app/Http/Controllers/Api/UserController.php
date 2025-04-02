<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CostumerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::where('status', 'active')->get();
        if ($customers->count() == 0) {
            return response()->json(['message' => 'No customers found'], 200);
        }
        else
        {
            return CostumerResource::collection($customers);

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
            'email' => ['required','string','email','max:255','unique:customers'],
            'phone' => ['required','string' , 'regex:^(98|97)\d{8}$^', 'unique:customers,phone'],
            'address' => ['required','string','max:255'],
            'status' => 'required',
            'password' => ['required','string','min:8'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }
        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => $request->status,
            'email_verified_at' => now(),
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'message' => 'Customer created successfully',
            'customer' => new CostumerResource($customer),
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $user)
    {
        $customer = Customer::where('id', $user->id)->first();
        if ($customer->count() == 0) {
            return response()->json([
                'message' => 'Customer not found',
            ], 404);
        }
    return response()->json([
        'message' => 'Customer found',
        'customer' => new CostumerResource($customer),
    ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json([
                'message' => 'Customer not found',
            ], 404);
        }
        return response()->json([
            'message' => 'Customer found',
            'customer' => new CostumerResource($customer),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $user)
    {
        $validator = Validator::make($request->all(),[

            'name' => ['required','string','max:255'],
            'email'=>['required','string','email','max:255','unique:customers,email,'.$user],
            'phone'=>['required','string','regex:^(98|97)\d{8}$^','unique:customers,phone,'.$user],
            'address'=>['required','string','max:255'],
            'status'=>'required',
            'password'=>['required','string','min:8'],
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>'Validation failed',
                'errors'=>$validator->errors(),
            ],422);
        }
        $customer = Customer::find($user);
        if (!$customer) {
            return response()->json([
                'message' => 'Customer not found',
            ], 404);
        }
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->status = $request->status;
        $customer->password = bcrypt($request->password);
        $customer->update();
        return response()->json([
            'message' => 'Customer updated successfully',
            'customer' => new CostumerResource($customer),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $user)
    {
        $customer = Customer::find($user);
        if(!$customer){
            return response()->json([
                'message' => "Customer not found",
            ], 404);
        }
        $customer->delete();
        return response()->json([
            'message'=> 'Customer deleted successfully',
        ]);
    }
}
