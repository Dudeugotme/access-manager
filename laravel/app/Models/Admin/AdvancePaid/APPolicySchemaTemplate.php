<?php

namespace App\Models\Admin\AdvancePaid;

class APPolicySchemaTemplate extends BaseModel
{

    protected $table = 'ap_policy_schema_templates';
    protected $fillable = ['name','access','bw_policy','bw_accountable','from_time','to_time',
                        'pr_allowed','pr_policy','pr_accountable','sec_allowed','sec_policy',
                        'sec_accountable',];
    public $timestamps = false;
}

//end of file APPOlicySchemaTemplate.php
