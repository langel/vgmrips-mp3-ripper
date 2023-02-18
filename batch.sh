#!/bin/bash

declare -a arr=(\
"https://vgmrips.net/packs/pack/tatsujin-tg-16" \
"https://vgmrips.net/packs/pack/final-soldier-tg-16" \
"https://vgmrips.net/packs/pack/jackie-chan-tg-16" \
"https://vgmrips.net/packs/pack/gradius-tg-16" \
"https://vgmrips.net/packs/pack/dungeon-explorer-tg-16" \
"https://vgmrips.net/packs/pack/gomola-speed-pc-engine" \
"https://vgmrips.net/packs/pack/break-in-tg-16" \
"https://vgmrips.net/packs/pack/super-star-soldier-j-tg-16" \
"https://vgmrips.net/packs/pack/kyukyoku-tiger-tg-16" \
"https://vgmrips.net/packs/pack/neutopia-ii-tg-16" \
"https://vgmrips.net/packs/pack/cratermaze-tg-16"\
)

for i in "${arr[@]}"
do
   php vgmrips-mp3-ripper.php $i
done

