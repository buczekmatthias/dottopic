<?php

namespace App\Models;

use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

#[ObservedBy(CategoryObserver::class)]
class Category extends Model
{
	/** @use HasFactory<\Database\Factories\CategoryFactory> */
	use HasFactory;

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
}
