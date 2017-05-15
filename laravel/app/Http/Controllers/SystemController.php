<?php

namespace App\Http\Controllers;

class SystemController extends AdminBaseController
{

    public function about()
    {
        return view('about');
    }
}
