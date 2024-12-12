<?php

namespace App\Services;

final class SlugGenerator
{
	public static function generate(string $s): string
	{
		return implode('-', explode(" ", $s));
	}
}
