<?php

namespace App\Helper;

use App\Models\Log;

class Helper
{
    public static function getLogs($user_id = null)
    {
        if ($user_id != null) {
            $return = Log::where('user_id', $user_id)->latest()->take(10)->get();
        } else {
            $return = Log::where('user_id', $user_id)->latest()->take(10)->get();
        }

        return $return;
    }
}