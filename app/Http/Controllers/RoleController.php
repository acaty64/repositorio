<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements \Illuminate\Routing\Controllers\HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('can:admin.role.index', only: ['index']),
        ];
    }


    public function index()
    {
        return view('admin.role.index');
    }
}
