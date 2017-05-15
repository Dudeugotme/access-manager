<?php

namespace App\Models\Admin\AdvancePaid;

class APPolicySchema extends BaseModel
{

    protected $table = 'ap_policy_schemas';
    protected $fillable = ['name','mo','tu','we','th','fr','sa','su'];
    public $timestamps = false;

    public function plan()
    {
        return $this->morphMany('App\Models\APActivePlan', 'policy');
    }

    public function monday()
    {
        return $this->belongsTo('App\Models\APPolicySchemaTemplate', 'mo');
    }

    public function tuesday()
    {
        return $this->belongsTo('App\Models\APPolicySchemaTemplate', 'tu');
    }

    public function wednesday()
    {
        return $this->belongsTo('App\Models\APPolicySchemaTemplate', 'we');
    }

    public function thursday()
    {
        return $this->belongsTo('App\Models\APPolicySchemaTemplate', 'th');
    }

    public function friday()
    {
        return $this->belongsTo('App\Models\APPolicySchemaTemplate', 'fr');
    }

    public function saturday()
    {
        return $this->belongsTo('App\Models\APPolicySchemaTemplate', 'sa');
    }

    public function sunday()
    {
        return $this->belongsTo('App\Models\APPolicySchemaTemplate', 'su');
    }
}

//end of file APPolicySchema.php
