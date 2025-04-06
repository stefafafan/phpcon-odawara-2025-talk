<?php

declare(strict_types=1);
require 'vendor/autoload.php';

// 形態素解析を活用して、俳句の音数を判定する
// 検討した選択肢: php-mecab, igo-php, Yahoo日本語形態素解析API, RakutenMA API, Google Cloud Natural Language API
// オフラインかつ導入が楽なものとしてigo-php (のフォークであるlogue/igo-php)を選択します。

// igo本体と辞書の生成メモ:
// https://github.com/sile/igo/releases/tag/0.4.5 から igo 本体のソースコードをダウンロード
// brew install ant
// cd /path/to/igo
// ant
// java -cp /path/to/igo-0.4.5.jar net.reduls.igo.bin.BuildDic ipadic /path/to/mecab-ipadic-2.7.0-20070801 EUC-JP

$igo = new Igo\Tagger();
$result = $igo->parse('小田原でみんなで一句詠みたいな');
print_r($result);
