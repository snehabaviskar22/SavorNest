<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id', 'cuisine_id', 'name', 
        'description', 'food_type', 'image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cuisine()
    {
        return $this->belongsTo(Cuisine::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'recipe_ingredient')
                    ->withPivot('quantity', 'unit')
                    ->withTimestamps();
    }

    public function preparationSteps()
    {
        return $this->hasMany(PreparationStep::class)->orderBy('step_number');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
