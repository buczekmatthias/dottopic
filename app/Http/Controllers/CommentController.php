<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CommentController extends Controller
{
	public function store(CreateCommentRequest $request)
	{
		$data = $request->validated();

		$comment = Article::where('slug', $data['article'])->first()->comments()->create(['content' => $data['content'], 'slug' => Str::uuid()]);
		$comment->author_id = Auth::user()->id;

		$comment->save();

		return back();
	}

	public function update(UpdateCommentRequest $request, Comment $comment)
	{
		$comment->update($request->validated());

		return back(status: 303);
	}

	public function destroy(Comment $comment)
	{
		$comment->delete();

		return back(status: 303);
	}
}
