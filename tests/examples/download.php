<?php declare(strict_types = 1);

require_once __DIR__ . '/../cfg/bootstrap.php';

use Intellex\Pixabay\Enum\Category;
use Intellex\Pixabay\Enum\ImageType;
use Intellex\Pixabay\Enum\Order as OrderAlias;
use Intellex\Pixabay\Enum\Orientation;
use Intellex\Pixabay\ImageApi;
use Intellex\Pixabay\Search\PixabayParam;
use Intellex\Pixabay\Search\ImageSearchParams;
use Intellex\Pixabay\Util\Downloader;

// Destination must be defined
if ($argc < 2) {
	echo "Usage: php -f tests/examples/download.php <destination> <count>";
	exit(1);
}

// Read the input parameters
$count = (int) min(20, $argv[2] ?? 20);
$destination = rtrim($argv[1], DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
if (!is_dir($destination) || !is_writable($destination)) {
	echo "Supplied destination is not a writable directory: ${destination}";
	exit(2);
}

// Invoke the API
$response = (new ImageApi(API_KEY))->fetch(new ImageSearchParams([
	PixabayParam::Q              => 'kitten',
	PixabayParam::CATEGORY       => Category::ANIMALS,
	PixabayParam::IMAGE_TYPE     => ImageType::PHOTO,
	PixabayParam::ORIENTATION    => Orientation::HORIZONTAL,
	PixabayParam::PER_PAGE       => $count,
	PixabayParam::SAFE_SEARCH    => true,
	PixabayParam::EDITORS_CHOICE => true,
	PixabayParam::ORDER          => OrderAlias::POPULAR
]));

// Download and store
$images = $response->getImages();
$count = count($images);
foreach ($images as $i => $image) {
	$preview = explode('/', $image->getPreviewURL());
	$name = end($preview) . PHP_EOL;
	echo sprintf("%3s / %3s, %s", $i + 1, $count, $name);
	Downloader::downloadTo($image->getLargeImageURL(), "{$destination}/{$name}");
}
