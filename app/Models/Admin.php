<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
class Admin extends Authenticatable
{
    //
    use HasRoles;
    use SoftDeletes;
    protected $guarded = [];


    public function getNameAttribute()
    {
        return $this->first_name." ".$this->last_name;
    }

    public function adminActivities()
    {
        return $this->hasMany(AdminActivity::class);
    }
}
