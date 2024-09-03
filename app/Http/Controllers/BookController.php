<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Resources\BookResource;
use App\Repositories\BookRepository;
use App\Repositories\Interfaces\BookRepositoryInterface;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $bookRepository;
    
    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return BookResource::collection($this->bookRepository->all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        return new BookResource($this->bookRepository->create($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new BookResource($this->bookRepository->find($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return new BookResource($this->bookRepository->find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return new BookResource($this->bookRepository->update($id, $request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
