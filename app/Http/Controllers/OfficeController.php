<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfficeRequest;
use App\Http\Requests\UpdateOfficeRequest;
use App\Models\Office;
use Illuminate\Routing\Controllers\Middleware;

class OfficeController extends Controller
{

    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('admin.office.index', only: ['index']),
            new Middleware('admin.office.create', only: ['create', 'store']),
            new Middleware('admin.office.show', only: ['show']),
            new Middleware('admin.office.edit', only: ['edit', 'update']),
            new Middleware('admin.office.destroy', only: ['destroy']),
        ];
    }


    public function index()
    {
        return view('admin.office.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOfficeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Office $office)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Office $office)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOfficeRequest $request, Office $office)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Office $office)
    {
        //
    }
}
