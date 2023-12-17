<?php namespace Intellex\Pixabay;

use Intellex\Pixabay\Data\PageWithImages;
use Intellex\Pixabay\Search\ImageSearchParams;
use Intellex\Pixabay\Search\SearchParams;

/**
 * Executes the search on the image API.
 *
 * @extends Api<ImageSearchParams, PageWithImages>
 */
class ImageApi extends Api {

	/**
	 * Defines a prefix used for creating a final URL.
	 *
	 * @return string The prefix to append to
	 */
	protected function apiPrefix(): string {
		return '';
	}

	/**
	 * Additionally modify the parameters.
	 *
	 * @param ImageSearchParams $searchParams The current parameters.
	 *
	 * @return ImageSearchParams The modified list of parameters.
	 */
	protected function modifyParams(SearchParams $searchParams): ImageSearchParams {
		return $searchParams;
	}

	/**
	 * Define the data structure that will be populated from the API.
	 *
	 * @return string The class name, without namespace prefix.
	 */
	protected function usedPageClassName(): string {
		return PageWithImages::class;
	}
}
