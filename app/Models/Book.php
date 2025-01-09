<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory;
    use SoftDeletes;

    // Define the table name (if it's not the plural form)
    protected $table = 'books';
    protected $dates = ['deleted_at']; // This tells Eloquent to treat the deleted_at field as a Carbon instance

    // Allow mass assignment for these columns
    protected $fillable = ['book_number', 'study_title', 'authors', 'categories', 'restriction_codes'];

        public function archivedRecord()
    {
        return $this->hasOne(ArchiveBook::class);
    }
}
