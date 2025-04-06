<?php

$first = [
    "小田原の",
    "小田原は",
    "小田原で",
    "登壇は",
    "ぺちおだは",
    "ぺちおだの",
    "ぺちおだで",
];

$second = [
    "みんなで食べる",
    "みんなで歌う",
    "梅丸音頭",
];

$last = [
    "美味しいな",
    "楽しいな",
    "嬉しいな",
    "アジフライ",
    "かわらばん",
];

$haiku = [];

foreach ($first as $f) {
    foreach ($second as $s) {
        foreach ($last as $l) {
            $generate = "$f$s$l";
            $haiku[] = $generate;
        }
    }
}

echo $haiku[mt_rand(0, count($haiku) - 1)] . "\n";
