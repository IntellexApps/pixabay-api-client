<?php namespace Intellex\Pixabay;

use Intellex\Pixabay\Data\PageWithVideos;
use Intellex\Pixabay\Search\SearchParams;
use Intellex\Pixabay\Search\VideoSearchParams;

/**
 * Executes the search on the video API.
 *
 * @extends Api<VideoSearchParams, PageWithVideos>
 */
class VideoApi extends Api {

	/**
	 * Defines a prefix used for creating a final URL.
	 *
	 * @return string The prefix to append to
	 */
	protected function apiPrefix(): string {
		return 'videos/';
	}

	/**
	 * Additionally modify the parameters.
	 *
	 * @param VideoSearchParams $searchParams The current parameters.
	 *
	 * @return VideoSearchParams The modified list of parameters.
	 */
	protected function modifyParams(SearchParams $searchParams): VideoSearchParams {
		return $searchParams;
	}

	/**
	 * Define the data structure that will be populated from the API.
	 *
	 * @return string The class name, without namespace prefix.
	 */
	protected function usedPageClassName(): string {
		return PageWithVideos::class;
	}
}
