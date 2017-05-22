<?php

namespace App\Models\Admin;

class PaypalSettings extends BaseModel
{
    protected $table = 'paypal_settings';
    protected $fillable = ['status', 'email', 'currency', 'sandbox'];
    public $timestamps = false;
}
