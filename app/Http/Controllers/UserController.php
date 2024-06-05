<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\CookieService;
use App\Services\WalletService;

class UserController extends Controller
{
    protected $walletService;

    public function __construct(WalletService $walletService, CookieService $cookieService)
    {
        $this->walletService = $walletService;
        $this->cookieService = $cookieService;
        $this->cookie_price = 1;
    }

    public function wallet(): View
    {
        return view('add-money');
    }

    public function cookieList(): View
    {
        return view('buy-cookie');
    }

    public function addMoney(Request $request){
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:3|max:100',
        ], [
			'amount.min' => 'The minimum amount must be $3.',
            'amount.max' => 'The maximum amount cannot be greater than $100.',
		]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $userId = auth()->user()->id;  // Assuming the user is authenticated
        $result = $this->walletService->addMoneyToWallet($userId, $request->amount);

        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error']);
        }

        return redirect()->back()->with('success', 'Money added to wallet');
    }

    public function buyCookie(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'quantity' => 'required|integer|min:1',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            $userId = auth()->user()->id;
            $quantity = $request->quantity;
            $amount = $quantity * $this->cookie_price;
    
            if(auth()->user()->wallet < $amount){
                return redirect()->back()->with('error', 'Wallet balance is not sufficient');
            }
    
            $result = $this->cookieService->order($userId, $amount);
            if (isset($result['error'])) {
                return redirect()->back()->with('error', $result['error']);
            }
    
            return redirect()->back()->with('success', 'Order placed successfully');
        }catch(\Exception $ex){
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
}