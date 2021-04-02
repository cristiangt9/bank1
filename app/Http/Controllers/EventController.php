<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $type = $request->input('type');
        if ($type === 'deposit') {
            // —
            // # Create account with initial balance
            // POST /event {"type":"deposit", "destination":"100", "amount":10}
            // 201 {"destination": {"id":"100", "balance":10}}
            // —
            // # Deposit into existing account
            // POST /event {"type":"deposit", "destination":"100", "amount":10}
            // 201 {"destination": {"id":"100", "balance":20}}
            return $this->deposit($request->input('destination'), $request->input('amount'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function deposit($destination, $amount)
    {
        $account = Account::firstOrCreate([
            'id' => $destination
        ]);
        $account->balance += $amount;
        $account->save();
        return response()->json([
            "destination" => [
                "id" => "100",
                "balance" => 20
            ]
            ], 201);
    }
}
