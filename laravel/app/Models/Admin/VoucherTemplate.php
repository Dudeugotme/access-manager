<?php

namespace App\Models\Admin;

class VoucherTemplate extends BaseModel
{
    
    protected $table = 'voucher_templates';
    protected $fillable = ['name','body'];
    
    public $timestamps = false;
}
