<?php

namespace site;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
class User extends Model implements AuthenticatableContract, CanResetPasswordContract {
	use Authenticatable, CanResetPassword;
	protected $table = 'users';
	protected $fillable = ['name', 'email', 'password'];
	protected $hidden = ['password', 'remember_token'];
	protected $visible = ['name'];
	// user has many posts
	public function posts()
	{
		return $this->hasMany('site\Post');
	}
	public function posts_active()
	{
		return $this->posts()->where('active','1');
	}
	// user has many comments
	public function comments()
	{
		return $this->hasMany('site\Comment');
	}
	public function can_post()
	{
		$role = $this->role;
		if($role == 'author' || $role == 'admin')
		{
			return true;
		}
		return false;
	}
	public function is_admin()
	{
		$role = $this->role;
		if($role == 'admin')
		{
			return true;
		}
		return false;
	}
}
