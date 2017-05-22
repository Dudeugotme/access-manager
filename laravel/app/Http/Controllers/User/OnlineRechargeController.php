<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\PaymentGateways\DirecpayController;
use App\Models\OnlinePayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class OnlineRechargeController extends UserBaseController
{
    public function selectPaymentGateway()
    {
        $data = Input::all();
        Session::flash('post_data', $data);
        $planType = Auth::user()->plan_type == PREPAID_PLAN ? 'prepaid' : 'frinternet';
        $activeGateways = OnlinePayment::getActivePaymentGateways();

        return view('user.select_pg')
                    ->with('activeGateways', $activeGateways)
                    ->with('planType', $planType);
    }

    public function initiateOnlineRecharge()
    {
        $gw = Input::get('gateway');
        $post_data = Session::get('post_data');

        switch ($gw) {
            case 'DIRECPAY':
                $dp = new DirecpayController();

                return $dp->processDirecpay($post_data);
            break;
        }
    }
}
//end of file OnlineRechargeController.php
