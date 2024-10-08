<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Repositories\BookRepository;
use App\Repositories\Interfaces\BookRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
    public function update(UpdateBookRequest $request, string $id)
    {
        return new BookResource($this->bookRepository->update($id, $request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->bookRepository->delete($id);

        return response()->json(['message' => 'Livro excluído com sucesso.'], 200);
    }

    /**
     * Get book by ISBN
     */
    public function getByIsbn(string $isbn)
    {
        return new BookResource($this->bookRepository->getByIsbn($isbn));
    }
}
