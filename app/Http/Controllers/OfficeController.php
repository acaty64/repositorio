<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfficeRequest;
use App\Http\Requests\UpdateOfficeRequest;
use App\Models\Office;

class OfficeController extends Controller
{

    public function __construct(){
        $this->middleware('can:admin.offices.index')->only('index');
        $this->middleware('can:admin.offices.create')->only('create', 'store');
        $this->middleware('can:admin.offices.show')->only('show');
        $this->middleware('can:admin.offices.edit')->only('edit', 'update');
        $this->middleware('can:admin.offices.destroy')->only('destroy');
    }
    public function index()
    {
        //
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
