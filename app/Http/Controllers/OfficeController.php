<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfficeRequest;
use App\Http\Requests\UpdateOfficeRequest;
use App\Models\Office;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class OfficeController extends Controller implements \Illuminate\Routing\Controllers\HasMiddleware
{
    // fuente: https://stackoverflow.com/questions/78265691/laravel-11-middleware-authentication-with-controllers-method
    // fuente: https://laravel.com/docs/11.x/controllers#controller-middleware
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('can:admin.office.index', only: ['index']),
            new Middleware('can:admin.office.create', only: ['create', 'store']),
            new Middleware('can:admin.office.show', only: ['show']),
            new Middleware('can:admin.office.edit', only: ['edit', 'update']),
            new Middleware('can:admin.office.destroy', only: ['destroy']),
        ];
    }


    public function index()
    {
        return view('admin.office.index');
    }

    public function create()
    {
        return 'Crear oficina';
    }

    public function store(StoreOfficeRequest $request)
    {
        return 'Grabar oficina';
    }

    public function show(Office $office)
    {
        return 'Ver oficina';
    }

    public function edit(Office $office)
    {
        return 'Editar oficina';
    }

    public function update(UpdateOfficeRequest $request, Office $office)
    {
        return 'Actualizar oficina';
    }

    public function destroy(Office $office)
    {
        return 'Eliminar oficina';
    }
}
