<?php

namespace App\Models\Admin;


class Plan extends BaseModel
{
    protected $table = 'service_plans';
    protected $fillable = ['name','plan_type','policy_type','policy_id','validity',
                            'validity_unit','sim_sessions','interim_updates','price'];

    public function limit()
    {
        return $this->hasOne('App\Models\PlanLimit', 'plan_id');
    }

    public function policy()
    {
        return $this->morphTo();
    }

    public function delete()
    {
        $this->limit()->delete();

        return parent::delete();
    }

    // public function schema()
    // {
    // 	return $this->hasOne('App\Models\PolicySchema','schema_id');
    // }
}
