<?php declare(strict_types = 1);
// phpcs:disable PSR1.Files.SideEffects.FoundWithSymbols,Squiz.PHP.DiscouragedFunctions.Found

// Make sure the composer is loaded
require_once __DIR__ . '/../../vendor/autoload.php';

// Define the key
define('API_KEY', getenv('PIXABAY_API_KEY') ?: 'Define PIXABAY_API_KEY env variable before running examples');

// Quick and dirty debug
if (!function_exists('dd')) {
	function dd(): void {
		$vars = func_get_args();
		foreach ($vars as $var) {
			echo "\n\n============================================================================================\n\n";
			print_r($var);
		}
		echo "\n\n=============================================================================================\n\n";
		die;
	}
}
