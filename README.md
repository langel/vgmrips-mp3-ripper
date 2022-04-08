# vgmrips-mp3-ripper
[vgmrips.net](https://vgmrips.net) is a wonderfully site hosting meticulously ripped and preserved .vgm files that are also meticulously rendered to twice-loop-and-fade .mp3 files available for streaming on an embedded playlist player. They provide downloadable .zip files of the .vgm files but they do not provide the same for the .mp3 versions of these carefully curated classic video game soundtracks. This script provides a simple way to download said .mp3 files into a nice directory for each nice game title. It also adds meta tags with the game title as artist so you know what you're listening to at all times after ripping 100+ OSTs and throwing them all in WinAmp on shuffle.

## Usage
    php vgmrips-mp3-ripper.php {url_of_page_to_rip}

## Requirements
PHP helps - id3v2 for tags - mp3info optional for verifications
