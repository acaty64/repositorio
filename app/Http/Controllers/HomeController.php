<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
// implements \Illuminate\Routing\Controllers\HasMiddleware 
class HomeController extends Controller 
{
/*
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('can: dashboard', only: ['index']),
        ];
    }
*/

    public function index()
    {
        return view('admin.index');
    }
}
