<?php

namespace App\Observers;

use App\Models\Comment;

class CommentObserver
{
	public function deleting(Comment $comment)
	{
		$comment->reactions()->delete();
	}
}
