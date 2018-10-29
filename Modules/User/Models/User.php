<?php

namespace Modules\User\Models;

use Balping\HashSlug\HasHashSlug;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;
use Modules\Core\Models\CoreModel;
use Modules\Core\Traits\Model\Purgeable;
use Modules\Task\Models\Task;
use Modules\User\Notifications\PasswordWasReset;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends CoreModel implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable;
    use CanResetPassword;
    use HasRoles;
    use Notifiable;

    // automatic fake model id
    use HasHashSlug;

    use Purgeable;
    protected $purge = [
        'current_password',
    ];

    protected $appends = ['full_name'];

    protected $casts = [
        'admin' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'confirmation_code',
        'active',
        'confirmed',
    ];

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The validation rules.
     *
     * @var array
     */
    protected $rules = [
        'name' => 'required|max:50',
        'email' => 'required|email|unique:users',
    ];

    ###################################################################
    # RELATIONSHIPS START
    ###################################################################

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    ###################################################################
    # RELATIONSHIPS END
    ###################################################################

    ###################################################################
    # SCOPES START
    ###################################################################

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    ###################################################################
    # SCOPES END
    ###################################################################

    ###################################################################
    # ACCESSROS START
    ###################################################################

    public function getFullNameAttribute()
    {
        return $this->name;
    }

    ###################################################################
    # ACCESSROS END
    ###################################################################

    ###################################################################
    # MUTATORS START
    ###################################################################

    //

    ###################################################################
    # MUTATORS END
    ###################################################################

    ###################################################################
    # GENERAL FUNCTIONS START
    ###################################################################

    public function isSuperAdmin()
    {
        return $this->admin == 1;
    }

    /**
     * Override method of CanResetPassword
     * Send the password reset notification.
     *
     * @param  string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordWasReset($token));
    }

    ###################################################################
    # GENERAL FUNCTIONS END
    ###################################################################

}
