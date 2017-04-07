<?php

namespace App\Models\Admin\AdvancePaid;

class APPayment extends BaseModel
{

    protected $table = 'ap_payments';
    protected $fillable = ['user_id','amount','date'];
    public $timestamps = false;
}
// end of file APPayment.php
