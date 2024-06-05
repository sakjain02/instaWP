<?php

namespace App\Http\Controllers\Api\User\v1;

use Validator;
use Illuminate\Http\Request;
use App\Services\CookieService;
use App\Services\WalletService;
use App\Http\Controllers\Api\User\v1\BaseController;

class ApiController extends BaseController
{
    protected $walletService;

    public function __construct(WalletService $walletService, CookieService $cookieService)
    {
        $this->walletService = $walletService;
        $this->cookieService = $cookieService;
        $this->amount = 1;
    }

    public function addMoney(Request $request)
    {
        try{
            $validator = Validator::make($request->all(),[
                'amount' => 'required|numeric|min:3|max:100',
            ],[
                'amount.min' => 'The minimum amount must be $3.',
                'amount.max' => 'The maximum amount cannot be greater than $100.',
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first(), $validator->errors()->first(), 400);
            }

            $user_id = auth()->user()->id;
            $result = $this->walletService->addMoneyToWallet($user_id, $request->amount);

            if (isset($result['status']) && $result['status'] == 200) {
                return $this->sendResponse(['wallet' => $result['wallet']], 'Money added to wallet');
            }else{
                return $this->sendError($result['message'], null, $result['status']);
            }
        }catch(\Exception $ex){
            return ['status' => 501, 'errors'=> $ex->getMessage(), 'message' => 'Something went wrong!'];
        }
    }

    public function buyCookie(Request $request)
    {
        try{
            $validator = Validator::make($request->all(),[
                'quantity' => 'required|integer|min:1',
            ]);
    
            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first(), $validator->errors()->first(), 400);
            }
    
            $user_id = auth()->user()->id;
            $quantity = $request->quantity;
            $amount = $quantity * $this->amount;
    
            if(auth()->user()->wallet < $amount){
                return $this->sendError('Wallet balance is not sufficient', null, 422);
            }
    
            $result = $this->cookieService->order($user_id, $amount);
    
            if (isset($result['status']) && $result['status'] == 200) {
                return $this->sendResponse(['wallet' => $result['wallet']], 'Order placed successfully');
            }else{
                return $this->sendError($result['message'], null, $result['status']);
            }
        }catch(\Exception $ex){
            return ['status' => 501, 'errors'=> $ex->getMessage(), 'message' => 'Something went wrong!'];
        }
       
    }
}