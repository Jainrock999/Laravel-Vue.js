<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;

use App\Http\Requests\CreateCustomerRequest;

class CustomersController extends Controller
{
    public function all()
    {
        $customers = Customer::all();

        return response()->json([
            "customers" => $customers
        ], 200);
    }

    public function get($id)
    {
        $customer = Customer::whereId($id)->first();

        return response()->json([
            "customer" => $customer
        ], 200);
    }

    public function new(CreateCustomerRequest $request)
    {
        $customer = Customer::create($request->only(["name", "email", "phone", "website"]));

        return response()->json([
            "customer" => $customer
        ], 200);
    }

    public function remove($id)
    {
        $customer = Customer::find($id);
        $customer->delete();

        return response()->json(["success"=>"Delete Successfully"], 200);
    }

    public function update(Request $request)
    {
        $customer = Customer::find($request->id);
        $customer->update($request->all());
        return response()->json('User Updates', 200);
    }
}
