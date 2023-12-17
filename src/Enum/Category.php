<?php namespace Intellex\Pixabay\Enum;

/**
 * Holds the list of all available categories.
 */
abstract class Category {
	public const BACKGROUNDS = 'backgrounds';
	public const FASHION = 'fashion';
	public const NATURE = 'nature';
	public const SCIENCE = 'science';
	public const EDUCATION = 'education';
	public const FEELINGS = 'feelings';
	public const HEALTH = 'health';
	public const PEOPLE = 'people';
	public const RELIGION = 'religion';
	public const PLACES = 'places';
	public const ANIMALS = 'animals';
	public const INDUSTRY = 'industry';
	public const COMPUTER = 'computer';
	public const FOOD = 'food';
	public const SPORTS = 'sports';
	public const TRANSPORTATION = 'transportation';
	public const TRAVEL = 'travel';
	public const BUILDINGS = 'buildings';
	public const BUSINESS = 'business';
	public const MUSIC = 'music';

	/** @return string[] */
	public static function getAll(): array {
		return [
			self::BACKGROUNDS,
			self::FASHION,
			self::NATURE,
			self::SCIENCE,
			self::EDUCATION,
			self::FEELINGS,
			self::HEALTH,
			self::PEOPLE,
			self::RELIGION,
			self::PLACES,
			self::ANIMALS,
			self::INDUSTRY,
			self::COMPUTER,
			self::FOOD,
			self::SPORTS,
			self::TRANSPORTATION,
			self::TRAVEL,
			self::BUILDINGS,
			self::BUSINESS,
			self::MUSIC
		];
	}
}
