<?php namespace Intellex\Pixabay\Search;

use Intellex\Pixabay\Exception\UnsupportedLocalSearchParam;

/**
 * Defines the parameters for the video search.
 *
 * @extends SearchParams<self>
 */
class VideoSearchParams extends SearchParams {

	/**
	 * @const string Filter results by video type.
	 * Accepted values: {@see VideoType}.
	 * Default: {@see VideoType::ALL}.
	 */
	private ?string $videoType = null;

	/**
	 * @param string|null $videoType Filter results by video type.
	 *                               Accepted values: {@see VideoType}.
	 *                               Default: {@see VideoType::ALL}.
	 *
	 * @return self
	 */
	public function setVideoType(?string $videoType): self {
		$this->videoType = $videoType;
		return $this;
	}

	/** @return string|null Filter results by video type. */
	public function getVideoType(): ?string {
		return $this->videoType;
	}

	/** @inheritDoc */
	protected function defineParams(): array {
		return [
			PixabayParam::Q              => $this->getQuery(),
			PixabayParam::LANG           => $this->getLang(),
			PixabayParam::VIDEO_TYPE     => $this->getVideoType(),
			PixabayParam::CATEGORY       => $this->getCategory(),
			PixabayParam::MIN_WIDTH      => $this->getMinWidth(),
			PixabayParam::MIN_HEIGHT     => $this->getMinHeight(),
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
			case 'video':
			case 'videotype':
				$this->setVideoType((string) $value);
				break;

			default:
				throw new UnsupportedLocalSearchParam(self::class, $paramName);
		}
	}
}
