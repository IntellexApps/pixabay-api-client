<?php namespace Intellex\Pixabay\Enum;

/**
 * Holds the list of all available orientations.
 */
abstract class Orientation {
	public const ALL = 'all';
	public const HORIZONTAL = 'horizontal';
	public const VERTICAL = 'vertical';

	/** @return string[] */
	public static function getAll(): array {
		return [
			self::ALL,
			self::HORIZONTAL,
			self::VERTICAL
		];
	}
}
