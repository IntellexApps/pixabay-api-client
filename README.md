# Lightweight PHP client for Pixabay API

* Support for the complete **Pixabay API**
* Both **image** and **video**
* Define search parameters using **type-strict fluent setters**
* Utility class for **downloading** the results
* **No 3rd party** libraries used

Disclaimer
-------------------

During development there were some minor changes in the API: they removed "favorites" count from the response.
However, this broke our code and made v1.x.x unusable.

**_BE ADVISED_**: Any changes on the side of Pixabay **_CAN_** render this library unusable at any point.
For more info, see the [Licence](LICENSE).

Usage
-------------------

These are snippets from the files in the [tests/examples](tests/examples) directory.

#### Videos

```php
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
```

#### Images

```php
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
```

#### Download results

```php
// Destination must be defined 
if ($argc < 2) {
	echo "Usage: php -f tests/examples/download.php <destination> <count>";
	exit(1);
}

// Read the input parameters
$count = (int) min(50, $argv[2] ?? 50);
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
```

Run examples
-------------------

In order to run examples the Pixabay API key needs to be defined.

```shell
PIXABAY_API_KEY=0000000-0000000000000000000000000 php -f tests/examples/images.php
PIXABAY_API_KEY=0000000-0000000000000000000000000 php -f tests/examples/videos.php
PIXABAY_API_KEY=0000000-0000000000000000000000000 php -f tests/examples/download.php ~/Desktop/ 5
```

References
-------------------

- [The official Pixabay API docs](https://pixabay.com/api/docs/).

Credits
-------------------
Script has been written by the [Intellex](https://intellex.rs/en) team.
