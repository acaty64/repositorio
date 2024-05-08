<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Models\Document;
use Illuminate\Routing\Controllers\Middleware;

class DocumentController extends Controller
{
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('admin.document.index', only: ['index']),
            new Middleware('admin.document.create', only: ['create', 'store']),
            new Middleware('admin.document.show', only: ['show']),
            new Middleware('admin.document.edit', only: ['edit', 'update']),
            new Middleware('admin.document.destroy', only: ['destroy']),
        ];
    }

    public function index()
    {
        return 'Lista de documentos';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return 'Creación de documento';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocumentRequest $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        //
    }
}
