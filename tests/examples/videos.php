<?php declare(strict_types=1);

require_once __DIR__ . '/../cfg/bootstrap.php';

use Intellex\Pixabay\Enum\Category;
use Intellex\Pixabay\Search\VideoSearchParams;
use Intellex\Pixabay\VideoApi;

// Invoke the API directly by passing an array for the search
$response = (new VideoApi(API_KEY))->fetch(new VideoSearchParams([
	'category'       => Category::TRANSPORTATION,
	'editors_choice' => true,
	'per_page'       => 3
]));

// Show images
foreach ($response->getVideos() as $video) {
	echo $video->getMediumVideo()->getUrl() . PHP_EOL;
}
