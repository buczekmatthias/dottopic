<?php

namespace App\Models;

use App\Observers\CommentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[ObservedBy(CommentObserver::class)]
class Comment extends Model
{
	/** @use HasFactory<\Database\Factories\CommentFactory> */
	use HasFactory;

	protected $fillable = [
		'content'
	];

	public function author(): BelongsTo
	{
		return $this->belongsTo(User::class, 'author_id');
	}

	public function article(): BelongsTo
	{
		return $this->belongsTo(Article::class);
	}

	public function reactions(): MorphMany
	{
		return $this->morphMany(Reaction::class, 'reactionable');
	}
}
