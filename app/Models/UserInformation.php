<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    use HasFactory;
    // Explicitly define the table name
    protected $table = 'user_informations';

    protected $fillable = ['name', 'role', 'status', 'contact_number', 'email', 'user_accounts_id'];
}
