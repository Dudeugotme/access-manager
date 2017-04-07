<?php

namespace App\Models\Admin\prepaid;


class VoucherPolicy extends BaseModel
{

    protected $table = 'voucher_bw_policies';

    protected $fillable = ['bw_policy'];
    public $timestamps = false;

    public function voucher()
    {
        return $this->morphMany('App\Models\Voucher', 'policy');
    }
}
