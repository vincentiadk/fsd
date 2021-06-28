<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Log;

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
        switch ($this->role_id) {
            case '1':
                $return = "Manager";
                break;
            case '2':
                $return = "Operator Upload";
                break;
            case '3':
                $return = "Operator Indexing";
                break;
            case '4':
                $return = "Supervisor";
                break;
            case '5':
                $return = "Client";
                break;
            default:
                $return = "Lainnya";
                break;
        }
        return $return;
    }
    protected static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            Log::create([
                'activity' => 'create',
                'logable_type'  => 'users',
                'logable_id'    => $model->id,
                'user_id'   => session('id'),
                'description' => json_encode($model->toArray())
            ]);
        });
        self::updated(function ($model) {
            if($model->wasChanged('password')) {
                Log::create([
                    'activity' => 'change password',
                    'logable_type'  => 'users',
                    'logable_id'    => $model->id,
                    'user_id'   => session('id'),
                ]);
            } else {
                Log::create([
                    'activity' => 'update',
                    'logable_type'  => 'users',
                    'logable_id'    => $model->id,
                    'user_id'   => session('id'),
                    'description' => json_encode($model->getChanges())
                ]);
            }
        });
    }
}
