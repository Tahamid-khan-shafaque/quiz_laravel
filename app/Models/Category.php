<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'duration', 'publish_at'];

    protected $dates = ['publish_at'];
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    

    public function publishedQuestions()
    {
        $today = Carbon::now()->startOfDay();
        return $this->questions()->whereHas('category', function ($query) use ($today) {
            $query->whereDate('publish_at', $today);
        });
    }


    public function attempts()
    {
        return $this->hasMany(Attempt::class);
    }
}
