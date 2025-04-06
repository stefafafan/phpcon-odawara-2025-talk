# check-haiku-v2

ここでは形態素解析を活用して、俳句の判定を実装しています。

## 形態素解析のために検討したライブラリ・API

php-mecab, igo-php, Yahoo日本語形態素解析API, RakutenMA API, Google Cloud Natural Language APIなどを検討しましたが、
ローカルで動く上にセットアップが楽そうな igo-php (厳密にはフォークの https://github.com/logue/igo-php )を採用しています。

## 辞書データのセットアップ

1. https://github.com/sile/igo/releases/tag/0.4.5 から本体のソースコードをダウンロードします。
2. ディレクトリ移動しておきます。 i.e. `cd /path/to/igo` 
3. `brew install ant` などで `ant` を入れます。
4. `ant` を実行し、ソースコードをビルドします。 `igo-0.4.5.jar` ができます。
5. `java -cp /path/to/igo-0.4.5.jar net.reduls.igo.bin.BuildDic ipadic /path/to/mecab-ipadic-2.7.0-20070801 EUC-JP` のようなコマンドを実行し、 `ipadic` ディレクトリに辞書データを生成します。

