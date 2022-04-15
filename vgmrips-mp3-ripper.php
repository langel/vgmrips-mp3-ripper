<?php

if (count($argv) < 2) {
	echo "correct usage:\n";
	echo "php vgmrips-mp3-ripper {url_of_page_to_rip}\n";
	die();
}

echo "Ripping attempt!\n\n";

$page = file_get_contents($argv[1]);

$matches = [];

preg_match_all('|<\s*h1(?:.*)>(.*)</\s*h|Ui', $page, $matches);

$game_title = htmlspecialchars_decode(substr($matches[0][0], 4, -3));
$game_dir = str_replace(array('\\','/',':','*','?','"','<','>','|'), '_', $game_title);
echo "Game Title : $game_title\n\n";

$mp3_file_pattern = '/((https?:\/\/)?(\w+?\.)+?([a-zA-Z0-9-_~\%\.\/]+?)\.(mp3|ogg))/im';

preg_match_all($mp3_file_pattern, $page, $matches);

$mp3_file_count = count($matches[0]);

echo $mp3_file_count . " mp3 files discovered . . .\n\n";

if ($game_title == '' || $mp3_file_count == 0) {
	echo "RIP FAILED!!! :U\n\n";
}
else {
	foreach($matches[0] as $url) { echo "$url\n"; }
		echo "\n\nBeginning Rip...\n";
		$temp = 'temp.mp3';
		mkdir($game_dir);
		echo "./$game_title directory created\n";
		foreach ($matches[0] as $url) {
		echo $url."\n";
		echo urldecode($url)."\n";
		$rip = urldecode($url);
		$song_title = substr($rip, strrpos($rip, '/') + 1);
		$track_id = substr($song_title, 0, 2);
		$rip = $game_dir . '/' . $song_title;
		$song_title = substr($song_title, 3, -4);
		if (substr($song_title, 0, 2) == '- ') $song_title = substr($song_title, 2);
		exec("wget $url -O $temp --no-check-certificate");
		$output = null;
		exec("ffmpeg -i $temp -af \"volumedetect\" -f null /dev/null 2>&1", $output);
		$db = '0.0db';
		foreach ($output as $line) {
			if (strpos($line, "max_volume") !== FALSE) {
				echo $line."\n";
				$strip = [" ", ":", "-"];
				$db = str_replace($strip, "", substr($line, -8));
			}
		}
		echo "$rip\n$db\n";
		exec("ffmpeg -i $temp -af \"volume=$db\" -metadata artist=\"$game_title\" -metadata title=\"$song_title\" -metadata track=\"$track_id\" \"$rip\"");
	}
	unlink($temp);
}


?>
