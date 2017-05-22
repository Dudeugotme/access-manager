<?php

namespace App\Models\Admin;

class PolicySchema extends BaseModel
{
    protected $table = 'policy_schemas';
    protected $fillable = ['name', 'mo', 'tu', 'we', 'th', 'fr', 'sa', 'su'];
    public $timestamps = false;

    public function plan()
    {
        return $this->morphMany('App\Models\Plan', 'policy');
    }

    public function monday()
    {
        return $this->belongsTo('App\Models\SchemaTemplate', 'mo');
    }

    public function tuesday()
    {
        return $this->belongsTo('App\Models\SchemaTemplate', 'tu');
    }

    public function wednesday()
    {
        return $this->belongsTo('App\Models\SchemaTemplate', 'we');
    }

    public function thursday()
    {
        return $this->belongsTo('App\Models\SchemaTemplate', 'th');
    }

    public function friday()
    {
        return $this->belongsTo('App\Models\SchemaTemplate', 'fr');
    }

    public function saturday()
    {
        return $this->belongsTo('App\Models\SchemaTemplate', 'sa');
    }

    public function sunday()
    {
        return $this->belongsTo('App\Models\SchemaTemplate', 'su');
    }
}
