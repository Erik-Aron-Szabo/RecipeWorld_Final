<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OrderScope;

class Recipe extends Model
{
  //
  // protected static function boot()
  // {
  //   parent::boot();
  //   static::addGlobalScope(new OrderScope('title', 'desc'));
  // }

  public function user()
  {
    return $this->belongTo('App\User');
  }
}
