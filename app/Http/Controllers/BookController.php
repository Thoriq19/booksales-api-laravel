<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with('author')->get();
        return response()->json([
            "success" => true,
            "message" => "Get All Resource",
            "data" => $books
        ], 200);
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
    public function store(Request $request)
    {
        $validated = $request->validate([
        'title' => 'required|string|max:255',
        'author_id' => 'required|exists:authors,id',
        'genre_id' => 'required|exists:genres,id',
    ]);

    // Simpan data buku baru
    $books = Book::create($validated);

    // Kembalikan response JSON
    return response()->json($books, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $books = Book::find($id);
        if (!$books) {
            return response()->json(['message' => 'Book not found'], 404);
        }
        return response()->json($books);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
         $books = Book::find($id);
        $request->validate([
        'name' => 'required|string|max:255',
        'author_id' => 'sometimes|required|exists:authors,id',
        'genre_id' => 'sometimes|required|exists:genres,id',
         'stock' => 'required|integer|min:0'
    ]);

    $books->update($request->all());

    return response()->json([
        'message' => 'Book updated successfully',
        'data' => $books,
    ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $books = Book::find($id);
        if (!$books) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $books->delete();
        return response()->json(['message' => 'Book deleted']);
    }
}
