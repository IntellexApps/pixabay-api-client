<?php declare(strict_types = 1);

namespace Intellex\Pixabay\Search;

use Intellex\Pixabay\Exception\InvalidSearchParamValue;
use Intellex\Pixabay\Exception\UnsupportedApiSearchParam;
use Intellex\Pixabay\Exception\UnsupportedLocalSearchParam;
use JsonSerializable;

/**
 * Base class for all search parameters.
 *
 * @template SP of SearchParams
 */
abstract class SearchParams implements JsonSerializable {

	/**
	 * @property string|null $q General search term.
	 * If omitted, all images are returned. This value may not exceed 100 characters.
	 */
	private ?string $query = null;

	/**
	 * @property string|null $lang Language code of the language to be searched in.
	 * Accepted values: {@see Language}.
	 * Default: {@see Language::EN}.
	 */
	private ?string $lang = null;

	/**
	 * @property string|null $category Filter results by category.
	 * Accepted values: {@see Category}.
	 */
	private ?string $category = null;

	/**
	 * @property int|null $minWidth Minimum image or video width.
	 * Default: 0.
	 */
	private ?int $minWidth = null;

	/**
	 * @property int|null $minHeight Minimum image or video height.
	 * Default: 0.
	 */
	private ?int $minHeight = null;

	/**
	 * @property bool|null $editorsChoice Select only images that have received an Editor's Choice award.
	 * Accepted values: true or false.
	 * Default: false.
	 */
	private ?bool $editorsChoice = null;

	/**
	 * @property bool|null $safeSearch A flag indicating that only images suitable for all ages should be returned.
	 * Accepted values: true or false.
	 * Default: false.
	 */
	private ?bool $safeSearch = null;

	/**
	 * @property string|null $order How the results should be ordered.
	 * Accepted values: {@see Order}.
	 * Default: {@see Order::POPULAR}.
	 */
	private ?string $order = null;

	/**
	 * @property int|null $page Returned search results are paginated. Use this parameter to select the page number.
	 * Default: 1.
	 */
	private ?int $page = null;

	/**
	 * @property int|null $perPage Determine the number of results per page.
	 * Accepted values: 3 - 200.
	 * Default: 20.
	 */
	private ?int $perPage = null;

	/**
	 * Initialize the ImageSearchParams.
	 *
	 * @param array<string, mixed> $params An optional list of parameters as array, check https://pixabay.com/api/docs/.
	 *
	 * @throws UnsupportedLocalSearchParam
	 *
	 * @phpcs:disable Generic.Metrics.CyclomaticComplexity
	 */
	public function __construct(array $params = []) {
		foreach ($params as $name => $value) {
			$normalizedName = static::normalizeParamName($name);
			switch ($normalizedName) {
				case 'q':
				case 'query':
					$this->setQuery(self::asString($value));
					break;

				case 'category':
					$this->setCategory(self::asString($value));
					break;

				case 'lang':
				case 'language':
					$this->setLang(self::asString($value));
					break;

				case 'width':
				case 'minwidth':
					$this->setMinWidth(self::asInt($value));
					break;

				case 'height':
				case 'minheight':
					$this->setMinHeight(self::asInt($value));
					break;

				case 'editorschoice':
					$this->setEditorsChoice(self::asBoolean($value));
					break;

				case 'safe':
				case 'safesearch':
					$this->setSafeSearch(self::asBoolean($value));
					break;

				case 'order':
					$this->setOrder(self::asString($value));
					break;

				case 'page':
					$this->setPage(self::asInt($value));
					break;

				case 'limit':
				case 'perpage':
					$this->setPerPage(self::asInt($value));
					break;

				default:
					$this->handleUnknownParam($normalizedName, $name, $value);
			}
		}
	}

	/**
	 * @param string|null $query General search term.
	 *                           If omitted, all images are returned. This value may not exceed 100 characters.
	 *                           Example: "yellow+flower".
	 *
	 * @return SP
	 */
	public function setQuery(?string $query): self {
		$this->query = $query;
		return $this;
	}

	/**
	 * @param string|null $languageCode Language code of the language to be searched in.
	 *                                  Accepted values: {@see Language}.
	 *                                  Default: {@see Language::EN}.
	 *
	 * @return SP
	 */
	public function setLang(?string $languageCode): self {
		$this->lang = $languageCode;
		return $this;
	}

	/**
	 * @param string|null $category Filter results by category.
	 *                              Accepted values: {@see Category}.
	 *
	 * @return SP
	 */
	public function setCategory(?string $category): self {
		$this->category = $category;
		return $this;
	}

	/**
	 * @param int|null $minWidth Minimum image or video width.
	 *                           Default: 0.
	 *
	 * @return SP
	 */
	public function setMinWidth(?int $minWidth): self {
		$this->minWidth = $minWidth;
		return $this;
	}

	/**
	 * @param int|null $minHeight Minimum image or video height.
	 *                            Default: 0.
	 *
	 * @return SP
	 */
	public function setMinHeight(?int $minHeight): self {
		$this->minHeight = $minHeight;
		return $this;
	}

	/**
	 * @param bool|null $editorsChoice Select only images that have received an Editor's Choice award.
	 *                                 Accepted values: true or false.
	 *                                 Default: false.
	 *
	 * @return SP
	 */
	public function setEditorsChoice(?bool $editorsChoice): self {
		$this->editorsChoice = $editorsChoice;
		return $this;
	}

	/**
	 * @param bool|null $safeSearch A flag indicating that only images suitable for all ages should be returned.
	 *                              Accepted values: true or false.
	 *                              Default: false.
	 *
	 * @return SP
	 */
	public function setSafeSearch(?bool $safeSearch): self {
		$this->safeSearch = $safeSearch;
		return $this;
	}

	/**
	 * @param string|null $order How the results should be ordered.
	 *                           Accepted values: {@see Order}.
	 *                           Default: {@see Order::POPULAR}.
	 *
	 * @return SP
	 */
	public function setOrder(?string $order): self {
		$this->order = $order;
		return $this;
	}

	/**
	 * @param int|null $page Returned search results are paginated. Use this parameter to select the page number.
	 *                       Default: 1.
	 *
	 * @return SP
	 */
	public function setPage(?int $page): self {
		$this->page = $page;
		return $this;
	}

	/**
	 * @param int|null $perPage Determine the number of results per page.
	 *                          Accepted values: 3 - 200.
	 *                          Default: 20.
	 *
	 * @return static
	 */
	public function setPerPage(?int $perPage): self {
		$this->perPage = $perPage;
		return $this;
	}

	/** @return string|null General search term. */
	public function getQuery(): ?string {
		return $this->query;
	}

	/** @return string|null Language code of the language to be searched in. */
	public function getLang(): ?string {
		return $this->lang;
	}

	/** @return string|null Filter results by category. */
	public function getCategory(): ?string {
		return $this->category;
	}

	/** @return int|null Minimum image or video width. */
	public function getMinWidth(): ?int {
		return $this->minWidth;
	}

	/** @return int|null Minimum image or video height. */
	public function getMinHeight(): ?int {
		return $this->minHeight;
	}

	/** @return bool|null Select only images that have received an Editor's Choice award. */
	public function getEditorsChoice(): ?bool {
		return $this->editorsChoice;
	}

	/** @return bool|null A flag indicating that only images suitable for all ages should be returned. */
	public function getSafeSearch(): ?bool {
		return $this->safeSearch;
	}

	/** @return string|null How the results should be ordered. */
	public function getOrder(): ?string {
		return $this->order;
	}

	/** @return int|null Returned search results are paginated. Use this parameter to select the page number. */
	public function getPage(): ?int {
		return $this->page;
	}

	/** @return int|null Determine the number of results per page. */
	public function getPerPage(): ?int {
		return $this->perPage;
	}

	/**
	 * Convert a value into a string.
	 *
	 * @param mixed $value The value to convert to string.
	 *
	 * @return string|null The extracted string from the original value.
	 */
	public static function asString($value): ?string {
		return $value !== null
			? (string) $value
			: null;
	}

	/**
	 * Convert a value into an integer.
	 *
	 * @param mixed $value The value to convert to integer.
	 *
	 * @return int|null The extracted string from the original value.
	 */
	public static function asInt($value): ?int {
		return $value !== null
			? (int) $value
			: null;
	}

	/**
	 * Convert a value into a boolean.
	 *
	 * @param mixed $value The value to convert to boolean.
	 *
	 * @return bool True if the supplied value can be treated as a 'true' value for boolean.
	 */
	public static function asBoolean($value): bool {
		if (is_bool($value)) {
			return $value;
		}

		// Treat some non-empty values as false
		$falseValues = [ '', '0', 'n', 'no', 'off', 'false' ];
		return !in_array(strtolower(trim((string) $value)), $falseValues, true) && !empty($value);
	}

	/**
	 * Make sure the input parameters are normalized in a consistent format.
	 *
	 * @param string $param The original name of the parameter.
	 *
	 * @return string The unified parameter name.
	 */
	public static function normalizeParamName(string $param): string {
		$param = (string) preg_replace('~(.)([A_Z])~', '$1 $2', $param);
		$param = (string) preg_replace('~[ _-]+~', '', $param);
		return strtolower($param);
	}

	/**
	 * @inheritDoc
	 *
	 * @throws InvalidSearchParamValue
	 * @throws UnsupportedApiSearchParam
	 */
	public function jsonSerialize(): array {
		$params = [];
		foreach ($this->defineParams() as $name => $value) {
			if ($value !== null) {
				$params[$name] = is_string($value)
					? strtolower($value)
					: $value;
			}
		}

		PixabayParam::assertParameters($params);
		return $params;
	}

	/**
	 * Define the parameters that wil eventually be sent to Pixabay API.
	 * Note that all null values will be ignored.
	 * Use keys from {@see PixabayParam}.
	 *
	 * @return array<string, mixed> The data that will be sent as the search parameters.
	 */
	abstract protected function defineParams(): array;

	/**
	 * Handle an unknown param name from the quick setup of parameters.
	 *
	 * @param string $normalizedParamName The normalized parameter name (lowercase alphanumeric).
	 * @param string $paramName           The original parameter name.
	 * @param mixed  $value               The parameter value.
	 *
	 * @throws UnsupportedLocalSearchParam
	 */
	abstract protected function handleUnknownParam(string $normalizedParamName, string $paramName, $value): void;
}
