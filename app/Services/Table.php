<?php

namespace App\Services;

use App\Enum\Table as EnumTable;
use Illuminate\Support\Facades\Auth;

final class Table
{
	public static function getTableContext(EnumTable $page): array
	{
		return match ($page) {
			EnumTable::ARTICLES => self::getArticlesTableContext(),
			EnumTable::CATEGORIES => self::getCategoriesTableContext(),
			EnumTable::TAGS => self::getTagsTableContext(),
			EnumTable::USERS => self::getUsersTableContext()
		};
	}

	private static function getArticlesTableContext(): array
	{
		return [
			'headers' => [
				['column' => "title", 'header' => "title", 'as' => "text"],
				['column' => "description", 'header' => "description", 'as' => "text"],
				[
					'column' => "author",
					'header' => "author",
					'as' => "link",
					'link' => [
						'route' => "users.show",
						'parameterKey' => "user",
						'parameterValue' => "username",
						'textValue' => "name",
					],
				],
				[
					'column' => "category",
					'header' => "category",
					'as' => "link",
					'link' => [
						'route' => "categories.show",
						'parameterKey' => "category",
						'parameterValue' => "slug",
						'textValue' => "name",
					],
				],
				['column' => "reactions_count", 'header' => "reactions", 'as' => "text"],
				['column' => "comments_count", 'header' => "comments", 'as' => "text"],
				['column' => "tags_count", 'header' => "tags", 'as' => "text"],
				['column' => "created_at", 'header' => "created", 'as' => "text"],
			],
			'actions' => [
				[
					'icon' => "octicon:link-external-24",
					'route' => "articles.show",
					'parameterKey' => "article",
					'parameterValue' => "slug",
					'method' => "GET",
				],
				[
					'icon' => "octicon:trash-16",
					'route' => "articles.destroy",
					'parameterKey' => "article",
					'parameterValue' => "slug",
					'method' => "DELETE",
					'color' => "text-red-500",
				],
			],
			'hidden' => ['slug'],
			'sortable' => [
				"id",
				"title",
				"author",
				"category",
				"reactions_count",
				"comments_count",
				"tags_count",
				"created_at",
			],
		];
	}

	private static function getCategoriesTableContext(): array
	{
		return [
			'headers' => [
				['column' => "name", 'header' => "name", 'as' => "text"],
				['column' => "articles_count", 'header' => "articles", 'as' => "text"],
				['column' => "tags_count", 'header' => "tags", 'as' => "text"],
			],
			'actions' => [
				[
					'icon' => "octicon:link-external-24",
					'route' => "categories.show",
					'parameterKey' => "category",
					'parameterValue' => "slug",
					'method' => "GET",
				],
				[
					'icon' => "octicon:trash-16",
					'route' => "admin.categories.destroy",
					'parameterKey' => "category",
					'parameterValue' => "slug",
					'method' => "DELETE",
					'color' => "text-red-500",
				],
			],
			'hidden' => ['slug'],
			'sortable' => [
				"id",
				"name",
				"articles_count",
				"tags_count",
			],
		];
	}

	private static function getTagsTableContext(): array
	{
		return [
			'headers' => [
				['column' => "name", 'header' => "name", 'as' => "text"],
				['column' => "articles_count", 'header' => "articles", 'as' => "text"],
				['column' => "categories_count", 'header' => "categories", 'as' => "text"],
			],
			'actions' => [
				[
					'icon' => "octicon:link-external-24",
					'route' => "tags.show",
					'parameterKey' => "tag",
					'parameterValue' => "slug",
					'method' => "GET",
				],
				[
					'icon' => "octicon:trash-16",
					'route' => "admin.tags.destroy",
					'parameterKey' => "tag",
					'parameterValue' => "slug",
					'method' => "DELETE",
					'color' => "text-red-500",
				],
			],
			'hidden' => ['slug'],
			'sortable' => [
				"id",
				"name",
				"articles_count",
				"categories_count",
			],
		];
	}

	private static function getUsersTableContext(): array
	{
		$table = [
			'headers' => [
				['column' => "name", 'header' => "name", 'as' => "text"],
				['column' => "username", 'header' => "username", 'as' => "text"],
				['column' => "email", 'header' => "e-mail", 'as' => "text"],
				['column' => "role", 'header' => "role", 'as' => "text", 'useAsClass' => true],
				['column' => "articles_count", 'header' => "articles", 'as' => "text"],
				['column' => "comments_count", 'header' => "comments", 'as' => "text"],
				['column' => "created_at", 'header' => "created", 'as' => "text"],
			],
			'actions' => [
				[
					'icon' => "octicon:link-external-24",
					'route' => "users.show",
					'parameterKey' => "user",
					'parameterValue' => "username",
					'method' => "GET",
				],
				[
					'icon' => "octicon:trash-16",
					'route' => "users.destroy",
					'parameterKey' => "user",
					'parameterValue' => "username",
					'method' => "DELETE",
					'color' => "text-red-500",
				],
			],
			'hidden' => [],
			'sortable' => [
				"id",
				"name",
				"username",
				"email",
				"articles_count",
				"comments_count",
				"created_at",
			],
		];

		/** @var \App\Models\User */
		$user = Auth::user();

		if ($user->isAdmin() || $user->isDeveloper()) {
			$table['actions'] = [
				[
					'icon' => "octicon:arrow-up",
					'route' => "admin.users.promote",
					'parameterKey' => "user",
					'parameterValue' => "username",
					'method' => "GET",
					'disabledKey' => 'can_be_promoted'
				],
				[
					'icon' => "octicon:arrow-down",
					'route' => "admin.users.demote",
					'parameterKey' => "user",
					'parameterValue' => "username",
					'method' => "GET",
					'disabledKey' => 'can_be_demoted'
				],
				...$table['actions']
			];
		}

		return $table;
	}
}
