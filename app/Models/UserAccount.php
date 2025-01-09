<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    use HasFactory;

      // Explicitly define the table name
      protected $table = 'user_accounts';

    protected $fillable = ['email', 'password'];
}
