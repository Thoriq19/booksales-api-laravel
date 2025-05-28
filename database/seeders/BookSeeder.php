<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            [
                'title' => 'Harry Potter and the Sorcerer\'s Stone',
                'author_name' => 'J.K. Rowling',
                'genre_name' => 'Fantasy',
                'price' => 120000,
                'stock' => 20,
                'published_at' => '1997-06-26'
            ],
            [
                'title' => 'A Game of Thrones',
                'author_name' => 'George R.R. Martin',
                'genre_name' => 'Fantasy',
                'price' => 150000,
                'stock' => 20,
                'published_at' => '1996-08-06'
            ],
            [
                'title' => 'The Hobbit',
                'author_name' => 'J.R.R. Tolkien',
                'genre_name' => 'Fantasy',
                'price' => 130000,
                'stock' => 20,
                'published_at' => '1937-09-21'
            ],
            [
                'title' => "The Shining",
                'author_name' => 'Stephen King',
                'genre_name' => 'Mystery',
                'price' => 135000,
                'stock' => 20,
                'published_at' => '1977-01-28',
            ],
            [
                'title' => "Murder on the Orient Express",
                'author_name' => 'Agatha Christie',
                'genre_name' => 'Mystery',
                'price' => 99000,
                'stock' => 20,
                'published_at' => '1934-01-01',
            ],
        ];

        foreach ($books as $book) {
            $author = Author::where('name', $book['author_name'])->first();
            $genre = Genre::where('name', $book['genre_name'])->first();

            if ($author && $genre) {
                Book::create([
                    'title' => $book['title'],
                    'author_id' => $author->id,
                    'genre_id' => $genre->id,
                    'price' => $book['price'],
                    'stock' => $book['stock'],
                    'published_at' => $book['published_at'],
                ]);
            }
        }
    }
}
