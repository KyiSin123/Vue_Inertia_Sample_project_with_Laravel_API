<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
    ];

    public function scopeSort($query) {

        return $query->orderBy('id', 'desc');
    }

    public function scopeFilter($query, $search)
    {
        return $query->when($search ?? false, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
    }
}
