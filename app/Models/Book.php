<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
    'title',
    'author_id',
    'genre_id',
    'stock',
    'price',
    'published_at',
];
public function author()
{
    return $this->belongsTo(Author::class);
}
}
