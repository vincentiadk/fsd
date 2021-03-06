<?php

namespace App\Models;

use App\Models\Log;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'email_verified_at',
        'username',
        'last_login',
    ];

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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function log()
    {
        return $this->hasMany(Log::class, 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function hasRole($permission)
    {
        if(in_array($permission, json_decode(Role::find($this->role_id)->permissions))) {
            return true;
        } return false;
    }
    public function nasabahStatusIndex()
    {
        return $this->hasMany(nasabahStatusIndex::class, 'user_id');
    }
    protected static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            Log::create([
                'activity' => 'create',
                'logable_type' => 'users',
                'logable_id' => $model->id,
                'user_id' => session('id'),
                'description' => json_encode($model->toArray()),
            ]);
        });
        self::updated(function ($model) {
            if ($model->wasChanged('password')) {
                Log::create([
                    'activity' => 'change password',
                    'logable_type' => 'users',
                    'logable_id' => $model->id,
                    'user_id' => session('id'),
                ]);
            } else if ($model->wasChanged('enable')) {
                if ($model->enable == 0) {
                    Log::create([
                        'activity' => 'disable',
                        'logable_type' => 'users',
                        'logable_id' => $model->id,
                        'user_id' => session('id'),
                    ]);
                } else {
                    if ($model->enable == 1) {
                        Log::create([
                            'activity' => 'enable',
                            'logable_type' => 'users',
                            'logable_id' => $model->id,
                            'user_id' => session('id'),
                        ]);
                    }
                }
            } else if ($model->wasChanged('last_login')) {
                // do nothing
            } else {
                Log::create([
                    'activity' => 'update',
                    'logable_type' => 'users',
                    'logable_id' => $model->id,
                    'user_id' => session('id'),
                    'description' => json_encode($model->getChanges()),
                ]);
            }
        });
    }
}
