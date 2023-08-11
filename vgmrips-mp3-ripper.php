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

$sound_chip = substr($page, strpos($page, '/packs/chip/') + 12);
$sound_chip = substr($sound_chip, 0, strpos($sound_chip, '"'));
//$game_dir = "[$sound_chip] $game_dir";
echo "Sound Chip : $sound_chip\n\n";
$system = substr($page, strpos($page, '/packs/system/'));
$system = substr($system, strpos($system, '">') + 2);
$system = substr($system, 0, strpos($system, '</a>'));
preg_match_all('/[A-Z0-9]/', $system, $system_abbr);
$system_abbr = join('', $system_abbr[0]);
echo "System : $system ($system_abbr)\n\n";

$game_dir = "[$system_abbr] $game_dir";

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
	mkdir($game_dir);
	echo "./$game_title directory created\n";
	$temp = "temp.mp3";
	foreach ($matches[0] as $url) {
		echo $url."\n";
		echo urldecode($url)."\n";
		$rip = urldecode($url);
		$song_title = substr($rip, strrpos($rip, '/') + 1);
		$track_id = substr($song_title, 0, 2);
		$song_title = substr($song_title, 3, -4);
		if (substr($song_title, 0, 2) == '- ') $song_title = substr($song_title, 2);
		$rip = $game_dir . '/' . str_pad($track_id, 2, "0", STR_PAD_LEFT) . ' ' . $song_title . '.mp3';
		echo $rip."\n";
		exec("wget $url -O \"$temp\" --no-check-certificate");
		exec("ffmpeg -i \"$temp\" -metadata artist=\"$game_title\" -metadata title=\"$song_title\" -metadata track=\"$track_id\" \"$rip\"");
	}
	unlink($temp);
	chdir($game_dir);
	exec('ffmpeg-normalize * -c:a libmp3lame --target-level -15 -f -v -ext mp3');
	exec('rm *mp3');
	exec('mv normalized/* .');
	rmdir('normalized');
	chdir('..');
	echo "$game_dir donloaded and processed!\n";
}


?>
