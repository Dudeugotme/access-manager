<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use DispatchesCommands, ValidatesRequests;

    public function notifySuccess($message)
    {
        Notification::success($message);
    }

    public function notifyError($message)
    {
        Notification::error($message);
    }

    public function notifyInfo($message)
    {
        Notification::info($message);
    }

    public function notifyWarning($message)
    {
        Notification::warning($message);
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (!is_null($this->layout)) {
            $this->layout = view($this->layout);
        }
    }

    public function __construct()
    {
        Cache::flush();
        $config = Theme::first();
        $themes = config('themes');

        $admin_theme = $themes[$config->admin_theme];
        $user_theme = $themes[$config->user_theme];

        View::share('admin_theme', $admin_theme);
        View::share('user_theme', $user_theme);
    }
}
