<?php namespace Intellex\Pixabay\Enum;

/**
 * Holds the list of all available colors.
 */
abstract class Color {
	public const GRAYSCALE = 'grayscale';
	public const TRANSPARENT = 'transparent';
	public const RED = 'red';
	public const ORANGE = 'orange';
	public const YELLOW = 'yellow';
	public const GREEN = 'green';
	public const TURQUOISE = 'turquoise';
	public const BLUE = 'blue';
	public const LILAC = 'lilac';
	public const PINK = 'pink';
	public const WHITE = 'white';
	public const GRAY = 'gray';
	public const BLACK = 'black';
	public const BROWN = 'brown';

	/** @return string[] */
	public static function getAll(): array {
		return [
			self::GRAYSCALE,
			self::TRANSPARENT,
			self::RED,
			self::ORANGE,
			self::YELLOW,
			self::GREEN,
			self::TURQUOISE,
			self::BLUE,
			self::LILAC,
			self::PINK,
			self::WHITE,
			self::GRAY,
			self::BLACK,
			self::BROWN
		];
	}
}
