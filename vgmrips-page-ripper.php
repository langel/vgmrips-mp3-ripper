<?php

if (count($argv) < 2) {
	echo "correct usage:\n";
	echo "php vgmrips-page-ripper {url_of_search_page_to_rip}\n";
	die();
}

echo "Page Ripping Attempt!\n\n";

$page = file_get_contents($argv[1]);

$matches = [];

preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $page, $matches);

foreach ($matches[0] as $match) {
	if (str_contains($match, '#autoplay')) {
		echo $match."\r\n";
		exec("php vgmrips-mp3-ripper.php " . $match);
	}
}
