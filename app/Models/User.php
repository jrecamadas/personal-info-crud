<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use App\Models\ACL\UserRole;

class User extends BaseModel
{
    /**
     * Attributes that should not be included to the response
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    // /**
    //  * Hash user password when newly inserted
    //  *
    //  * @param  string $pass
    //  * @return void
    //  */
    // public function setPasswordAttribute($pass)
    // {
    //     $this->attributes['password'] = Hash::make($pass);
    // }

    /**
     * Get Hash equivalent value for password
     */
    public static function getPasswordHashValue($value){
        return ($value != NULL && strlen($value) > 0) ? \Hash::make($value) : $value;
    }

    /**
     * Override Passport to allow login via user_name or email
     *
     * @param  string login
     * @return QueryBuilder
     */
    public function findForPassport($login)
    {
        return $this->where(
            function ($query) use ($login) {
                $query->where('email', $login);
                $query->orWhere('user_name', $login);
            }
        )
         ->where('can_login', 1)
         ->where('is_verified', 1)
         ->first();
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function employeeId()
    {
        return $this->hasOne(Employee::class)->select(['id']);
    }

    public function roles()
    {
        return $this->hasMany(UserRole::class);
    }

    public function updatedByUser()
    {
        return $this->belongsTo(User::class)->with('employee');
    }

    public function getUpdatedByUser()
    {
        $user = null;

        if (!is_null($this->updated_by_user_id)) {
            $user['id'] = $this->updated_by_user_id;

            if (!is_null($this->updatedByUser->employee)) {
                $user['initial'] = $this->updatedByUser->employee->getInitial();
            } else {
                $user['initial'] = $this->updatedByUser->user_name;
            }
        }

        return $user;
    }
}
