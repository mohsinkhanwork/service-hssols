<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCharge;
use Illuminate\Http\Request;
use App\Models\Token;

class TokenController extends Controller
{
    public function index()
    {
        $token = Token::where('status', 1)->first();
        $service_charge = ServiceCharge::first();
        return view('admin.tokens.index', compact('token', 'service_charge'));
    }

    public function create()
    {
        return view('admin.tokens.create');
    }

    public function create_service_charges()
    {
        return view('admin.service_charges.create_service_charges');
    }

    //edit_service_charges
    public function edit_service_charges($id)
    {
        $service_charge = ServiceCharge::find($id);
        return view('admin.service_charges.edit_service_charges', compact('service_charge'));
    }

    //update_service_charges
    public function update_service_charges(Request $request, $id)
    {
        $request->validate([
            'service_charge' => 'required|numeric|min:0.01',
        ]);

        $service_charge = ServiceCharge::find($id);
        $service_charge->update($request->all());

        return redirect()->route('admin.tokens.index')->with('success', 'Service charges updated successfully.');
    }

    //store_service_charges
    public function store_service_charges(Request $request)
    {
        $request->validate([
            'service_charge' => 'required|numeric|min:0.01',
        ]);

        $serviceChare = new ServiceCharge();
        $serviceChare->service_charge = $request->service_charge;
        $serviceChare->save();

        return redirect()->route('admin.tokens.index')->with('success', 'Service charges added/updated successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'token_name' => 'required|string|max:255',
            'conversion_rate' => 'required|numeric|min:0.01',
        ]);

        $tokens = $request->price * $request->token_rate;

        Token::create([
            'token_name' => $request->token_name,
            'conversion_rate' => $request->conversion_rate,
        ]);

        return redirect()->route('admin.tokens.index')->with('success', 'Token created successfully.');
    }

    public function edit($id)
    {
        $token = Token::find($id);
        return view('admin.tokens.edit', compact('token'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'token_name' => 'required|string|max:255',
            'conversion_rate' => 'required|numeric|min:0.01',
        ]);

        $token = Token::find($id);
        $token->update($request->all());

        return redirect()->route('admin.tokens.index')->with('success', 'Token updated successfully.');
    }

    public function changeStatus($id){
        $token = Token::find($id);
        if($token->status == 1){
            $token->status = 0;
            $message= trans('admin_validation.Inactive Successfully');
        }else{
            $token->status = 1;
            $message= trans('admin_validation.Active Successfully');
        }
        $token->save();
        return response()->json($message);
    }

    public function destroy($id){
        Token::destroy($id);
        return redirect()->route('admin.tokens.index')->with('success', 'Token deleted successfully.');
    }
}
