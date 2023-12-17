<?php namespace Intellex\Pixabay\Search;

use Intellex\Pixabay\Exception\UnsupportedLocalSearchParam;

/**
 * Defines the parameters for the image search.
 *
 * @extends SearchParams<self>
 */
class ImageSearchParams extends SearchParams {

	/**
	 * @const string Filter results by image type.
	 * Accepted values: {@see ImageType}.
	 * Default: {@see ImageType::ALL}.
	 */
	private ?string $imageType = null;

	/**
	 * @const string Whether an image is wider than it is tall, or taller than it is wide.
	 * Accepted values: {@see Orientation}.
	 * Default: {@see Orientation::ALL}.
	 */
	private ?string $orientation = null;

	/**
	 * @const string Filter images by color properties, with comma separated list of values.
	 * Accepted values: {@see Color}.
	 */
	private ?string $colors = null;

	/**
	 * @param string|null $imageType Filter results by image type.
	 *                               Accepted values: {@see ImageType}.
	 *                               Default: {@see ImageType::ALL}.
	 *
	 * @return self
	 */
	public function setImageType(?string $imageType): self {
		$this->imageType = $imageType;
		return $this;
	}

	/**
	 * @param string|null $orientation Whether an image is wider than it is tall, or taller than it is wide.
	 *                                 Accepted values: {@see Orientation}.
	 *                                 Default: {@see Orientation::ALL}.
	 *
	 * @return self
	 */
	public function setOrientation(?string $orientation): self {
		$this->orientation = $orientation;
		return $this;
	}

	/**
	 * @param string|null $color The color to filter images by.
	 *                           Accepted values: {@see Color}.
	 *
	 * @return self
	 */
	public function setColor(?string $color): self {
		$this->colors = $color;
		return $this;
	}

	/**
	 * @param string[]|null $colors The list of colors to filter images by.
	 *                              Accepted values: {@see Color}.
	 *
	 * @return self
	 */
	public function setColors(?array $colors): self {
		return $this->setColor($colors !== null ? implode(',', $colors) : null);
	}

	/** @return string|null Filter results by image type. */
	public function getImageType(): ?string {
		return $this->imageType;
	}

	/** @return string|null $orientation Whether an image is wider than it is tall, or taller than it is wide. */
	public function getOrientation(): ?string {
		return $this->orientation;
	}

	/** @return string|null The colors to filter image by. */
	public function getColors(): ?string {
		return $this->colors;
	}

	/** @inheritDoc */
	protected function defineParams(): array {
		return [
			PixabayParam::Q              => $this->getQuery(),
			PixabayParam::LANG           => $this->getLang(),
			PixabayParam::IMAGE_TYPE     => $this->getImageType(),
			PixabayParam::ORIENTATION    => $this->getOrientation(),
			PixabayParam::CATEGORY       => $this->getCategory(),
			PixabayParam::MIN_WIDTH      => $this->getMinWidth(),
			PixabayParam::MIN_HEIGHT     => $this->getMinHeight(),
			PixabayParam::COLORS         => $this->getColors(),
			PixabayParam::EDITORS_CHOICE => $this->getEditorsChoice(),
			PixabayParam::SAFE_SEARCH    => $this->getSafeSearch(),
			PixabayParam::ORDER          => $this->getOrder(),
			PixabayParam::PAGE           => $this->getPage(),
			PixabayParam::PER_PAGE       => $this->getPerPage()
		];
	}

	/** @inheritDoc */
	protected function handleUnknownParam(string $normalizedParamName, string $paramName, $value): void {
		switch ($normalizedParamName) {

			case 'type':
			case 'image':
			case 'imagetype':
				$this->setImageType($value ? (string) $value : null);
				break;

			case 'orientation':
				$this->setOrientation($value ? (string) $value : null);
				break;

			case 'color':
			case 'colors':
				$this->setColors($this->parseColors($this->colors));
				break;

			default:
				throw new UnsupportedLocalSearchParam(self::class, $paramName);
		}
	}

	/**
	 * Parse various colors formatting to an array of colors (as strings).
	 *
	 * @param string|string[]|null $colors The supplied raw colors.
	 *
	 * @return string[]|null The list of parsed colors, or null if there are no colors.
	 */
	private function parseColors($colors): ?array {
		if (empty($colors)) {
			return null;
		}

		if (is_array($colors)) {
			return $colors;
		}

		return explode(',', (string) $colors);
	}
}
