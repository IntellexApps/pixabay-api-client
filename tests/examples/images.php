<?php declare(strict_types=1);

require_once __DIR__ . '/../cfg/bootstrap.php';

use Intellex\Pixabay\Enum\Category;
use Intellex\Pixabay\Enum\Color;
use Intellex\Pixabay\Enum\ImageType;
use Intellex\Pixabay\ImageApi;
use Intellex\Pixabay\Search\ImageSearchParams;

// Define search parameters using fluent setters
$search = (new ImageSearchParams())
	->setColors([ Color::GREEN, Color::ORANGE ])
	->setImageType(ImageType::PHOTO)
	->setCategory(Category::NATURE)
	->setEditorsChoice(true)
	->setPerPage(3);

// Invoke the API
$response = (new ImageApi(API_KEY))->fetch($search);

// Show images
foreach ($response->getImages() as $image) {
	echo $image->getURLForSize180() . PHP_EOL;
}
