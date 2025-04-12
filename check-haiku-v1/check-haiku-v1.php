<?php

declare(strict_types=1);

function isHaiku(string $input): bool
{
    // 5-7-5の合計17音 (17文字) であれば俳句であると判定する。
    return mb_strlen($input) === 17;
}

function describeHaiku(string $input): string
{
    $oto = [
        '上五' => mb_substr($input, 0, 5),
        '中七' => mb_substr($input, 5, 7),
        '下五' => mb_substr($input, 12),
    ];

    $description = "上五: {$oto['上五']} (" . mb_strlen($oto['上五']) . "音)\n";
    $description .= "中七: {$oto['中七']} (" . mb_strlen($oto['中七']) . "音)\n";
    $description .= "下五: {$oto['下五']} (" . mb_strlen($oto['下五']) . "音)\n";
    $description .= "合計: " . mb_strlen($input) . "音\n";
    return $description;
}

$stdin = fopen("php://stdin", "r");
if ($stdin === false) {
    echo "標準入力を開けませんでした\n";
    exit(1);
}
$input = fgets($stdin);
if ($input === false) {
    echo "標準入力からの読み込みに失敗しました\n";
    fclose($stdin);
    exit(1);
}
$input = str_replace(['　', ' '], '', mb_trim($input));
fclose($stdin);

echo describeHaiku($input) . "\n";
if (isHaiku($input)) {
    echo "これは俳句です。\n";
} else {
    echo "これは俳句ではありません。\n";
}
