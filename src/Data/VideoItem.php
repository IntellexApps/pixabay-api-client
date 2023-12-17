<?php declare(strict_types=1);

namespace Intellex\Pixabay\Data;

/**
 * Represents a single video format, in a specific resolution.
 */
class VideoItem {

	/** @var string A path to the video itself. */
	private string $url;

	/** @var int The width of the video. */
	private int $width;

	/** @var int The height of the video. */
	private int $height;

	/** @var int The size of the video, in bytes. */
	private int $size;

	/**
	 * Initialize the VideoItem from JSON object.
	 *
	 * @param object $json The json to read the data from.
	 */
	public function __construct(object $json) {
		$this->url = $json->url;
		$this->width = $json->width;
		$this->height = $json->height;
		$this->size = $json->size;
	}

	/** @return string A path to the video itself. */
	public function getUrl(): string {
		return $this->url;
	}

	/** @return int The width of the video. */
	public function getWidth(): int {
		return $this->width;
	}

	/** @return int The height of the video. */
	public function getHeight(): int {
		return $this->height;
	}

	/** @return int The size of the video, in bytes. */
	public function getSize(): int {
		return $this->size;
	}
}
