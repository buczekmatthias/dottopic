<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
	/** @use HasFactory<\Database\Factories\TagFactory> */
	use HasFactory;

	public function getRouteKeyName()
	{
		return 'slug';
	}

	protected $fillable = [
		'name',
		'slug'
	];

	public function categories(): MorphToMany
	{
		return $this->morphedByMany(Category::class, 'taggable');
	}

	public function articles(): MorphToMany
	{
		return $this->morphedByMany(Article::class, 'taggable');
	}

	public function scopeAlphabetically(Builder $query, bool $reversed = false)
	{
		$query->orderBy('name', $reversed ? 'DESC' : 'ASC');
	}
}
