<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'admin/report/datatable',
        'admin/dashboard/datatable-realtime',
        'admin/dashboard/datatable-tuntas',
        'admin/dashboard/datatable-upload',
        'admin/log/datatable',
        'admin/user/datatable'
    ];
}
