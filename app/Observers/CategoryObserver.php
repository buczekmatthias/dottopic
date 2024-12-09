<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
	public function deleting(Category $category)
	{
		$category->tags()->delete(); // OR DETACH - TEST LATER
	}
}
