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

$game_title = substr($matches[0][0], 4, -3);
$game_dir = str_replace(array('\\','/',':','*','?','"','<','>','|'), '_', $game_title);
echo "Game Title : $game_title\n\n";

$mp3_file_pattern = '/((https?:\/\/)?(\w+?\.)+?([a-zA-Z0-9-_\%]+?\/)+[a-zA-Z0-9:-_\%]+?.(mp3|ogg))/im';

preg_match_all($mp3_file_pattern, $page, $matches);

$mp3_file_count = count($matches[0]);

echo $mp3_file_count . " mp3 files discovered . . .\n\n";

if ($game_title == '' || $mp3_file_count == 0) {
   echo "RIP FAILED!!! :U\n\n";
}
else {
   echo "Beginning Rip...\n";
   mkdir($game_dir);
   echo "./$game_title directory created\n";
   foreach ($matches[0] as $url) {
      echo $url."\n";
      echo urldecode($url)."\n";
		$rip = urldecode($url);
		$song_title = substr($rip, strrpos($rip, '/') + 1);
		$rip = $game_dir . '/' . $song_title;
		exec("wget $url -O '$rip'");
		$song_title = substr($song_title, 3, -4);
		exec("id3v2 -a '$game_title' -t '$song_title' '$rip'");
   }
}


?>
