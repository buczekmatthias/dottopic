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
		return $this->hasMany(Article::class, 'author_id');
	}

	public function comments(): HasMany
	{
		return $this->hasMany(Comment::class, 'author_id');
	}

	public function isWriter(): bool
	{
		return $this->role === UserRole::WRITER;
	}

	public function isMod(): bool
	{
		return $this->role === UserRole::MOD;
	}

	public function isAdmin(): bool
	{
		return $this->role === UserRole::ADMIN;
	}

	public function isStaff(): bool
	{
		return $this->isMod() || $this->isAdmin();
	}

	public function isDeveloper(): bool
	{
		return in_array($this->role, [UserRole::DEV, UserRole::CREATOR]);
	}

	public function scopeType(Builder $query, string $role)
	{
		$query->where('role', $role);
	}

	public function scopeTypeNot(Builder $query, string $role)
	{
		$query->whereNot('role', $role);
	}
}
