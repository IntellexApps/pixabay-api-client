<?php declare(strict_types = 1);

namespace Intellex\Pixabay\Search;

use Intellex\Pixabay\Enum\Category;
use Intellex\Pixabay\Enum\Color;
use Intellex\Pixabay\Enum\ImageType;
use Intellex\Pixabay\Enum\Language;
use Intellex\Pixabay\Enum\Order;
use Intellex\Pixabay\Enum\Orientation;
use Intellex\Pixabay\Enum\VideoType;
use Intellex\Pixabay\Exception\InvalidSearchParamValue;
use Intellex\Pixabay\Exception\UnsupportedApiSearchParam;

/**
 * Contains the list of all keys used by the Pixabay search API endpoint.
 */
abstract class PixabayParam {

	/**
	 * @const string URL encoded search term.
	 * If omitted, all images/videos are returned. This value may not exceed 100 characters.
	 * Example: "yellow+flower".
	 */
	public const Q = 'q';

	/**
	 * @const string Language code of the language to be searched in.
	 * Accepted values: {@see Language}.
	 * Default: {@see Language::EN}.
	 */
	public const LANG = 'lang';

	/**
	 * @const string Filter results by image type.
	 * Accepted values: {@see ImageType}.
	 * Default: {@see ImageType::ALL}.
	 */
	public const IMAGE_TYPE = 'image_type';

	/**
	 * @const string Filter results by video type.
	 * Accepted values: {@see VideoType}.
	 * Default: {@see VideoType::ALL}.
	 */
	public const VIDEO_TYPE = 'video_type';

	/**
	 * @const string Whether an image is wider than it is tall, or taller than it is wide.
	 * Accepted values: {@see Orientation}.
	 * Default: {@see Orientation::ALL}.
	 */
	public const ORIENTATION = 'orientation';

	/**
	 * @const string Filter results by category.
	 * Accepted values: {@see Category}.
	 */
	public const CATEGORY = 'category';

	/**
	 * @const int Minimum image/video width.
	 * Default: 0.
	 */
	public const MIN_WIDTH = 'min_width';

	/**
	 * @const int Minimum image/video height.
	 * Default: 0.
	 */
	public const MIN_HEIGHT = 'min_height';

	/**
	 * @const string Filter images by color properties, with comma separated list of values.
	 * Accepted values: {@see Color}.
	 */
	public const COLORS = 'colors';

	/**
	 * @const bool Select only images/video that have received an Editor's Choice award.
	 * Accepted values: true or false.
	 * Default: false.
	 */
	public const EDITORS_CHOICE = 'editors_choice';

	/**
	 * @const bool A flag indicating that only images/videos suitable for all ages should be returned.
	 * Accepted values: true or false.
	 * Default: false.
	 */
	public const SAFE_SEARCH = 'safe_search';

	/**
	 * @const string How the results should be ordered.
	 * Accepted values: {@see Order}.
	 * Default: {@see Order::POPULAR}.
	 */
	public const ORDER = 'order';

	/**
	 * @const int Returned search results are paginated. Use this parameter to select the page number.
	 * Default: 1.
	 */
	public const PAGE = 'page';

	/**
	 * @const int Determine the number of results per page.
	 * Accepted values: 3 - 200.
	 * Default: 20.
	 */
	public const PER_PAGE = 'per_page';

	/** @return string[] The list of all supported parameter names. */
	public static function getAll(): array {
		return [
			static::Q,
			static::LANG,
			static::IMAGE_TYPE,
			static::VIDEO_TYPE,
			static::ORIENTATION,
			static::CATEGORY,
			static::MIN_WIDTH,
			static::MIN_HEIGHT,
			static::COLORS,
			static::EDITORS_CHOICE,
			static::SAFE_SEARCH,
			static::ORDER,
			static::PAGE,
			static::PER_PAGE,
		];
	}

	/**
	 * Test multiple parameters and their values at once.
	 *
	 * @param array<string, mixed> $parameters The associative array of parameters and their respective values.
	 *
	 * @return array<string, mixed> The parameters with all values parsed to a proper type.
	 *
	 * @throws InvalidSearchParamValue
	 * @throws UnsupportedApiSearchParam
	 */
	public static function assertParameters(array $parameters): array {
		foreach ($parameters as $name => $value) {
			$parameters[$name] = self::assertParameterValue($name, $value);
		}

		return $parameters;
	}

	/**
	 * Assert that the parameter and its value are valid.
	 *
	 * @param string $paramName The name of the parameter.
	 * @param mixed  $value     The supplied value.
	 *
	 * @return bool|int|string The supplied value parsed into the proper type.
	 *
	 * @throws InvalidSearchParamValue
	 * @throws UnsupportedApiSearchParam
	 *
	 * @phpcs:disable Generic.Metrics.CyclomaticComplexity
	 */
	public static function assertParameterValue(string $paramName, $value) {
		switch ($paramName) {
			case self::Q:
				if (strlen((string) $value) > 100) {
					throw new InvalidSearchParamValue($paramName, $value, "Cannot contain more than 100 characters");
				}
				break;

			case self::LANG:
				self::assertParameterValueInArray($paramName, $value, Language::getAll());
				break;

			case self::IMAGE_TYPE:
				self::assertParameterValueInArray($paramName, $value, ImageType::getAll());
				break;

			case self::VIDEO_TYPE:
				self::assertParameterValueInArray($paramName, $value, VideoType::getAll());
				break;

			case self::ORIENTATION:
				self::assertParameterValueInArray($paramName, $value, Orientation::getAll());
				break;

			case self::CATEGORY:
				self::assertParameterValueInArray($paramName, $value, Category::getAll());
				break;

			case self::COLORS:
				$colors = explode(',', (string) $value);
				foreach ($colors as $color) {
					self::assertParameterValueInArray($paramName, $color, Color::getAll());
				}
				break;

			case self::ORDER:
				self::assertParameterValueInArray($paramName, $value, Order::getAll());
				break;

			case self::EDITORS_CHOICE:
			case self::SAFE_SEARCH:
				if (!in_array($value, [ false, true ], true)) {
					throw new InvalidSearchParamValue($paramName, $value, [ false, true ]);
				}
				return (bool) $value;

			case self::MIN_WIDTH:
			case self::MIN_HEIGHT:
			case self::PAGE:
				if ($value < 0 || !preg_match('~^\d+$~', (string) $value)) {
					throw new InvalidSearchParamValue($paramName, $value, "Must be a non-negative integer");
				}
				return (int) $value;

			case self::PER_PAGE:
				if ($value < 3 || $value > 100 || !preg_match('~^\d+$~', (string) $value)) {
					throw new InvalidSearchParamValue(
						$paramName,
						$value,
						"Must be an integer between 3 and 100 (inclusive)"
					);
				}
				return (int) $value;

			default:
				throw new UnsupportedApiSearchParam($paramName);
		}

		// Most values should be parsed to strings
		return (string) $value;
	}

	/**
	 * Make sure the value is contained in the array.
	 *
	 * @param string          $paramName The name of the parameter
	 * @param mixed           $value     The supplied value.
	 * @param string[]|bool[] $supported The list of supported values.
	 *
	 * @throws InvalidSearchParamValue
	 */
	public static function assertParameterValueInArray(string $paramName, $value, array $supported): void {
		if (!in_array($value, $supported, true)) {
			throw new InvalidSearchParamValue($paramName, $value, $supported);
		}
	}
}
