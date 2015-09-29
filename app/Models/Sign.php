<?php

namespace Mygov\Models;

use Illuminate\Database\Eloquent\Model;

class Sign extends Model
{
  protected $table = 'mg_signs';


    public function signable()
    {
      return $this->morphTo();
    }

    public function user()
    {
      return $query->belongsTo('Mygov\Models\User','user_id');
    }

    public function petitions()
    {
      return $this->hasMany('Mygov\Models\Petition','petition_id');
    }
}
