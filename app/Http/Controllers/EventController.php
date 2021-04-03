<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        } else if ($type === 'withdraw') {
            // —
            // # Withdraw from non-existing account
            // POST /event {"type":"withdraw", "origin":"200", "amount":10}
            // 404 0

            // —
            // # Withdraw from existing account
            // POST /event {"type":"withdraw", "origin":"100", "amount":5}
            // 201 {"origin": {"id":"100", "balance":15}
            return $this->withdraw($request->input('origin'), $request->input('amount'));
        } else if ($type === 'transfer') {
            // —
            // # Transfer from existing account
            // POST /event {"type":"transfer", "origin":"100", "amount":15, "destination":"300"}
            // 201 {"origin": {"id":"100", "balance":0}, "destination": {"id":"300", "balance":15}}
            // —
            // # Transfer from non-existing account
            // POST /event {"type":"transfer", "origin":"200", "amount":15, "destination":"300"}
            // 404 0
            return $this->transfer($request->input('origin'), $request->input('destination'), $request->input('amount'));
        }
        abort(404);
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
                "id" => $account->id,
                "balance" => $account->balance
            ]
        ], 201);
    }

    private function withdraw($origin, $amount)
    {
        $account = Account::findOrFail($origin);
        $account->balance -= $amount;
        $account->save();
        return response()->json([
            'origin' => [
                'id' => $account->id,
                'balance' => $account->balance
            ]
        ], 201);
    }

    private function transfer($origin, $destination, $amount)
    {
        $accountOrigin = Account::findOrFail($origin);
        $accountDestination = Account::firstOrCreate([
            'id' => $destination
        ]);

        DB::transaction(function () use ($accountOrigin, $accountDestination, $amount) {
            $accountOrigin->balance -= $amount;
            $accountDestination->balance += $amount;
            $accountOrigin->save();
            $accountDestination->save();
        });

        return response()->json([
            "origin" => [
                "id" => $accountOrigin->id, 
                "balance" => $accountOrigin->balance
            ], "destination" => [
                "id" => $accountDestination->id, 
                "balance" => $accountDestination->balance
            ]
            ], 201
        );
    }
}
