<?php namespace Intellex\Pixabay\Exception;

use Throwable;

/**
 * Indicates that a supplied value is not applicable to a parameter.
 */
class InvalidSearchParamValue extends PixabayException {

	/**
	 * @param string                      $paramName The name of the parameter.
	 * @param mixed                       $value     The supplied value that is invalid.
	 * @param string|string[]|bool[]|null $message   The additional message to provide.
	 * @param Throwable|null              $prev      Optional previous error.
	 */
	public function __construct(string $paramName, $value, $message, ?Throwable $prev = null) {

		// If an array is supplied for the message, show as the list of supported values
		if (is_array($message)) {
			$message = "Supported values are: " . implode(', ', $message);
		}

		// Compile the final error message
		$error = "Invalid value set for parameter {$paramName}: $value.";
		if (!empty($message)) {
			$error .= " {$message}.";
		}

		parent::__construct($error, 500, $prev);
	}
}
