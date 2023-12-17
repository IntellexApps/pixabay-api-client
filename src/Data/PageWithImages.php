<?php declare(strict_types = 1);

namespace Intellex\Pixabay\Data;

/**
 * Shows a page with images.
 *
 * @extends Page<Image>
 */
class PageWithImages extends Page {

	/** @return Image[] The list of found images. */
	public function getImages(): array {
		return $this->getHits();
	}

	/** @inheritdoc */
	public function getItemClass(): string {
		return Image::class;
	}
}
