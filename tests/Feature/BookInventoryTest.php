<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BookInventoryTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_add_a_new_book()
    {
        // Make a POST request to the store method
        $response = $this->post('/books', [
            'book_number' => '123',
            'study_title' => 'Testing Laravel',
            'authors' => 'Jane Doe',
            'categories' => 'Programming',
            'restriction_codes' => 'None',
        ]);

        // Assert the book exists in the database
        $this->assertDatabaseHas('books', [
            'book_number' => '123',
            'study_title' => 'Testing Laravel',
        ]);

        // Assert the response contains a success message
        $response->assertJson([
            'message' => 'Book added successfully.',
        ]);
    }

    #[Test]
    public function it_can_edit_an_existing_book()
    {
        // Create a sample book
        $book = Book::factory()->create([
            'book_number' => '123',
            'study_title' => 'Old Title',
            'authors' => 'Old Author',
            'categories' => 'Old Category',
        ]);

        // Make a PUT request to update the book
        $response = $this->put("/books/{$book->id}", [
            'book_number' => '123',
            'study_title' => 'Updated Title',
            'authors' => 'Updated Author',
            'categories' => 'Updated Category',
            'restriction_codes' => 'Updated Code',
        ]);

        // Assert the book is updated in the database
        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'study_title' => 'Updated Title',
            'authors' => 'Updated Author',
        ]);

        // Assert the response indicates success
        $response->assertJson([
            'success' => true,
        ]);
    }

    #[Test]
    public function it_can_archive_a_book()
    {
        // Create a sample book
        $book = Book::factory()->create();

        // Make a DELETE request to archive the book
        $response = $this->delete("/books/{$book->id}");

        // Assert the book is soft-deleted
        $this->assertSoftDeleted('books', [
            'id' => $book->id,
        ]);

        // Assert the response contains a success message
        $response->assertRedirect(route('admin.book_inventory'));
    }
}
