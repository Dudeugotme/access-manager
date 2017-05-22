<?php

namespace App\Models\Admin\AdvancePaid;

class APPolicy extends BaseModel
{
    protected $table = 'ap_policies';
    protected $fillable = ['bw_policy'];
    public $timestamps = false;

    public function plan()
    {
        return $this->morphMany('App\Models\APActivePlan', 'policy');
    }
}
