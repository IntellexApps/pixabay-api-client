<?php declare(strict_types=1);

namespace Intellex\Pixabay\Data;

use stdClass;

/**
 * Represents a single page, as returned via the Pixabay API response.
 *
 * @template T
 */
abstract class Page {

	/** @var string[] Additional headers in the response from the pixabay. */
	private array $headers;

	/** @var int The total number of hits. */
	private int $total;

	/** @var int The number of images accessible through the API. */
	private int $totalHits;

	/** @var T[] The array of all hits. */
	private array $hits;

	/**
	 * Initialize the Page from JSON object.
	 *
	 * @param stdClass $json    The json to read the data from.
	 * @param string[] $headers Additional headers in the response from the Pixabay.
	 */
	public function __construct(stdClass $json, array $headers) {

		// Count
		$this->total = (int) $json->total;
		$this->totalHits = (int) $json->totalHits;

		// Set hits
		$className = $this->getItemClass();
		foreach ($json->hits as $hit) {
			$this->hits[] = new $className($hit);
		}

		// Load headers
		$this->headers = $headers;
	}

	/** @return string[] Additional headers in the response from the pixabay. */
	public function getHeaders(): array {
		return $this->headers;
	}

	/** @return int The total number of hits. */
	public function getTotal(): int {
		return $this->total;
	}

	/** @return int The number of images accessible through the API. */
	public function getTotalHits(): int {
		return $this->totalHits;
	}

	/** @return T[] The array of all hits. */
	protected function getHits(): array {
		return $this->hits;
	}

	/**
	 * Define the class name that will be used for the hits.
	 *
	 * @return class-string<T> The name fof the class used, without the namespace prefix.
	 */
	abstract public function getItemClass(): string;
}
