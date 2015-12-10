<?php

namespace Mygov\Models;

use Illuminate\Database\Eloquent\Model;

class Petition extends Model
{
  protected $table = 'mg_petitions';
  protected $fillable = [
      'body',
      'title',
      'status',
      'sign',
      'checked',
      'user_id',
	    'num',
      'done'
    ];

    public function user()
    {
      return $this->belongsTo('Mygov\Models\User','user_id');
    }

    public function scopeActivePetitions($query)
    {
      return $query->where('status','1');
    }

    public function signs()
    {
      return $this->morphMany('Mygov\Models\Sign','signable');
    }

}
