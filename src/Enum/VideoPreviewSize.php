<?php namespace Intellex\Pixabay\Enum;

/**
 * Holds the list of all available video preview sizes.
 */
abstract class VideoPreviewSize {
	public const _100_75 = '100x75';
	public const _200_150 = '200x150';
	public const _295_166 = '295x166';
	public const _640_360 = '640x360';
	public const _960_540 = '960x540';
	public const _1920_1080 = '1920x1080';

	/** @return string[] */
	public static function getAll(): array {
		return [
			self::_100_75,
			self::_200_150,
			self::_295_166,
			self::_640_360,
			self::_960_540,
			self::_1920_1080
		];
	}
}
