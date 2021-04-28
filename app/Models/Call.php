<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'client',
		'staff_id',
		'comment',
		'source',
    'site',
		'is_subscribe',
    ];

  public function site() {
    return $this->belongsTo(Site::class, 'site');
  }
  public function staff() {
    return $this->belongsTo(Staff::class, 'staff_id');
  }
}
