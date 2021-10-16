<?php
namespace App\Models;

use App\UserBankInfomation;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $guarded = [];
    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getNameAttribute()
    {
        return $this->first_name." ".$this->last_name;
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function walletHistory()
    {
        return $this->hasOne(WalletHistory::class);
    }

    public function walletRequest()
    {
        return $this->hasOne(WalletRequest::class);
    }

    public function accountInfo()
    {
        return $this->hasOne(UserBankInfomation::class);
    }

    public function userActivities()
    {
        return $this->hasMany(UserActivity::class);
    }

}