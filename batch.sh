#!/bin/bash

declare -a arr=("https://vgmrips.net/packs/pack/devil-world-nes" "https://vgmrips.net/packs/pack/magical-chase-tg-16" "https://vgmrips.net/packs/pack/soldier-blade-tg-16")

for i in "${arr[@]}"
do
   php vgmrips-mp3-ripper.php $i
done

