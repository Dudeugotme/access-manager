<?php

namespace App\Models\Admin;

class Organisation extends BaseModel
{
    protected $table = 'organisations';
    protected $fillable = ['name', 'address', 'tin'];
    public $timestamps = false;
}
//end of file Organsation.php
