<?php declare(strict_types = 1);

namespace Intellex\Pixabay\Tests\Search;

use Generator;
use Intellex\Pixabay\Enum\Category;
use Intellex\Pixabay\Enum\Color;
use Intellex\Pixabay\Enum\ImageType;
use Intellex\Pixabay\Enum\Language;
use Intellex\Pixabay\Enum\Order;
use Intellex\Pixabay\Enum\Orientation;
use Intellex\Pixabay\Enum\VideoType;
use Intellex\Pixabay\Exception\InvalidSearchParamValue;
use Intellex\Pixabay\Exception\UnsupportedApiSearchParam;
use Intellex\Pixabay\Search\PixabayParam;
use PHPUnit\Framework\TestCase;

/** @see PixabayParam */
class PixabayParamTest extends TestCase {

	/** @dataProvider provideAssertParameterValue */
	public function testAssertParameterValue(string $paramName, $value, $parsedValue = null): void {
		$this->assertSame(
			$parsedValue ?? $value,
			PixabayParam::assertParameterValue($paramName, $value)
		);
	}

	/** @see testAssertParameterValue */
	public function provideAssertParameterValue(): Generator {
		yield [ PixabayParam::Q, '' ];
		yield [ PixabayParam::Q, '1' ];
		yield [ PixabayParam::Q, 'sunrise' ];
		yield [ PixabayParam::Q, 'midnight sky' ];
		yield [ PixabayParam::Q, str_repeat('1234567890', 10) ];

		yield [ PixabayParam::LANG, 'en' ];
		yield [ PixabayParam::LANG, Language::FI ];
		yield [ PixabayParam::LANG, Language::PL ];

		yield [ PixabayParam::IMAGE_TYPE, ImageType::ALL ];
		yield [ PixabayParam::IMAGE_TYPE, ImageType::VECTOR ];

		yield [ PixabayParam::VIDEO_TYPE, VideoType::ALL ];
		yield [ PixabayParam::VIDEO_TYPE, VideoType::ANIMATION ];

		yield [ PixabayParam::ORIENTATION, Orientation::ALL ];
		yield [ PixabayParam::ORIENTATION, Orientation::VERTICAL ];
		yield [ PixabayParam::ORIENTATION, Orientation::HORIZONTAL ];

		yield [ PixabayParam::CATEGORY, Category::FOOD ];
		yield [ PixabayParam::CATEGORY, Category::FEELINGS ];
		yield [ PixabayParam::CATEGORY, Category::TRANSPORTATION ];

		yield [ PixabayParam::COLORS, Color::ORANGE ];
		yield [ PixabayParam::COLORS, 'blue,green' ];

		yield [ PixabayParam::ORDER, Order::LATEST ];
		yield [ PixabayParam::ORDER, Order::POPULAR ];

		yield [ PixabayParam::EDITORS_CHOICE, true ];
		yield [ PixabayParam::SAFE_SEARCH, false ];

		yield [ PixabayParam::MIN_WIDTH, 0 ];
		yield [ PixabayParam::MIN_WIDTH, '10', 10 ];
		yield [ PixabayParam::MIN_WIDTH, 320 ];
		yield [ PixabayParam::MIN_WIDTH, '1080', 1080 ];

		yield [ PixabayParam::MIN_HEIGHT, 1 ];
		yield [ PixabayParam::MIN_HEIGHT, '10', 10 ];
		yield [ PixabayParam::MIN_HEIGHT, '320', 320 ];
		yield [ PixabayParam::MIN_HEIGHT, 1080 ];

		yield [ PixabayParam::PAGE, 1 ];
		yield [ PixabayParam::PAGE, '1', 1 ];
		yield [ PixabayParam::PAGE, 100 ];

		yield [ PixabayParam::PER_PAGE, 3 ];
		yield [ PixabayParam::PER_PAGE, '4', 4 ];
		yield [ PixabayParam::PER_PAGE, '100', 100 ];
	}

	/** @dataProvider provideAssertParameterValueException */
	public function testAssertParameterValueException(string $paramName, $value): void {
		$this->expectException(InvalidSearchParamValue::class);
		PixabayParam::assertParameterValue($paramName, $value);
	}

	/** @see testAssertParameterValueException */
	public function provideAssertParameterValueException(): Generator {
		yield [ PixabayParam::Q, str_repeat('1234567890', 10) . '.' ];

		yield [ PixabayParam::LANG, '' ];
		yield [ PixabayParam::LANG, 'sr' ];
		yield [ PixabayParam::LANG, 'english' ];

		yield [ PixabayParam::IMAGE_TYPE, '' ];
		yield [ PixabayParam::IMAGE_TYPE, 'bmp' ];
		yield [ PixabayParam::IMAGE_TYPE, 'photo,vector' ];

		yield [ PixabayParam::VIDEO_TYPE, '' ];
		yield [ PixabayParam::VIDEO_TYPE, 'mkv' ];
		yield [ PixabayParam::VIDEO_TYPE, 'anim' ];
		yield [ PixabayParam::VIDEO_TYPE, 'film,animation' ];

		yield [ PixabayParam::ORIENTATION, '' ];
		yield [ PixabayParam::ORIENTATION, 'original' ];
		yield [ PixabayParam::ORIENTATION, 'horizontal,vertical' ];

		yield [ PixabayParam::CATEGORY, '' ];
		yield [ PixabayParam::CATEGORY, 'c1' ];
		yield [ PixabayParam::CATEGORY, 'food,sports' ];

		yield [ PixabayParam::COLORS, '' ];
		yield [ PixabayParam::COLORS, 'none' ];
		yield [ PixabayParam::COLORS, 'true,false' ];
		yield [ PixabayParam::COLORS, 'red,blue,yes' ];

		yield [ PixabayParam::ORDER, '' ];
		yield [ PixabayParam::ORDER, 'asc' ];
		yield [ PixabayParam::ORDER, 'desc' ];
		yield [ PixabayParam::ORDER, 'popular,latest' ];

		yield [ PixabayParam::EDITORS_CHOICE, '' ];
		yield [ PixabayParam::EDITORS_CHOICE, 'yes' ];
		yield [ PixabayParam::SAFE_SEARCH, '' ];
		yield [ PixabayParam::SAFE_SEARCH, 'no' ];

		yield [ PixabayParam::MIN_WIDTH, '' ];
		yield [ PixabayParam::MIN_WIDTH, '-1' ];
		yield [ PixabayParam::MIN_WIDTH, '1.5' ];
		yield [ PixabayParam::MIN_WIDTH, 'min' ];
		yield [ PixabayParam::MIN_HEIGHT, '' ];
		yield [ PixabayParam::MIN_WIDTH, 9.99 ];
		yield [ PixabayParam::MIN_HEIGHT, '-17' ];
		yield [ PixabayParam::MIN_HEIGHT, 'max' ];
		yield [ PixabayParam::PAGE, '' ];
		yield [ PixabayParam::PAGE, 12.1 ];
		yield [ PixabayParam::PAGE, -99 ];
		yield [ PixabayParam::PAGE, 'all' ];

		yield [ PixabayParam::PER_PAGE, '' ];
		yield [ PixabayParam::PER_PAGE, 00 ];
		yield [ PixabayParam::PER_PAGE, '1' ];
		yield [ PixabayParam::PER_PAGE, '2' ];
		yield [ PixabayParam::PER_PAGE, '-3' ];
		yield [ PixabayParam::PER_PAGE, '101' ];
		yield [ PixabayParam::PER_PAGE, 'all' ];
	}

	/** @dataProvider provideAssertParameterValueUnsupportedException */
	public function testAssertParameterValueUnsupportedException(string $paramName, $value): void {
		$this->expectException(UnsupportedApiSearchParam::class);
		PixabayParam::assertParameterValue($paramName, $value);
	}

	/** @see testAssertParameterValueUnsupportedException */
	public function provideAssertParameterValueUnsupportedException(): Generator {
		yield [ '', '' ];
		yield [ ' ', ' ' ];
		yield [ '*', '?' ];
		yield [ 'type', 'unknown' ];
		yield [ 'query', 'sunflower' ];
		yield [ 'language', 'serbian' ];
	}

	/** @dataProvider provideAssertParameterValueInArrayException */
	public function testAssertParameterValueInArrayException($value, array $supported): void {
		$this->expectException(InvalidSearchParamValue::class);
		PixabayParam::assertParameterValueInArray('', $value, $supported);
	}

	/** @see testAssertParameterValueInArrayException */
	public function provideAssertParameterValueInArrayException(): Generator {
		yield [ true, [ 0 ] ];
		yield [ true, [ false ] ];
		yield [ true, [ 'true' ] ];

		yield [ 0, [ 1, 2, 3 ] ];
		yield [ 0, [ '0', '1', '2', '3' ] ];
		yield [ '0', [ 0, 1, 2, 3, 4, 5, 6 ] ];

		yield [ 'John', [ 'john', 'JOHN', 'Jane' ] ];
		yield [ 'Mr. Bean', [ 'Bean', 'Dr. Bean', 'Ms. Bean' ] ];
	}
}
