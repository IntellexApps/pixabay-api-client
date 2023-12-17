<?php namespace Intellex\Pixabay\Exception;

use Intellex\Pixabay\Search\SearchParams;
use Throwable;

/**
 * Indicates that a supplied parameter name is not recognized on the local level.
 */
class UnsupportedLocalSearchParam extends PixabayException {

	/**
	 * @param class-string<SearchParams> $className The class that raised this exception.
	 * @param string                     $paramName The original parameter name that is unsupported.
	 * @param Throwable|null             $prev      Optional previous error.
	 */
	public function __construct(string $className, string $paramName, ?Throwable $prev = null) {
		parent::__construct("Class {$className} does not support parameter: '{$paramName}'", 500, $prev);
	}
}
