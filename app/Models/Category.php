<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Category extends Model
{
	/** @use HasFactory<\Database\Factories\CategoryFactory> */
	use HasFactory;

	public function getRouteKeyName()
	{
		return 'slug';
	}

	protected $fillable = [
		'name',
		'slug'
	];

	public function articles(): HasMany
	{
		return $this->hasMany(Article::class);
	}

	public function tags(): MorphToMany
	{
		return $this->morphToMany(Tag::class, 'taggable');
	}

	public function scopeAlphabetically(Builder $query, bool $reversed = false)
	{
		$query->orderBy('name', $reversed ? 'DESC' : 'ASC');
	}

	public function scopeMostPopular(Builder $query)
	{
		$query->withCount('articles')->orderBy('articles_count', 'DESC');
	}
}
