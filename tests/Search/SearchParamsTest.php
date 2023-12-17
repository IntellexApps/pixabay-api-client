<?php declare(strict_types = 1);

namespace Intellex\Pixabay\Tests\Search;

use Generator;
use Intellex\Pixabay\Search\SearchParams;
use PHPUnit\Framework\TestCase;

/** @see SearchParams */
class SearchParamsTest extends TestCase {

	/** @dataProvider provideAsString */
	public function testAsString($value, ?string $expected): void {
		$this->assertEquals($expected, SearchParams::asString($value));
	}

	/** @see testAsString */
	public function provideAsString(): Generator {
		yield [ null, null ];
		yield [ '', '' ];
		yield [ ' ', ' ' ];

		yield [ '0', '0' ];
		yield [ 'string', 'string' ];

		yield [ 100, '100' ];
		yield [ 15.99, '15.99' ];
		yield [ false, '' ];
		yield [ true, '1' ];
	}

	/** @dataProvider provideAsInt */
	public function testAsInt($value, ?int $expected): void {
		$this->assertEquals($expected, SearchParams::asInt($value));
	}

	/** @see testAsInt */
	public function provideAsInt(): Generator {
		yield [ null, null ];
		yield [ '', 0 ];
		yield [ ' ', 0 ];

		yield [ '0', 0 ];
		yield [ 'string', 0 ];

		yield [ 100, 100 ];
		yield [ 15.99, 15 ];
		yield [ false, 0 ];
		yield [ true, 1 ];
	}

	/** @dataProvider provideAsBoolean */
	public function testAsBoolean($value, ?bool $expected): void {
		$this->assertEquals($expected, SearchParams::asBoolean($value));
	}

	/** @see testAsBoolean */
	public function provideAsBoolean(): Generator {
		yield [ null, null ];
		yield [ '', false ];
		yield [ ' ', false ];

		yield [ '0', false ];
		yield [ 'string', true ];

		yield [ 100, true ];
		yield [ 15.99, true ];
		yield [ false, false ];
		yield [ true, true ];
	}

	/** @dataProvider provideNormalizeParamName */
	public function testNormalizeParamName(string $value, string $expected): void {
		$this->assertEquals($expected, SearchParams::normalizeParamName($value));
	}

	/** @see testNormalizeParamName */
	public function provideNormalizeParamName(): Generator {
		yield [ 'q', 'q' ];
		yield [ 'Q', 'q' ];
		yield [ 'QUERY', 'query' ];
		yield [ 'My Name', 'myname' ];
		yield [ 'per-page', 'perpage' ];
		yield [ 'More  than _-ENOUGH', 'morethanenough' ];
	}
}
