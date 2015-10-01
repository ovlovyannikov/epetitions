<?php

namespace Mygov\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $table = 'mg_users';

    protected $fillable = [
		'email',
		'password',
		'first_name',
    'middle_name',
		'last_name',
	];

    protected $hidden = [
		'password',
		'remember_token',
	];

	public function getName()
	{
		if ($this->first_name && $this->middle_name) {
			return "{$this->first_name} {$this->middle_name}";
		}

		if ($this->first_name) {
			return $this->first_name;
		}

		return null;
	}

	public function getNameOrUsername()
	{
		return $this->getName() ?: $this->username;
	}

	public function getFirstNameOrUsername()
	{
		return $this->first_name ?: $this->username;
	}

	public function getAvatarUrl()
	{
		return "http://www.gravatar.com/avatar/" . md5($this->email) . "?d=mm&s=40";
	}

  public function petitions()
	{
		return $this->hasMany('Mygov\Models\Petition', 'user_id' );
	}

  public function hasSignPetition(Petition $petition)
  {
    return (bool) $petition->signs
      ->where('user_id', $this->id)
      ->count();
  }

  public function signs()
  {
    return $this->hasMany('Mygov\Models\Sign', 'user_id' );
  }
  
  public function hasPetSignUser($petitionId,$userId)
  {
	$pet = Petition::find($petitionId);
    return (bool) $pet->signs
      ->where('user_id', $userId)
      ->count();
  }
  

}
