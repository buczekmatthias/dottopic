<?php

namespace App\Services;

final class Reactions
{
	public static function getAvailableReactions(): array
	{
		return [
			"👍" => "You liked it",
			"👎" => "You disliked it",
			"❤️" => "You loved it",
			"😂" => "You enjoyed it",
			"😢" => "You cried about it",
			"😡" => "You raged about it",
		];
	}
}
