<?php

namespace App\Enum;

enum Table: string
{
	use EnumTraits;

	case ARTICLES = "articles";
	case CATEGORIES = "categories";
	case TAGS = "tags";
	case USERS = "users";
}
