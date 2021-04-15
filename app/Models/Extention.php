<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extention extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'name',
		'active',
    ];

    public function staff() {
      return $this->belongsTo(Staff::class);
    }

    public function findFreeExtention($clientSite)
    { 
      $extentions = Extention::where('active', 1)->get();
      foreach($extentions as $extention){
        if (Cache::has('staffonline-' . $extention->$staff->id) 
          && $extention->$staff->sites()->where('id', $clientSite->id->isNotEmpty())){
            return $extention;
          }
        }
    }
 }
