<?php

namespace App\Models\Admin\AdvancePaid;

class APTransaction extends BaseModel
{
    protected $table = 'ap_transactions';
    protected $fillable = ['user_id', 'type', 'amount', 'description'];
}
