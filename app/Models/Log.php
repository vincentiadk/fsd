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
            /*if (isset(json_decode($this->description, true)[0])) {
                $before = json_decode($this->description, true)[0];
                $return .= 'before <ul>';
                foreach ($before as $key => $value) {
                    $return .= '<li>' . $key . ' - ' . $value . '</li>';
                }
                $return .= "</ul>";
            }
            if (isset(json_decode($this->description, true)[1])) {
                $after = json_decode($this->description, true)[1];
                $return .= 'after <ul>';
                foreach ($after as $key => $value) {
                    $return .= '<li>' . $key . ' - ' . $value . '</li>';
                }
                $return .= "</ul>";
            } else {*/
                foreach (json_decode($this->description, true) as $key => $value) {
                    $return .= '<li>' . $key . ' - ' . $value . '</li>';
                }
        }
        return $return;
    }
}
