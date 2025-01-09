<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\ArchiveBook;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    // Store a new book
    public function store(Request $request)
    {
        // Log the incoming request data for debugging
        Log::info('Incoming book data: ', $request->all());
    
        // Validate the incoming request
        $request->validate([
            'book_number' => 'required|unique:books',
            'study_title' => 'required',
            'authors' => 'required',
            'categories' => 'required',
        ]);
    
        try {
            // Create the book in the database
            $book = Book::create([
                'book_number' => $request->book_number,
                'study_title' => $request->study_title,
                'authors' => $request->authors,
                'categories' => $request->categories,
                'restriction_codes' => $request->restriction_codes,  // Optional
            ]);
    
            // Log the created book data for debugging
            Log::info('Created book: ', $book->toArray());
    
            // Return the created book as a JSON response
            return response()->json([
                'book' => $book,
                'message' => 'Book added successfully!',
            ]);
        } catch (\Exception $e) {
            // Log the error and return an error response
            Log::error('Error adding book: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error adding book. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    // Index with search filters
    public function index(Request $request)
    {
        // Retrieve filter parameters from the request
        $category = $request->input('category');
        $title = $request->input('title');
        $researcher = $request->input('researcher');
        
        // Build the query
        $books = Book::query();

        if ($category) {
            $books = $books->where('categories', 'like', "%$category%");
        }
        if ($title) {
            $books = $books->where('study_title', 'like', "%$title%");
        }
        if ($researcher) {
            $books = $books->where('authors', 'like', "%$researcher%");
        }

        // Fetch the filtered books
        $books = $books->get();

        return view('admin.book_inventory', compact('books')); // Pass the filtered books to the view
    }
    //EditBooks
    // Fetch a single book for editing
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return response()->json($book);
    }
    
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'book_number' => 'required|string|max:255',
                'study_title' => 'required|string|max:255',
                'authors' => 'required|string|max:255',
                'categories' => 'required|string|max:255',
                'restriction_codes' => 'nullable|string|max:255',
            ]);

            $book = Book::findOrFail($id);
            $book->update($validated);

            return response()->json([
                'success' => true,
                'book' => $book,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Method for archiving (soft deleting) a book
    public function archiveBook($id)
    {
        $book = Book::findOrFail($id);
        $book->delete(); // Soft delete the book

        return redirect()->route('admin.book_inventory')->with('message', 'Book archived successfully');
    }

    // Method for restoring a soft-deleted book (optional, if needed)
    public function restoreBook($id)
    {
        $book = Book::withTrashed()->findOrFail($id);
        $book->restore(); // Restore the book

        return redirect()->route('admin.book_inventory')->with('message', 'Book restored successfully');
    }
}