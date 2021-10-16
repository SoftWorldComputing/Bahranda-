<?php

namespace App\Http\Controllers\Api;

use App\Classes\UserCommodityClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseCommodityFromWalletRequest;
use App\Http\Requests\PurchaseCommodityRequest;
use Illuminate\Http\Request;

class UserCommodityController extends Controller
{
    //
        public function __construct()
        {
            $this->commodityClass = new UserCommodityClass;
        }

        public function fetchActiveCommodities(Request $request)
        {
            return  $this->commodityClass->getActiveCommodities($request->page);
        }

        public function getSingleCommodity(Request $request)
        {
            return  $this->commodityClass->getSingleCommodity($request->commodity);
        }

        public function calculateCommodityPrice(Request $request)
        {
            return $this->commodityClass->calculateCommodityPrice($request->commodity,$request->quantity);
        }

        public function getRelatedCommodity(Request $request)
        {
            return $this->commodityClass->getRelatedCommodity();
        }

        public function purchase(PurchaseCommodityRequest $request)
        {
            return $this->commodityClass->purchase($request->user(),$request->commodity_id,$request->transaction_ref,$request->quantity);
        }

        public function purchaseFromWallet(PurchaseCommodityFromWalletRequest $request)
        {
            return $this->commodityClass->purchaseFromWallet($request->user(),$request->commodity_id,$request->quantity);
        }
}
