<?php

namespace App\Services;
use App\Models\User;

class CookieService
{
    public function order($userId, $amount)
    {
        try{
            $user = User::find($userId);
            $user->wallet -= $amount;
            $user->save();
    
            return ['status' => 200, 'message' => 'success', 'wallet' => $user->wallet];
        }catch(\Exception $ex){
            return ['status' => 501, 'message' => 'Something went wrong!'];
        }
    }
}