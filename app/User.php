<?php

namespace App;
  
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
  use LaratrustUserTrait, Notifiable, SoftDeletes;

  public $timestamps = true;
  public $guarded = ['id'];
  protected $dates = ['deleted_at'];

  /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
  protected $fillable = ['password', 'name', 'position'];

  /**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
  protected $hidden = ['password'];

  /**
	 * Get the identifier that will be stored in the subject claim of the JWT.
	 *
	 * @return mixed
	 */
  public function getJWTIdentifier()
  {
    return $this->getKey();
  }

  /**
	 * Return a key value array, containing any custom claims to be added to the JWT.
	 *
	 * @return array
	 */
  public function getJWTCustomClaims()
  {
    return [];
  }

  public function permissions()
  {
    return $this->belongsToMany(Permission::class, 'permission_user');
  }

  public function actions()
  {
    return $this->hasMany(UserAction::class);
  }

  public function employee()
  {
    return $this->belongsTo(Employee::class);
  }
}

