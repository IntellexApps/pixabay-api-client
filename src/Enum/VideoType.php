<?php namespace Intellex\Pixabay\Enum;

/**
 * Holds the list of all available video types.
 */
abstract class VideoType {
	public const ALL = 'all';
	public const FILM = 'film';
	public const ANIMATION = 'animation';

	/** @return string[] */
	public static function getAll(): array {
		return [
			self::ALL,
			self::FILM,
			self::ANIMATION
		];
	}
}
