<?php

namespace App\Repositories\Eloquent;

use App\Models\Book;
use App\Repositories\Interfaces\BookRepositoryInterface;
use Illuminate\Support\Facades\Storage;

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
        if($data['image']) {
            $extension  = $data['image']->getClientOriginalExtension();
            $image_name = time() .'_' . str_replace(' ', '_', $data['title']) . '.' . $extension;
            $path = $data['image']->storeAs(
                'images',
                $image_name,
                's3'
            );

            $data['image'] = Storage::disk('s3')->url($path);
        }
        
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