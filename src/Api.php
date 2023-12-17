<?php namespace Intellex\Pixabay;

use Intellex\Pixabay\Data\Page;
use Intellex\Pixabay\Exception\InvalidAPIKey;
use Intellex\Pixabay\Exception\InvalidSearchParamValue;
use Intellex\Pixabay\Exception\PixabayException;
use Intellex\Pixabay\Exception\TooManyRequests;
use Intellex\Pixabay\Exception\UnsupportedApiSearchParam;
use Intellex\Pixabay\Search\SearchParams;
use JsonException;

/**
 * Base for all Pixabay API calls.
 *
 * @template SP of SearchParams
 * @template P of Page
 */
abstract class Api {

	/** @const string The Pixabay endpoint which is targeted. */
	private const ENDPOINT = 'https://pixabay.com/api/';

	/** @var string The API key used to identify on Pixabay. */
	private string $apiKey;

	/**
	 * Initialize the search.
	 *
	 * @param string $apiKey The API key used to authenticate on Pixabay.
	 */
	public function __construct(string $apiKey) {
		$this->apiKey = $apiKey;
	}

	/**
	 * Fetch from the API.
	 *
	 * @param SP $searchParams The parameters to use for the search.
	 *
	 * @return P The full response from the server.
	 * @throws TooManyRequests
	 * @throws InvalidAPIKey
	 * @throws JsonException
	 * @throws PixabayException
	 */
	public function fetch(SearchParams $searchParams): Page {

		// Set the url
		$url = self::ENDPOINT . $this->apiPrefix();

		// Execute
		$searchParams = $this->modifyParams($searchParams);
		[ $httpResponseCode, $headers, $body ] = $this->execute($url, $searchParams);

		// Extract headers
		$parsedHeaders = [];
		foreach ($headers as $header) {
			if (strpos($header, ':') !== false) {

				// Extract the name and the value of the header
				[ $name, $value ] = explode(':', $header);

				// Normalize the header name, ie: Content-Type
				$name = str_replace(' ', '-', ucwords(strtolower(str_replace('-', ' ', trim($name)))));

				$parsedHeaders[$name] = trim($value);
			}
		}

		// Check the response code
		switch ($httpResponseCode) {
			case 200:
			case 201:
				break;
			case 429:
				throw new TooManyRequests();
			default:
				throw strpos($body, 'API key') !== false
					? new InvalidAPIKey($this->apiKey)
					: new PixabayException($body);
		}

		// Return response
		$className = $this->usedPageClassName();
		return new $className(json_decode($body, false, 512, JSON_THROW_ON_ERROR), $parsedHeaders);
	}

	/**
	 * Execute a CURL request on a specified URL.
	 *
	 * @param string $url          The url to read from.
	 * @param SP     $searchParams The GET parameters for the request.
	 *
	 * @return array{int, array<string, string>, string} First element containing the HTTP response code, second the
	 *                                                   headers and third the body of the response.
	 *
	 * @throws PixabayException
	 * @throws InvalidSearchParamValue
	 * @throws UnsupportedApiSearchParam
	 */
	private function execute(string $url, SearchParams $searchParams): array {

		// Extract the parameters
		$requestBody = $searchParams->jsonSerialize();
		foreach ($requestBody as $key => $value) {
			if (is_bool($value)) {
				$requestBody[$key] = $value ? 'true' : 'false';
			}
		}

		// Set the options
		$requestBody['key'] = $this->apiKey;
		$options = [
			CURLOPT_HEADER         => 1,
			CURLOPT_URL            => $url . '?' . http_build_query($requestBody),
			CURLOPT_FRESH_CONNECT  => 1,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_FORBID_REUSE   => 1
		];

		// Initialize
		$curl = curl_init();
		curl_setopt_array($curl, $options);

		// Execute request
		$response = (string) curl_exec($curl);
		if (curl_errno($curl) > 0) {
			throw new PixabayException(sprintf(
				'Curl error #%d: %s.',
				curl_errno($curl),
				curl_error($curl)
			));
		}

		// Separate headers and body from the response
		[ $headerBlock, $body ] = (array) preg_split('~\r?\n\r?\n~', $response, 2);
		$httpResponseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);

		// Split headers
		$headers = [];
		foreach ((array) preg_split("~\r?\n~", (string) $headerBlock) as $i => $header) {

			// Skip the first headers containing the HTTP response code
			if ($i) {
				[ $key, $value ] = explode(':', (string) $header);
				$headers[trim($key)] = trim($value);
			}
		}

		return [ $httpResponseCode, $headers, (string) $body ];
	}

	/**
	 * Defines a prefix used for creating a final URL.
	 *
	 * @return string The prefix to append to the endpoint.
	 */
	abstract protected function apiPrefix(): string;

	/**
	 * Additionally modify the parameters.
	 * This allows easy further class extensions, ie. NatureCategoryImageApi.
	 *
	 * @param SP $searchParams The current parameters.
	 *
	 * @return SP The modified list of parameters.
	 */
	abstract protected function modifyParams(SearchParams $searchParams): SearchParams;

	/**
	 * Define the data structure that will be populated from the API.
	 *
	 * @return class-string<P> The class name.
	 */
	abstract protected function usedPageClassName(): string;
}
