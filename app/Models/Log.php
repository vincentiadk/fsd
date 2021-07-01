<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'activity',
        'description',
        'logable_type',
        'logable_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function description()
    {
        $return = '';
        if ($this->description != '') {
            foreach (json_decode($this->description, true) as $key => $value) {
                $return .= '<li>' . $key . ' - ' . $value . '</li>';
            }
        }
        return $return;
    }
}
