<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Classes\AccountingMgtClass;
class AccountingMgtController extends BaseController
{
    //
    public function __construct()
    {
        parent::__construct();
        $this->middleware(["auth:admin","accountingmgt"]);
        $this->accountMgtClass = new AccountingMgtClass;
    }

    public function AllAccounts(Request $request)
    {
        $resp = $this->accountMgtClass->allAccounts($request->keyword,$request->date_from,$request->date_to);
        return view('dashboard.accounting.all_accounting',$resp['accounting']);
    }

    public function WithdrawalRequestView(Request $request)
    {
        $resp = $this->accountMgtClass->fetchWithdrawalRequestData($request->keyword,$request->date_from,$request->date_to);

        return view('dashboard.accounting.withdrawal_request',$resp['withdrawal_requests']);

    }

    public function ChangeWithrawalStatus(Request $request)
    {
       return $this->accountMgtClass->changeWithdrawalStatus($request->withdrawal_request,$request->status);
    }
}
