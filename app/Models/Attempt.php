<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attempt extends Model
{
    use HasFactory;

    protected $fillable = ['user_name', 'category_id', 'score', 'total_questions', 'correct_answers'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
