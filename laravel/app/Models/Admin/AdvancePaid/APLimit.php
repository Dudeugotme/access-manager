<?php

namespace App\Models\Admin\AdvancePaid;

class APLimit extends BaseModel
{

    protected $table = 'ap_limits';
    protected $fillable = ['limit_type','time_limit','time_unit','data_limit','data_unit',
                        'aq_access','aq_policy'];
    public $timestamps = false;
}
