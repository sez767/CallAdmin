<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Callrequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'name',
    'phone',
    'site',
    'status',
    'staff',
    'comment'
  ];

  public function sites() {
    return $this->belongsTo(Site::class, 'site');
  }
  public function staffs() {
    return $this->belongsTo(Staff::class, 'staff');
  }
}