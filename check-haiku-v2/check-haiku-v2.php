<?php

declare(strict_types=1);
require 'vendor/autoload.php';

const KAMIGO_LEN = 5;
const NAKASHICHI_LEN = 7;
const SHIMOGO_LEN = 5;

// PHPのような辞書に読みが登録されていない単語の読みを指定する。
const specialWords = [
    'PHP' => 'ピーエイチピー',
];

/**
 * 形態素解析済みの配列を受け取り、指定されたindexからlimitまでの文字列や読みを取得する。
 * 上五、中七、下五の文字列と読みを取得するために使用される。
 * 注意: $index を書き換えて返す。
 * @param array<mixed> $parsed
 * @param int $limit
 * @param int $index
 * @return array{
 *    count: int,
 *   original: string,
 *   yomi: string,
 *  index: int
 * }
 */
function parseLine(array $parsed, int $limit, int $index): array
{
    $count = 0;
    $original = "";
    $yomi = "";
    // 音数の上限を超えるまで続ける (上五は5音、中七は7音、下五は5音)
    while ($count < $limit) {
        if (!array_key_exists($index, $parsed)) {
            break;
        }
        $current = isset($parsed[$index]->feature[8]) ? $parsed[$index]->feature[8] : $parsed[$index]->surface;
        // 特殊な単語は読みを置き換える
        if (array_key_exists($current, specialWords)) {
            $current = specialWords[$current];
        }
        $count += mb_strlen($current);
        // ャュョについては直前の音にくっつくため、その分音数を減らす
        $count -= preg_match_all('/[ャュョ]/u', $current);
        $original .= $parsed[$index]->surface;
        $yomi .= $current;
        $index++;
    }

    return [
        'count' => $count,
        'original' => $original,
        'yomi' => $yomi,
        'index' => $index,
    ];
}

/**
 * 俳句かどうかを判定する関数
 * @param string $input
 * @return bool
 */
function isHaiku(string $input): bool
{
    $igo = new Igo\Tagger();
    $result = $igo->parse($input);

    $i = 0;
    $kamigo = parseLine($result, KAMIGO_LEN, $i);
    $nakashichi = parseLine($result, NAKASHICHI_LEN, $kamigo['index']);
    $shimogo = parseLine($result, SHIMOGO_LEN, $nakashichi['index']);
    return $kamigo['count'] === KAMIGO_LEN && $nakashichi['count'] === NAKASHICHI_LEN && $shimogo['count'] === SHIMOGO_LEN;
}

/**
 * 俳句の説明を生成する関数
 * @param string $input
 * @return string
 */
function describeHaiku(string $input): string
{
    $igo = new Igo\Tagger();
    $result = $igo->parse($input);

    $i = 0;
    $kamigo = parseLine($result, KAMIGO_LEN, $i);
    $nakashichi = parseLine($result, NAKASHICHI_LEN, $kamigo['index']);
    $shimogo = parseLine($result, SHIMOGO_LEN, $nakashichi['index']);

    $description = "上五: {$kamigo['original']} (読み: {$kamigo['yomi']}) ({$kamigo['count']}音)\n";
    $description .= "中七: {$nakashichi['original']} (読み: {$nakashichi['yomi']}) ({$nakashichi['count']}音)\n";
    $description .= "下五: {$shimogo['original']} (読み: {$shimogo['yomi']}) ({$shimogo['count']}音)\n";
    $description .= "合計: " . ($kamigo['count'] + $nakashichi['count'] + $shimogo['count']) . "音\n";
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
