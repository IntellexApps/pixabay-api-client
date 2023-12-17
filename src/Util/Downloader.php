<?php namespace Intellex\Pixabay\Util;

use RuntimeException;

/**
 * Downloads a remote file.
 */
abstract class Downloader {

	/**
	 * Download the file from the Internet.
	 *
	 * @param string $url The URL of the remote file.
	 *
	 * @return string|null The binary of the downloaded file.
	 * @throws RuntimeException
	 */
	public static function download(string $url): ?string {
		$data = file_get_contents($url);
		if ($data === false) {
			throw new RuntimeException("Unable to download: {$url}");
		}

		return $data;
	}

	/**
	 * Download the file from the net and store it to a file on the local filesystem.
	 *
	 * @param string $url  The URL of the remote file.
	 * @param string $path path to the local file.
	 *
	 * @throws RuntimeException
	 */
	public static function downloadTo(string $url, string $path): void {
		file_put_contents($path, static::download($url));
	}
}
