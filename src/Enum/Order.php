<?php namespace Intellex\Pixabay\Enum;

/**
 * Holds all the possible values for the order search parameter.
 */
abstract class Order {
	public const POPULAR = 'popular';
	public const LATEST = 'latest';

	/** @return string[] */
	public static function getAll(): array {
		return [
			self::POPULAR,
			self::LATEST
		];
	}
}
