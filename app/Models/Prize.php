<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'quantity', 'remaining'];

    public function winners()
    {
        return $this->hasMany(Winner::class);
    }
}
