<?php

namespace App\Models\Admin;

class EmailTemplate extends BaseModel
{
    protected $table = 'email_templates';
    protected $fillable = ['name', 'subject', 'body'];

    public $timestamps = false;
}
