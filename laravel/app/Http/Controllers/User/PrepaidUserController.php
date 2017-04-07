<?php

class PrepaidUserController extends UserBaseController
{

    const HOME = 'prepaid.dashboard';

    public function dashboard()
    {
        $subscriber = Subscriber::find(Auth::id());
        $plan = Subscriber::getActiveServices($subscriber);

        return View::make('user.prepaid.dashboard')
                    ->with('profile', Auth::user())
                    ->with('plan', $plan);
    }

    public function getRecharge()
    {
        $plans = Plan::with('limit')->paginate(10);
        return View::make('user.prepaid.recharge')
                    ->with('plans', $plans);
    }

    public function postRecharge()
    {
        try {
            $voucher_type = Input::get('voucher_type', null);
            $pin = Input::get('pin', null);

            if ($voucher_type == null) {
                throw new Exception("Select Voucher Type.");
            }
            if ($pin == null) {
                throw new Exception("Please enter a valid PIN");
            }

            switch ($voucher_type) {
                case 'prepaid':
                    Recharge::viaPin($pin, Auth::id());
                    $this->notifySuccess('Recharge Successful.');
                    break;
                case 'refill':
                    Refillcoupons::viaPin($pin, Auth::id());
                    $this->notifySuccess('Refill Applied.');
                    break;
            }
            return Redirect::route(self::HOME);
        } catch (Exception $e) {
            $this->notifyError($e->getMessage());
            return Redirect::back();
        }
    }

    public function getRefill()
    {
        return View::make('user.prepaid.refill');
    }

    public function getRechargeHistory()
    {
        $rc_history = Subscriber::find(Auth::id())
                                ->rechargeHistory()
                                ->with('limits')
                                ->orderby('updated_at', 'desc')
                                ->paginate(10);

        return View::make('user.prepaid.recharge_history')
                    ->with('rc_history', $rc_history);
    }

    public function getSessionHistory()
    {
        $sess_history = Subscriber::find(Auth::id())
                                    ->sessionHistory()
                                    ->orderby('acctstarttime', 'desc')
                                    ->paginate(10);
        return View::make('user.prepaid.session_history')
                    ->with('sess_history', $sess_history);
    }
}

//end of file PrepaidUserController.php
