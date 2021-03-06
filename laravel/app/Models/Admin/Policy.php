<?php

namespace App\Models\Admin;

class Policy extends BaseModel
{
    protected $table = 'bw_policies';
    protected $fillable = ['name','max_down','max_down_unit','min_down',
                            'min_down_unit','max_up','max_up_unit','min_up','min_up_unit'];
    public $timestamps = false;

    public function plan()
    {
        return $this->morphMany('App\Models\Plan', 'policy');
    }
}
