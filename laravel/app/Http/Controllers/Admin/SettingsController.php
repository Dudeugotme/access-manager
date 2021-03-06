<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\AdvancePaid\APSetting;
use App\Models\Admin\EmailSetting;
use App\Models\Admin\EmailTemplate;
use App\Models\Admin\GeneralSettings;
use App\Models\Admin\PaymentGateways\DirecpaySetting;
use App\Models\Admin\PaypalSettings;
use App\Models\Admin\SmtpSettings;
use App\Models\Admin\Theme;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class SettingsController extends AdminBaseController
{

    public function getGeneral()
    {
        $general = GeneralSettings::first();
        
        
        return view('admin.settings.general.general')
                        ->with('general', $general);
    }

    public function postGeneral()
    {
        if (! Input::has('id')) {
            return Redirect::route('setting.general')
                            ->with('error', 'Required parameter(s) missing.');
        }
        try {
            $input = Input::all();
            $setting = GeneralSettings::find($input['id']);
            $setting->fill($input);
            $this->flash($setting->save());
            return Redirect::route('setting.general');
        } catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function getThemes()
    {
        $themes = config('themes');
        $theme = Theme::first();
        return view('admin.settings.general.theme')
                        ->with('themes', $themes)
                        ->with('theme', $theme);
    }

    public function postThemes()
    {
        if (! Input::has('id')) {
            return Redirect::route('setting.themes.form')
                            ->with('error', 'Required parameter(s) missing.');
        }
        try {
            $input = Input::all();
            $setting = Theme::find($input['id']);
            $setting->fill($input);
            $this->flash($setting->save());
            return Redirect::route('setting.themes.form');
        } catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function getEmail()
    {
        $email = EmailSetting::first();
        $tpls = EmailTemplate::lists('name', 'id');
        return view('admin.settings.email.notifications')
                    ->with('email', $email)
                    ->with('tpls', $tpls);
    }

    public function postEmail()
    {
    }

    public function getSmtp()
    {
        $smtp = SmtpSettings::first();
        return view('admin.settings.email.smtp')
                        ->with('smtp', $smtp);
    }

    public function postSmtp()
    {
        if (! Input::has('id')) {
            return Redirect::route('setting.smtp')
                            ->with('error', 'Required parameter(s) missing.');
        }
        try {
            $input = Input::all();
            $setting = SmtpSettings::find($input['id']);
            $setting->fill($input);
            $this->flash($setting->save());
            return Redirect::route('setting.smtp');
        } catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function getPaypal()
    {
        $currencies = config('paypal_currencies');
        $pp = PaypalSettings::first();
        return view('admin.settings.payment_gateway.paypal')
                        ->with('paypal', $pp)
                        ->with('currencies', $currencies);
    }

    public function postPaypal()
    {
        if (! Input::has('id')) {
            return Redirect::route('setting.paypal')
                            ->with('error', 'Required parameter(s) missing.');
        }
        try {
            $input = Input::all();
            $setting = PaypalSettings::find($input['id']);
            $setting->fill($input);
            $this->flash($setting->save());
            return Redirect::route('setting.paypal');
        } catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function getDirecpay()
    {
        $direcpay = DirecpaySetting::first();
        return view('admin.settings.payment_gateway.direcpay')
                    ->with('direcpay', $direcpay);
    }

    public function postDirecpay()
    {
        $input = Input::all();
        $settings = DirecpaySetting::find($input['id']);
        $settings->fill($input);
        if ($settings->save()) {
            $this->notifySuccess("Settings Updated.");
        } else {
            $this->notifyError("Settings could not be updated.");
        }
        return Redirect::back();
    }

    public function getAdvancepaid()
    {
        $ap = APSetting::first();
        return view('admin.settings.ap_settings', ['ap'=>$ap]);
    }

    public function postAdvancepaid()
    {
        $ap = APSetting::first();
        $ap->fill(Input::all());
        if ($ap->save()) {
            $this->notifySuccess('Settings Saved.');
        } else {
            $this->notifyError('Failed to save Settings.');
        }
        return Redirect::back();
    }
}
// end of file SettingsController.php
