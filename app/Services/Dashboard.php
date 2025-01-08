<?php

namespace App\Services;

use App\Http\Resources\Admin\ArticleResource;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Inertia\Inertia;

class Dashboard
{
	public static function getAdminDashboardData(): array
	{
		$monthStart = Carbon::now()->startOfMonth();
		$monthEnd = Carbon::now()->endOfMonth();

		$lastMonthStart = Carbon::now()->startOfMonth()->subMonth();
		$lastMonthEnd = Carbon::now()->endOfMonth()->subMonth();

		return [
			'users' => Inertia::defer(fn () => [
				'total' => User::count(),
				'monthly' => [
					'current' => User::whereBetween('created_at', [$monthStart, $monthEnd])->count(),
					'last' => User::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count(),
				]
			], 'users'),
			'articles' => Inertia::defer(fn () => [
				'total' => Article::count(),
				'monthly' => [
					'current' => Article::whereBetween('created_at', [$monthStart, $monthEnd])->count(),
					'last' => Article::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count(),
				],
				'popular' => [
					'current_month' => self::getPopularArticlesBetween([$monthStart, $monthEnd]),
					'last_month' => self::getPopularArticlesBetween([$lastMonthStart, $lastMonthEnd])
				]
			], 'articles'),
			'tags' => Inertia::defer(fn () => [
				'total' => Tag::count(),
				'unused' => Tag::has('articles', 0)->has('categories', 0)->count(),
				'popular' => [
					'current_month' => self::getPopularTagsBetween([$monthStart, $monthEnd]),
					'last_month' => self::getPopularTagsBetween([$lastMonthStart, $lastMonthEnd])
				]
			], 'tags'),
			'categories' => Inertia::defer(fn () => [
				'total' => Category::count(),
				'unused' => Category::has('articles', 0)->count(),
				'popular' => [
					'current_month' => self::getPopularCategoriesBetween([$monthStart, $monthEnd]),
					'last_month' => self::getPopularCategoriesBetween([$lastMonthStart, $lastMonthEnd])
				]
			], 'categories'),
		];
	}

	private static function getPopularArticlesBetween(array $datesBetween): AnonymousResourceCollection
	{
		return ArticleResource::collection(
			Article::select(['id', 'title', 'slug', 'created_at'])
			->whereHas('reactions', function (Builder $query) use ($datesBetween) {
				$query->whereBetween('created_at', $datesBetween);
			})
			->orWhereHas('comments', function (Builder $query) use ($datesBetween) {
				$query->whereBetween('created_at', $datesBetween);
			})
			->withCount(['reactions', 'comments'])
			->orderBy('reactions_count', 'DESC')
			->orderBy('comments_count', 'DESC')
			->orderBy('created_at', 'DESC')
			->limit(5)
			->get()
		);
	}

	private static function getPopularCategoriesBetween(array $datesBetween): Collection
	{
		return Category::select(['id', 'name', 'slug'])
			->whereHas('articles', function (Builder $query) use ($datesBetween) {
				$query->whereBetween('created_at', $datesBetween);
			})
			->withCount('articles')
			->orderBy('articles_count', 'DESC')
			->orderBy('name', 'ASC')
			->limit(5)
			->get();
	}

	private static function getPopularTagsBetween(array $datesBetween): Collection
	{
		return Tag::select(['id', 'name', 'slug'])
			->whereHas('articles', function (Builder $query) use ($datesBetween) {
				$query->whereBetween('created_at', $datesBetween);
			})
			->withCount('articles')
			->orderBy('articles_count', 'DESC')
			->orderBy('name', 'ASC')
			->limit(5)
			->get();
	}
}
