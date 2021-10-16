<?php

namespace App\Http\Controllers\Api;

use App\Classes\UserWalletClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountInformationRequest;
use App\Http\Requests\UserFundWalletRequest;
use Illuminate\Http\Request;

class UserWalletController extends Controller
{
    //
    public function __construct()
    {
        $this->userWalletClass = new UserWalletClass;
    }

    public function getUserWallet(Request $request)
    {
        return $this->userWalletClass->getUserWallet($request->user());
    }

    public function fundWallet(UserFundWalletRequest $request)
    {
        return $this->userWalletClass->fundWallet($request->user(),$request->transactionRef);
    }

    public function getWalletHistory(Request $request)
    {
        return $this->userWalletClass->getWalletHistory($request->user());
    }

    public function getWalletRequest(Request $request)
    {
        return $this->userWalletClass->getWalletRequest($request->user());
    }

    public function requestWithdrawal(Request $request)
    {
        return $this->userWalletClass->requestWithdrawal($request->user(),$request->amount,$request->pin);
    }

    public function setPin(Request $request)
    {
        return $this->userWalletClass->setPin($request->user(),$request->pin);
    }

    public function updateAccountInfo(AccountInformationRequest $request)
    {
        return $this->userWalletClass->updateAccountInfo($request->user(),$request->bank_name,$request->account_name,$request->account_no,$request->pin);
    }
}
