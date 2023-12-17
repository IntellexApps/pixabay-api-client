<?php declare(strict_types=1);

namespace Intellex\Pixabay\Data;

use Intellex\Pixabay\Enum\VideoPreviewSize;
use stdClass;

/**
 * Represents a single video, as returned via the Pixabay API response.
 */
class Video {

	/** @var int A unique identifier for updating expired image URLs. */
	private $id;

	/** @var string The type of the image. */
	private string $type;

	/** @var string[] The list of tags. */
	private array $tags;

	/** @var string Source page on Pixabay, which provides a download link for the original image of the dimension imageWidth x imageHeight and the file size imageSize. */
	private string $pageUrl;

	/** @var int The duration of the video, in seconds. */
	private $duration;

	/** @var string Value used to retrieve static preview images of the video in various sizes. */
	private string $pictureId;

	/** @var VideoItem|null The video in the largest resolution (typically has a dimension of 1920x1080), which is not always available (null it that case). */
	private ?VideoItem $largeVideo;

	/** @var VideoItem The video in medium resolution (typically has a dimension of 1280x720). */
	private VideoItem $mediumVideo;

	/** @var VideoItem The video in small resolution (typically has a dimension of 960x540, or 640x360 for older videos). */
	private VideoItem $smallVideo;

	/** @var VideoItem The video in tiny resolution (typically has a dimension of 640x360, or 480x270 for older videos). */
	private VideoItem $tinyVideo;

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
	 * Initialize the Video from JSON object.
	 *
	 * @param stdClass $json The json to read the data from.
	 */
	public function __construct(stdClass $json) {
		$this->id = $json->id;
		$this->pageUrl = $json->pageURL;
		$this->type = $json->type;
		$this->tags = preg_split('~\s*,\s*~', $json->tags) ?: [];
		$this->duration = $json->duration;
		$this->pictureId = $json->picture_id;
		$this->views = $json->views;
		$this->downloads = $json->downloads;
		$this->likes = $json->likes;
		$this->comments = $json->comments;
		$this->user_id = $json->user_id;
		$this->user = $json->user;
		$this->userImageUrl = $json->userImageURL;

		// Load each video resolution
		$this->largeVideo = property_exists($json->videos, 'large') && !empty($json->videos->large->url)
			? new VideoItem($json->videos->large)
			: null;
		$this->mediumVideo = new VideoItem($json->videos->medium);
		$this->smallVideo = new VideoItem($json->videos->small);
		$this->tinyVideo = new VideoItem($json->videos->tiny);
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

	/** @return int The duration of the video, in seconds. */
	public function getDuration(): int {
		return $this->duration;
	}

	/** @return string Value used to retrieve static preview images of the video in various sizes. */
	public function getPictureId(): string {
		return $this->pictureId;
	}

	/** @return VideoItem|null The video in the largest resolution (typically has a dimension of 1920x1080), which is not always available (null it that case). */
	public function getLargeVideo(): ?VideoItem {
		return $this->largeVideo;
	}

	/** @return VideoItem The video in medium resolution (typically has a dimension of 1280x720). */
	public function getMediumVideo(): VideoItem {
		return $this->mediumVideo;
	}

	/** @return VideoItem The video in small resolution (typically has a dimension of 960x540, or 640x360 for older videos). */
	public function getSmallVideo(): VideoItem {
		return $this->smallVideo;
	}

	/** @return VideoItem The video in tiny resolution (typically has a dimension of 640x360, or 480x270 for older videos). */
	public function getTinyVideo(): VideoItem {
		return $this->tinyVideo;
	}

	/** @return int Total number of views. */
	public function getViewCount(): int {
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

	/** @return string The URL to the requested preview in full HD (1920x1080). */
	public function getPreviewImageFullHd(): string {
		return $this->getPreviewImage(VideoPreviewSize::_1920_1080);
	}

	/** @return string The URL to the requested preview in 960x540. */
	public function getPreviewImage960x540(): string {
		return $this->getPreviewImage(VideoPreviewSize::_960_540);
	}

	/** @return string The URL to the requested preview in 640x360. */
	public function getPreviewImage640x360(): string {
		return $this->getPreviewImage(VideoPreviewSize::_640_360);
	}

	/** @return string The URL to the requested preview in 295x166. */
	public function getPreviewImage295x166(): string {
		return $this->getPreviewImage(VideoPreviewSize::_295_166);
	}

	/** @return string The URL to the requested preview in 200x150. */
	public function getPreviewImage200x150(): string {
		return $this->getPreviewImage(VideoPreviewSize::_200_150);
	}

	/** @return string The URL to the requested preview in 100x75. */
	public function getPreviewImage100x75(): string {
		return $this->getPreviewImage(VideoPreviewSize::_100_75);
	}

	/**
	 * Get the URL for the video preview image.
	 *
	 * @param string $size The size for the preview, @see VideoPreviewSize.
	 *
	 * @return string The URL to the requested preview.
	 */
	private function getPreviewImage(string $size): string {
		return sprintf('https://i.vimeocdn.com/video/%s_%s.jpg', $this->pictureId, $size);
	}
}
