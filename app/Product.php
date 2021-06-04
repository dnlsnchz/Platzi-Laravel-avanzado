<?php

namespace App;
use App\Category;
use App\User;
use App\Events\ProductCreating;
use App\Utils\CanBeRate;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use CanBeRate;

    protected $dispatchesEvents = [
        'creating' => ProductCreating::class,
    ];

    protected static function booted()
    {
        static::creating(function (Product $product) {
            $faker = \Faker\Factory::create();
            $product->image_url = $faker->imageUrl();
            $product->createdBy()->associate(auth()->user());
        });
        static::deleting(function (Product $product) {
            $product->qualifications()->delete();
        });
    }
    protected $guarded = [];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function name(): string
    {
        return $this->name;
    }
/*
    public function ratings()
    {
        return $this->belongsToMany(User::class, 'ratings')
            ->using(Rating::class)
            ->as('users')
            ->withTimestamps();
    }
    public function averageRating(): float
    {
        return $this->ratings()->avg('score') ?: 0.0;
    }*/
}
