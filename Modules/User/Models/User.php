<?php

namespace Modules\User\Models;

use Balping\HashSlug\HasHashSlug;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Modules\Core\Models\CoreModel;
use Modules\Core\Traits\Model\Purgeable;
use Modules\Task\Models\Task;
use Modules\User\Notifications\VerifyEmail;

class User extends CoreModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    MustVerifyEmail
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmailTrait;
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
        'active',
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
        return $this->admin;
    }

    /**
     * Mark the given user's email as verified.
     *
     * @return bool
     */
    public function markEmailAsVerified(): bool
    {
        $result = $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();

        if ($result) {
            flash('Your account has been verified successfully!', 'success');
        }

        return $result;
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        try {
            $this->notify(new VerifyEmail);
        } catch (\Exception $e) {
        }
    }

    /**
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */
    public function receivesBroadcastNotificationsOn()
    {
        return 'app.events';
    }

    ###################################################################
    # GENERAL FUNCTIONS END
    ###################################################################

}
