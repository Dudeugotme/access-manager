<?php

namespace App\Models\Admin;

class Theme extends BaseModel
{
    protected $table = 'themes';
    protected $fillable = ['admin_theme','user_theme'];
    public $timestamps = false;
}
