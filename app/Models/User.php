<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_number',
        'name',
        'email',
        'password',
        'contact_number',
        'role',
        'status',
    ];

    protected $dates = ['deleted_at'];
    protected $hidden = ['password', 'remember_token'];

    protected $attributes = [
        'role' => 'faculty', // Default role
        'status' => 'active', // Default status
    ];

    // Role check helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isFaculty()
    {
        return $this->role === 'faculty';
    }
   
}
