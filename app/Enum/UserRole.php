<?php

namespace App\Enum;

enum UserRole: string
{
	use EnumTraits;

	case USER = "user";
	case WRITER = "writer";
	case MOD = "mod";
	case ADMIN = "admin";
	case DEV = "dev";
	case CREATOR = "creator";
}
