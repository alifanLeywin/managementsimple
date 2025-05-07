<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Transaction;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'categories_id');
    }
}
