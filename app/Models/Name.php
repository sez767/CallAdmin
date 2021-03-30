<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * provides with 
 */
class Name extends Model
{
	/**
     * mutators
     */
    public function getNameAttribute()
    {
        return $this->attributes['name'] = $this->name();
    }
    /**
     * @return string $name according to locale
     */
    public function name()
    {
        $lang = \App::getLocale();
        return $this->{"name_{$lang}"};
    }

    public function scopeByInquire($query, $inquire)
    {
        return $query->where('name_ua', 'LIKE', "%{$inquire}%")
            ->orWhere('name_ru', 'LIKE', "%{$inquire}%")
            ->orWhere('name_en', 'LIKE', "%{$inquire}%");
    }
	
}