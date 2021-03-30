<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Name;

class Category extends Name
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'name_en',
		'name_ua',
		'name_ru',
		'active',
    ];

    /**
     * relations
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
    
    /**
     * scopes
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
