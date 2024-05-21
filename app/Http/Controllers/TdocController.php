<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTdocRequest;
use App\Http\Requests\UpdateTdocRequest;
use App\Models\Tdoc;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class TdocController extends Controller implements \Illuminate\Routing\Controllers\HasMiddleware
{
    // fuente: https://stackoverflow.com/questions/78265691/laravel-11-middleware-authentication-with-controllers-method
    // fuente: https://laravel.com/docs/11.x/controllers#controller-middleware
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('can:admin.tdoc.index', only: ['index']),
            new Middleware('can:admin.tdoc.create', only: ['create', 'store']),
            new Middleware('can:admin.tdoc.show', only: ['show']),
            new Middleware('can:admin.tdoc.edit', only: ['edit', 'update']),
            new Middleware('can:admin.tdoc.destroy', only: ['destroy']),
        ];
    }


    public function index()
    {
        return view('admin.tdoc.index');
    }

    public function create()
    {
        return 'Crear tipo de documento';
    }

    public function store(StoreTdocRequest $request)
    {
        return 'Grabar tipo de documento';
    }

    public function show(Tdoc $tdoc)
    {
        return 'Ver tipo de documento';
    }

    public function edit(Tdoc $tdoc)
    {
        return 'Editar tipo de documento';
    }

    public function update(UpdateTdocRequest $request, Tdoc $tdoc)
    {
        return 'Actualizar tipo de documento';
    }

    public function destroy(Tdoc $tdoc)
    {
        return 'Eliminar tipo de documento';
    }
}
