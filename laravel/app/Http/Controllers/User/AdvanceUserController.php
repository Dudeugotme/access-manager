<?php

namespace App\Http\Controllers\User;

use App\Models\Admin\Subscriber;
use Illuminate\Support\Facades\Auth;

class AdvanceUserController extends UserBaseController
{
    const HOME = 'advancepaid.dashboard';

    public function dashboard()
    {
        $subscriber = Subscriber::find(Auth::id());
        $plan = Subscriber::getActiveServices($subscriber);

        return view('user.advancepaid.dashboard')
                    ->with('profile', Auth::user())
                    ->with('plan', $plan);
    }

    public function sessionHistory()
    {
        $sess_history = Subscriber::find(Auth::id())
                                    ->sessionHistory()
                                    ->orderby('acctstarttime', 'desc')
                                    ->paginate(10);

        return view('user.advancepaid.session_history')
                    ->with('sess_history', $sess_history);
    }
}
//end of file AdvanceUserController.php
