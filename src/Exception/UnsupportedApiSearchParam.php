<?php namespace Intellex\Pixabay\Exception;

use Throwable;

/**
 * Indicates that a supplied parameter name is not recognized in the Pixabay API.
 */
class UnsupportedApiSearchParam extends PixabayException {

	/**
	 * @param string         $paramName The parameter name that is unsupported.
	 * @param Throwable|null $prev      Optional previous error.
	 */
	public function __construct(string $paramName, ?Throwable $prev = null) {
		parent::__construct("Parameter '{$paramName}' is not supported by Pixabay API", 500, $prev);
	}
}
