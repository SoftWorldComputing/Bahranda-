<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVerificationToken extends Model
{
    //
    public $table = "users_verification_tokens";
    protected $guarded = [];
}
