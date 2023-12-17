<?php namespace Intellex\Pixabay\Enum;

/**
 * Holds the list of all available image types.
 */
abstract class ImageType {
	public const ALL = 'all';
	public const PHOTO = 'photo';
	public const VECTOR = 'vector';
	public const ILLUSTRATION = 'illustration';

	/** @return string[] */
	public static function getAll(): array {
		return [
			self::ALL,
			self::PHOTO,
			self::VECTOR,
			self::ILLUSTRATION
		];
	}
}
