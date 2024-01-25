<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function withdraw(Request $request, $walletId)
    {
        $wallet = Wallet::findOrFail($walletId);
        $amount = $request->input('amount');


        DB::transaction(function () use ($wallet, $amount) {
            $wallet->decrement('balance', $amount);
            Transaction::create([
                'wallet_id' => $wallet->id,
                'amount' => -$amount,
            ]);
        });

        return response()->json(['message' => 'Amount withdrawn successfully']);
    }

    public function deposit(Request $request, $walletId)
    {
        $wallet = Wallet::findOrFail($walletId);
        $amount = $request->input('amount');


        DB::transaction(function () use ($wallet, $amount) {
            $wallet->increment('balance', $amount);
            Transaction::create([
                'wallet_id' => $wallet->id,
                'amount' => $amount,
            ]);
        });

        return response()->json(['message' => 'Amount deposited successfully']);
    }

    public function transactionsOnWallet($walletId)
    {
        $wallet = Wallet::findOrFail($walletId);
        $transactions = $wallet->transactions;
        $balance = $wallet->balance;

        return response()->json(['balance' => $balance, 'transactions' => $transactions]);
    }

    public function allUserTransactions($userId)
    {
        $user = User::findOrFail($userId);
        $user->wallets->each(function($wallet){
            $wallet->transactions = $wallet->transactions;
        });

        return response()->json(['userTransactions' => $user->wallets]);
    }
}
