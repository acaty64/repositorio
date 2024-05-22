<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Models\Permission;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller implements \Illuminate\Routing\Controllers\HasMiddleware
{
    // fuente: https://stackoverflow.com/questions/78265691/laravel-11-middleware-authentication-with-controllers-method
    // fuente: https://laravel.com/docs/11.x/controllers#controller-middleware
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('can:admin.permission.index', only: ['index']),
        ];
    }


    public function index()
    {
        return view('admin.permission.index');
    }
}
