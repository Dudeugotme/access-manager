<?php

namespace App\Http\Controllers;

use App\Models\Admin\GeneralSettings;
use App\Models\Admin\Subscriber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends AdminBaseController
{
    public function getIndex()
    {
        return view('user.login');
    }

    public function postLogin()
    {
        if (Auth::attempt([
                    'uname'         =>      Input::get('uname'),
                    'password'  =>      Input::get('pword'),
                    'is_admin'  =>      0,
            ])) {
            $plan_type = Auth::user()->plan_type;
            switch ($plan_type) {
                case PREPAID_PLAN:
                    return Redirect::intended('prepaid-panel');
                break;
                case FREE_PLAN:
                    return Redirect::intended('frinternet-panel');
                break;
                case ADVANCEPAID_PLAN:
                    return Redirect::intended('advancepaid-panel');
                break;
            }
        } else {
            Session::flash('error', 'Invalid Credentials');

            return Redirect::back()->withInput();
        }
    }

    public function getAdmin()
    {
        return view('admin.login');
    }

    public function postAdmin()
    {
        if (Auth::attempt([
                   'uname'  =>  Input::get('uname'),
                'password'  =>  Input::get('pword'),
                'is_admin'  =>  1,
            ])) {
            return Redirect::intended('admin-panel');
        }

        Session::flash('error', 'Invalid Username/Password');

        return Redirect::back()->withInput();
    }

    public function getSelfRegister()
    {
        $settings = GeneralSettings::first();

        if (!$settings->self_signup) {
            $this->notifyError('Self Signup Not Allowed.');

            return Redirect::route('user-panel');
        }

        return view('user.self-registration');
    }

    public function postSelfRegister()
    {
        $input = Input::only(
            'uname',
            'pword',
            'pword_confirmation',
            'status',
            'fname',
            'lname',
            'email',
            'address',
            'contact'
        );
        $rules = config('validations.accounts');
        $rules['uname'][] = 'unique:user_accounts';
        $rules['pword'][] = 'confirmed';

        $v = Validator::make($input, $rules);
        $v->setAttributeNames(config('attributes.accounts'));

        if ($v->fails()) {
            return Redirect::back()
                            ->withInput()
                            ->withErrors($v);
        }

        $input['plan_type'] = PREPAID_PLAN;
        $input['clear_pword'] = $input['pword'];
        $input['pword'] = Hash::make($input['pword']);
        $input['is_admin'] = 0;

        if (Subscriber::create($input)) {
            Session::flash('success', 'succeed');
        }

        return Redirect::back();
    }

    public function postInternetLogin()
    {
        Session::flash('mac', Input::get('mac', null));
        Session::flash('ip', Input::get('ip', null));
        Session::flash('username', Input::get('username', null));
        Session::flash('linklogin', Input::get('link-login', null));
        Session::flash('linkorig', Input::get('link-orig', null));
        Session::flash('chapid', Input::get('chap-id', null));
        Session::flash('chapchallenge', Input::get('chap-challenge', null));
        Session::flash('linkloginonly', Input::get('link-login-only', null));
        Session::flash('linkorigesc', Input::get('link-orig-esc', null));
        Session::flash('macesc', Input::get('mac-esc', null));

        $error = Input::get('error', null);

        return view('login-template')
                    ->with('error', $error);
    }

    public function postAuthorizeInternetLogin()
    {
        $data = [];

        $data['mac'] = Session::get('mac');
        $data['ip'] = Session::get('ip');
        $data['linklogin'] = Session::get('linklogin');
        $data['linkorig'] = Session::get('linkorig');
        $data['chapid'] = Session::get('chapid');
        $data['chapchallenge'] = Session::get('chapchallenge');
        $data['linkloginonly'] = Session::get('linkloginonly');
        $data['linkorigesc'] = Session::get('linkorigesc');
        $data['macesc'] = Session::get('macesc');
        $data['username'] = Input::get('username');
        $data['password'] = Input::get('password');

        //Do All Authorization stuff here.

        return view('internet-authorized')
                        ->with('data', $data);
    }
}
