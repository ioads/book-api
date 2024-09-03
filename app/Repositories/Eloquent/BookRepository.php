<?php

namespace App\Repositories\Eloquent;

use App\Models\Book;
use App\Repositories\Interfaces\BookRepositoryInterface;

class BookRepository implements BookRepositoryInterface
{
    protected $model;

    public function __construct(Book $book)
    {
        $this->model = $book;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        $book = $this->model->create($data);
        $book->author()->create($data['author']);
        return $book;
    }

    public function update($id, array $data)
    {
        $book = $this->model->find($id);
        $book->update($data);
        $book->author()->first()->update($data['author']);
        return $book;
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}