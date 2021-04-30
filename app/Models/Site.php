<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Processors\AvatarProcessor;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'is_active',
        'is_chat',
        'is_answer',
        'answer_text',
        'answer_sec',
        'location',
        'header',
        'widget_color',
        'widget_size'
    ];

    public function file() {
        return $this->belongsTo(File::class);
    }
    public function staff() {
        return $this->belongsToMany(Staff::class);
    }
    public function calls() {
        return $this->hasMany(Call::class);
    }

    public function getAvatarFilenameAttribute() {
        if (!empty($this->file)) {
            return $this->file->name;
        }
        return null;
    }

    public function getAvatarAttribute() {
        return AvatarProcessor::get($this);
    }

}
