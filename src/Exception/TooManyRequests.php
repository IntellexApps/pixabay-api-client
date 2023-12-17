<?php namespace Intellex\Pixabay\Exception;

/**
 * Indicates that Pixabay has declined the request as the client made too many requests (HTTP error 429).
 *
 * @see https://pixabay.com/api/docs/#api_rate_limit.
 */
class TooManyRequests extends PixabayException {
}
