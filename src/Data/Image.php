<?php declare(strict_types = 1);

namespace Intellex\Pixabay\Data;

use stdClass;

/**
 * Represents a single image, as returned via the Pixabay API response.
 */
class Image {

	/** @var int A unique identifier for updating expired image URLs. */
	private int $id;

	/** @var string The type of the image. */
	private string $type;

	/** @var string[] The list of tags. */
	private array $tags;

	/** @var string Source page on Pixabay, which provides a download link for the original image of the dimension imageWidth x imageHeight and the file size imageSize. */
	private string $pageUrl;

	/** @var string Scaled image with a maximum width/height of 1280px. */
	private string $largeImageUrl;

	/** @var string Low resolution images with a maximum width or height of 150 px (previewWidth x previewHeight). */
	private string $previewUrl;

	/** @var int The width of the low resolution image. */
	private int $previewWidth;

	/** @var int The height of the low resolution image. */
	private int $previewHeight;

	/** @var string Medium-sized image with a maximum width or height of 640 px (webformatWidth x webformatHeight). URL valid for 24 hours. */
	private string $webformatUrl;

	/** @var int The width of the web image. */
	private int $webformatWidth;

	/** @var int The height of the web image. */
	private int $webformatHeight;

	/** @var int Total number of views. */
	private int $views;

	/** @var int Total number of downloads. */
	private int $downloads;

	/** @var int Total number of likes. */
	private int $likes;

	/** @var int Total number of comments. */
	private int $comments;

	/** @var int User ID of the contributor. */
	private int $user_id;

	/** @var string Name of the contributor. */
	private string $user;

	/** @var string Profile picture URL (250 x 250 px). */
	private string $userImageUrl;

	/**
	 * Initialize the Image from JSON object.
	 *
	 * @param stdClass $json The json to read the data from.
	 */
	public function __construct(stdClass $json) {
		$this->id = $json->id;
		$this->pageUrl = $json->pageURL;
		$this->type = $json->type;
		$this->tags = preg_split('~\s*,\s*~', $json->tags) ?: [];
		$this->largeImageUrl = $json->largeImageURL;
		$this->previewUrl = $json->previewURL;
		$this->previewWidth = $json->previewWidth;
		$this->previewHeight = $json->previewHeight;
		$this->webformatUrl = $json->webformatURL;
		$this->webformatWidth = $json->webformatWidth;
		$this->webformatHeight = $json->webformatHeight;
		$this->views = $json->views;
		$this->downloads = $json->downloads;
		$this->likes = $json->likes;
		$this->comments = $json->comments;
		$this->user_id = $json->user_id;
		$this->user = $json->user;
		$this->userImageUrl = $json->userImageURL;
	}

	/** @return int A unique identifier for updating expired image URLs. */
	public function getId(): int {
		return $this->id;
	}

	/** @return string The type of the image. */
	public function getType(): string {
		return $this->type;
	}

	/** @return string[] The list of tags. */
	public function getTags(): array {
		return $this->tags;
	}

	/** @return string Source page on Pixabay, which provides a download link for the original image of the dimension imageWidth x imageHeight and the file size imageSize. */
	public function getPageUrl(): string {
		return $this->pageUrl;
	}

	/** @return string Scaled image with a maximum width/height of 1280px. */
	public function getLargeImageUrl(): string {
		return $this->largeImageUrl;
	}

	/** @return string Low resolution images with a maximum width or height of 150 px (previewWidth x previewHeight). */
	public function getPreviewUrl(): string {
		return $this->previewUrl;
	}

	/** @return int The width of the low resolution image. */
	public function getPreviewWidth(): int {
		return $this->previewWidth;
	}

	/** @return int The height of the low resolution image. */
	public function getPreviewHeight(): int {
		return $this->previewHeight;
	}

	/** @return string Medium-sized image with a maximum width or height of 640 px (webformatWidth x webformatHeight). URL valid for 24 hours. */
	public function getWebformatUrl(): string {
		return $this->webformatUrl;
	}

	/** @return int The width of the web image. */
	public function getWebformatWidth(): int {
		return $this->webformatWidth;
	}

	/** @return int The height of the web image. */
	public function getWebformatHeight(): int {
		return $this->webformatHeight;
	}

	/** @return int Total number of views. */
	public function getViewsCount(): int {
		return $this->views;
	}

	/** @return int Total number of downloads. */
	public function getDownloadCount(): int {
		return $this->downloads;
	}

	/** @return int Total number of likes. */
	public function getLikeCount(): int {
		return $this->likes;
	}

	/** @return int Total number of comments. */
	public function getCommentCount(): int {
		return $this->comments;
	}

	/** @return int User ID of the contributor. */
	public function getUserId(): int {
		return $this->user_id;
	}

	/** @return string Name of the contributor. */
	public function getUserName(): string {
		return $this->user;
	}

	/** @return string Profile picture URL (250 x 250 px). */
	public function getUserImageUrl(): string {
		return $this->userImageUrl;
	}

	/** @return string The URL to the requested size. */
	public function getUrlForSize180(): string {
		return $this->getUrlForSize(180);
	}

	/**  @return string The URL to the requested size. */
	public function getUrlForSize340(): string {
		return $this->getUrlForSize(340);
	}

	/** @return string The URL to the requested size. */
	public function getUrlForSize640(): string {
		return $this->getUrlForSize(640);
	}

	/** @return string The URL to the requested size. */
	public function getUrlForSize960(): string {
		return $this->getUrlForSize(960);
	}

	/**
	 * Get the URL for the image with the maximum width or height limited to $size.
	 *
	 * @param int $size Maximum width or height of the image.
	 *
	 * @return string The URL to the requested size.
	 */
	private function getUrlForSize(int $size): string {
		return (string) preg_replace('~_640(\.\w+)$~', "_{$size}\$1", $this->webformatUrl);
	}
}
