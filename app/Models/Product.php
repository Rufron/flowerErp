<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'stock',
        'image',
        'employee_id',
    ];

    // A product belongs to one employee
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
