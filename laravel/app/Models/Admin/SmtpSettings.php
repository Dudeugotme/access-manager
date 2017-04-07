<?php

namespace App\Models\Admin;

class SmtpSettings extends BaseModel
{
    protected $table = 'smtp_settings';
    protected $fillable = ['status','email','name','username','password','host','port'];
    public $timestamps = false;
}
