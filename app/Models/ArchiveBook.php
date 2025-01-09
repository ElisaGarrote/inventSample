<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchiveBook extends Model
{
    protected $fillable = ['book_id', 'reason'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
