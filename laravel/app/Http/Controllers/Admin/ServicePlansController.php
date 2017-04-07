<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\FRINTERNET;
use App\Models\Admin\Plan;
use App\Models\Admin\PlanLimit;
use App\Models\Admin\Policy;
use App\Models\Admin\PolicySchema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class ServicePlansController extends AdminBaseController
{

    const HOME = 'plan.index';


    public function getIndex()
    {
        $plans = Plan::with('limit')->paginate(10);
        return view('admin.plans.index', ['plans'=>$plans]);
    }

    public function getAdd()
    {
        $policies = Policy::lists('name', 'id');
        $schemas = PolicySchema::lists('name', 'id');
        return view('admin.plans.add-edit', ['policies'=>$policies,'schemas'=>$schemas]);
    }

    public function postAdd()
    {
        $input = Input::all();
        $rules = config('validations.service_plan');
        $rules['name'][] = 'unique:service_plans';
        $v = Validator::make(
            $input,
            $rules
        );
        if ($v->fails()) {
                return Redirect::back()
                            ->withInput()
                            ->withErrors($v);
        }
        try {
            if ($input['policy_type'] == 'PolicySchema') {
                $input['policy_id'] = $input['schema_id'];
                // unset($input['schema_id']);
            }

            DB::transaction(function () use ($input) {
                $plan = new Plan($input);
                if (! $plan->save()) {
                    throw new Exception("Failed to save service plan.");
                }
                if ($input['plan_type'] == 1) { //if limited
                    $limit = $this->_makeLimit($input); //new PlanLimit( $input );
                    if (! $plan->limit()->save($limit)) {
                        throw new Exception("Failed to save Service Plan.");
                    }
                }
            });
            $this->notifySuccess("Service Plan successfully created.");
            return Redirect::route(self::HOME);
        } catch (Exception $e) {
            $this->notifyError($e->getMessage());
            return Redirect::route(self::HOME);
        }
    }

    public function getEdit($id)
    {
        try {
            $plan = Plan::with('limit')->findOrFail($id);
            if ($plan->policy_type == 'PolicySchema') {
                $plan->schema_id = $plan->policy_id;
                unset($plan->policy_id);
            }
            if ($plan->plan_type == 1) {
                $limits = ['limit_type','time_limit','time_unit','data_limit',
                                    'data_unit','aq_access','aq_policy'];
                foreach ($limits as $limit) {
                        $plan->$limit = $plan->limit->$limit;
                }
                $plan->limit_id = $plan->limit->id;
            }
            $policies = Policy::lists('name', 'id');
            $schemas = PolicySchema::lists('name', 'id');
            return view('admin.plans.add-edit', ['policies'=>$policies,'schemas'=>$schemas])
                                ->with('plan', $plan);
        } catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function postEdit()
    {
        $input = Input::all();
        $rules = config('validations.service_plan');
        $rules['name'][] = 'unique:service_plans,name,' . $input['id'];

        $v = Validator::make($input, $rules);
        if ($v->fails()) {
                return Redirect::back()
                            ->withInput()
                            ->withErrors($v);
        }

        
        if ($input['policy_type'] == 'PolicySchema') {
            $input['policy_id'] = $input['schema_id'];
            unset($input['schema_id']);
        }
        try {
            DB::transaction(function () use ($input) {
                $plan = Plan::find($input['id']);
                
                if ($input['plan_type'] == 1) {
                    $limit = $this->_makeLimit($input);
                    if (! $plan->limit()->save($limit)) {
                        throw new Exception("Failed to update Service Plan.");
                    }
                } else {
                    if ($plan->plan_type == 1) {
                        if (! $plan->limit()->delete()) {
                            throw new Exception("Failed to delete limits");
                        }
                    }
                }
                $plan->fill($input);
                if (! $plan->save()) {
                    throw new Exception("Plan updation failed.");
                }
            });
            $this->notifySuccess("Service Plan successfully updated.");
            return Redirect::route(self::HOME);
        } catch (Exception $e) {
            $this->notifyError($e->getMessage());
            return Redirect::route(self::HOME);
        }
    }

    private function _makeLimit($input)
    {
        if ($input['plan_type'] == 1) {
            if ($input['limit_type'] == 0) {
                $input['data_limit'] = null;
                $input['data_unit'] = null;
            }
            if ($input['limit_type'] == 1) {
                $input['time_limit'] = null;
                $input['time_unit'] = null;
            }
            if (! isset($input['aq_access'])) {
                $input['aq_access'] = null;
                $input['aq_policy'] = null;
            }
        }
        
        if (isset($input['limit_id'])) {
            $limit = PlanLimit::find($input['limit_id']);
            $limit->fill($input);
        } else {
            $limit = new PlanLimit($input);
        }
        return $limit;
    }

    public function getFreePlan()
    {
        $plan = FRINTERNET::find(1);
        $policies = Policy::lists('name', 'id');
        return view('admin.plans.free')
                    ->with('policies', $policies)
                    ->with('plan', $plan);
    }

    public function postFreePlan()
    {
        $input = Input::all();
        $plan = FRINTERNET::firstOrNew(['id'=>1]);
        $plan->fill($input);
        if ($plan->save()) {
            $this->notifySuccess('Free Plan successfully updated.');
        } else {
            $this->notifyError('Failed to update Free Plan.');
        }
        return Redirect::back();
    }

    public function postDelete($id)
    {
        $this->flash(Plan::destroy($id));
        return Redirect::route(self::HOME);
    }
}
