<?php

namespace App\Observers;

use App\Models\Article;

class ArticleObserver
{
	public function deleting(Article $article)
	{
		$article->reactions()->delete();
		$article->tags()->delete(); // OR DETACH - TEST LATER
	}
}
