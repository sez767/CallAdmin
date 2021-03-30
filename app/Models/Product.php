<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Name;

class Product extends Name
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
		'code',
		'description_en',
		'description_ua',
		'description_ru',
		'manufacturer',
		'amount',
		'price',
		'country',
    ];
	public static $rules = [
		'name_ua' => 'required|max:255',
		'name_ru' => 'required|max:255',
		'name_en' => 'required|max:255',
		'code' => 'required',
		'price' => 'required',
		'amount' => 'required',
    ];

    /**
     * mutators
     */
    public function getDescriptionAttribute()
    {
        return $this->attributes['description'] = $this->description();
    }
    /**
     * @return string $name according to locale
     */
    public function description()
    {
        $lang = \App::getLocale();
        return $this->{"description_{$lang}"};
    }

    /**
     * relations
     */
	public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    
	public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * scopes
     */
    public function scopeByCategory($query, $categoryId)
    {
    	return $query->whereHas('categories', function($q) use ($categoryId) {
    		$q->whereCategoryId($categoryId);
    	});
    }
}
