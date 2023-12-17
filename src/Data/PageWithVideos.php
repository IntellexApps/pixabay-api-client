<?php declare(strict_types=1);

namespace Intellex\Pixabay\Data;

/**
 * Shows a page with videos.
 *
 * @extends Page<Video>
 */
class PageWithVideos extends Page {

	/** @return Video[] The list of found videos. */
	public function getVideos(): array {
		return $this->getHits();
	}

	/** @inheritdoc */
	public function getItemClass(): string {
		return Video::class;
	}
}
