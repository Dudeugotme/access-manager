<?php

namespace App\Http\Controllers\User;

use App\Models\Admin\Freebalance;
use App\Models\Admin\prepaid\Refillcoupons;
use App\Models\Admin\Subscriber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class FreeUserController extends UserBaseController
{
    const HOME = 'frinternet.dashboard';

    public function dashboard()
    {
        $plan = Freebalance::where('user_id', Auth::id())->first();
        // pr($plan->toArray());
        return view('user.frinternet.dashboard')
                ->with('profile', Auth::user())
                ->with('plan', $plan);
    }

    public function getRefill()
    {
        return view('user.frinternet.refill');
    }

    public function postRefill()
    {
        try {
            $pin = Input::get('pin', null);
            Refillcoupons::viaPin($pin, Auth::id());
            $this->notifySuccess('Refill Successful.');

            return Redirect::route(self::HOME);
        } catch (Exception $e) {
            $this->notifyError($e->getMessage());

            return Redirect::back();
        }
    }

    public function sessionHistory()
    {
        $sess_history = Subscriber::find(Auth::id())
                                    ->sessionHistory()
                                    ->orderby('acctstarttime', 'desc')
                                    ->paginate(10);

        return view('user.frinternet.session_history')
                    ->with('sess_history', $sess_history);
    }
}
//end of file FreeUserController.php
