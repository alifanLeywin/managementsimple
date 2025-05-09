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

    protected static function boot()
{
    parent::boot();

    static::updating(function ($category) {
        if ($category->isDirty('image')) {
            $oldImage = $category->getOriginal('image');

            if ($oldImage && \Storage::disk('public')->exists($oldImage)) {
                \Storage::disk('public')->delete($oldImage);
            }
        }
    });

    static::deleting(function ($category) {
        if ($category->image && \Storage::disk('public')->exists($category->image)) {
            \Storage::disk('public')->delete($category->image);
        }
    });
}


}
