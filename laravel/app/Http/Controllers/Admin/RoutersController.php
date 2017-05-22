<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Router;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Krucas\Notification\Facades\Notification;

class RoutersController extends AdminBaseController
{
    const HOME = 'router.index';

    public function getIndex()
    {
        $routers = Router::paginate(10);

        return view('admin.routers.index')
                            ->with('routers', $routers);
    }

    public function getAdd()
    {
        return view('admin.routers.add-edit');
    }

    public function postAdd()
    {
        $input = Input::all();
        $this->flash(Router::create($input));

        return Redirect::route(self::HOME);
    }

    public function getEdit($id)
    {
        try {
            $router = Router::findOrFail($id);

            return view('admin.routers.add-edit')
                            ->with('router', $router);
        } catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function postEdit()
    {
        if (!Input::has('id')) {
            Notification::error('Parameter Missing.');

            return Redirect::route(self::HOME);
        }
        $input = Input::all();
        try {
            $router = Router::findOrFail($input['id']);
            $router->fill($input);
            $this->flash($router->save());

            return Redirect::route(self::HOME);
        } catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function postDelete($id)
    {
        $this->flash(Router::destroy($id));

        return Redirect::route(self::HOME);
    }
}
