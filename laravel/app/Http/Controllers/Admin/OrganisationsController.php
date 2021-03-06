<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Organisation;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class OrganisationsController extends AdminBaseController
{

    const HOME = 'org.index';

    public function getIndex()
    {
        $organisations = Organisation::paginate(10);

        return view('admin.orgs.index', ['organisations'=>$organisations]);
    }

    public function getAdd()
    {
        return view('admin.orgs.add-edit');
    }

    public function postAdd()
    {
        $input = Input::all();

        if (Organisation::create($input)) {
            $this->notifySuccess('Organisation Added.');
        } else {
            $this->notifyError('Organisation Faled to Add.');
        }
        return Redirect::route(self::HOME);
    }

    public function getEdit($id)
    {
        $org = Organisation::findOrFail($id);
        return view('admin.orgs.add-edit', ['org'=>$org]);
    }

    public function postEdit()
    {
        $input  = Input::all();
        $org    = Organisation::findOrFail($input['id']);

        $org->fill($input);
        if ($org->save()) {
            $this->notifySuccess('Organisation Details Updated.');
        } else {
            $this->notifyError('Organisation Details Updation Failed.');
        }
        return Redirect::route(self::HOME);
    }

    public function postDelete($id)
    {
        if (Organisation::destroy($id)) {
            $this->notifySuccess('Organisation Deleted.');
        } else {
            $this->notifyError('Organisation Deletion Failed.');
        }
        return Redirect::route(self::HOME);
    }
}
//end of file Organisations.php
