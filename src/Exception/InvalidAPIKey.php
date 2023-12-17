<?php namespace Intellex\Pixabay\Exception;

use Throwable;

/**
 * Indicates that the Pixabay has declined the supplied API key.
 */
class InvalidAPIKey extends PixabayException {

	/**
	 * @param string         $key  The Pixabay API key used.
	 * @param Throwable|null $prev Optional previous error.
	 */
	public function __construct(string $key, ?Throwable $prev = null) {
		parent::__construct("The supplied API key '{$key}' has been declined.", 400, $prev);
	}
}
