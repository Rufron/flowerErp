<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // use this if employees log in
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    // An employee can add many products
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
