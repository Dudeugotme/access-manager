<?php

namespace App\Models\Admin;

class EmailSetting extends BaseModel
{
    protected $table = 'email_settings';
    protected $fillable = ['reg', 'reg_tpl', 'recharge', 'recharge_tpl'];
    public $timestamps = false;
}
