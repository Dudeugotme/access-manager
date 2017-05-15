<?php

namespace App\Models\Admin\Subnet;

class UserRoute extends BaseModel
{

    protected $table = 'user_routes';
    protected $fillable = ['user_id','subnet','assigned_on'];
    public $timestamps = false;
}

//end of file UserRoute.php
