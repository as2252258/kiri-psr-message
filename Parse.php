<?php

namespace Kiri\Message;

use Kiri\Core\Xml;

class Parse
{


	/**
	 * @param $content
	 * @return mixed
	 * @throws \Exception
	 */
	public static function data($content): mixed
	{
		if (empty($content)) {
			return null;
		}
		if (is_bool($content) || is_numeric($content)) {
			return $content;
		}
		$start = substr($content, 0, 1);
		return match ($start) {
			'<' => Xml::toArray($content),
			'[', '{' => json_decode($content, true),
			default => call_user_func(static function () use ($content) {
				parse_str($content, $array);
				return $array;
			})
		};
	}

}
