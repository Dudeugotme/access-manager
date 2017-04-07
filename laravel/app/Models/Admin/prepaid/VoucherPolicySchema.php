<?php

namespace App\Models\Admin\prepaid;


class VoucherPolicySchema extends BaseModel
{

    protected $table = 'voucher_policy_schemas';
    protected $fillable = ['name','mo','tu','we','th','fr','sa','su'];
    public $timestamps = false;

    public function voucher()
    {
        return $this->morphMany('App\Models\Voucher', 'policy');
    }

    public function monday()
    {
        return $this->belongsTo('App\Models\VoucherPolicySchemaTemplate', 'mo');
    }

    public function tuesday()
    {
        return $this->belongsTo('App\Models\VoucherPolicySchemaTemplate', 'tu');
    }

    public function wednesday()
    {
        return $this->belongsTo('App\Models\VoucherPolicySchemaTemplate', 'we');
    }

    public function thursday()
    {
        return $this->belongsTo('App\Models\VoucherPolicySchemaTemplate', 'th');
    }

    public function friday()
    {
        return $this->belongsTo('App\Models\VoucherPolicySchemaTemplate', 'fr');
    }

    public function saturday()
    {
        return $this->belongsTo('App\Models\VoucherPolicySchemaTemplate', 'sa');
    }

    public function sunday()
    {
        return $this->belongsTo('App\Models\VoucherPolicySchemaTemplate', 'su');
    }
}

//end of file VoucherPolicySchema.php
