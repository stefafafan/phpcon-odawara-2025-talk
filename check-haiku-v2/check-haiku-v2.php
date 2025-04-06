<?php

declare(strict_types=1);

// 形態素解析を活用して、俳句の音数を判定する
// 検討した選択肢: php-mecab, igo-php, Yahoo日本語形態素解析API, RakutenMA API, Google Cloud Natural Language API
// オフラインかつ導入が楽なものとしてigo-php (のフォークであるlogue/igo-php)を選択します。
