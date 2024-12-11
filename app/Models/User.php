<?php

namespace App\Models;

use App\Enum\UserRole;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
	/** @use HasFactory<\Database\Factories\UserFactory> */
	use HasFactory;

	public function getRouteKeyName()
	{
		return 'username';
	}

	protected $fillable = [
		'name',
		'username',
		'email',
		'password',
		'image',
		'bio',
		'last_login',
		'role'
	];

	protected $hidden = [
		'password',
		'remember_token',
	];

	protected function casts(): array
	{
		return [
			'password' => 'hashed',
			'role' => UserRole::class
		];
	}

	public function getInitialsAttribute(): string
	{
		$pieces = explode(" ", $this->attributes['name']);

		return Str::upper(count($pieces) === 1 ? $pieces[0][0] : $pieces[0][0].array_pop($pieces)[0]);
	}

	public function articles(): HasMany
	{
		return $this->hasMany(Article::class);
	}

	public function comments(): HasMany
	{
		return $this->hasMany(Comment::class);
	}

	public function isWriter(): bool
	{
		return $this->attributes['role'] === UserRole::WRITER;
	}

	public function isMod(): bool
	{
		return $this->attributes['role'] === UserRole::MOD;
	}

	public function isAdmin(): bool
	{
		return $this->attributes['role'] === UserRole::ADMIN;
	}

	public function isDev(): bool
	{
		return $this->attributes['role'] === UserRole::DEV;
	}

	public function scopeType(Builder $query, UserRole $role)
	{
		$query->where('role', $role->value);
	}

	public function scopeTypeNot(Builder $query, UserRole $role)
	{
		$query->whereNot('role', $role->value);
	}
}
