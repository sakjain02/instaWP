<?php

namespace App\Services;
use App\Models\User;

class WalletService
{
    public function addMoneyToWallet($userId, $amount)
    {
        try{
            $user = User::find($userId);
            $user->wallet += $amount;
            $user->save();
    
            return ['status' => 200, 'message' => 'success', 'wallet' => $user->wallet];
        }catch(\Exception $ex){
            return ['status' => 501, 'message' => 'Something went wrong!'];
        }
    }
}