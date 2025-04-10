# phpcon-odawara-2025-talk

[PHPカンファレンス小田原2025](https://phpcon-odawara.jp/2025/) のライトニングトークのネタとして書いたコードです。

> このトークでは、PHPを使って俳句の判定に本気で挑戦した結果をお伝えします。
> オーソドックスな判定方法から、形態素解析、さらには生成AIの力も借りつつ、さまざまな観点から俳句の機械的な判定について探っていきます。
>
> [小田原で　みんなで一句　詠みたいな by すてにゃん | トーク | PHPカンファレンス小田原2025 #phpcon_odawara - fortee.jp](https://fortee.jp/phpconodawara-2025/proposal/87a6bd7b-56b8-41e2-b53f-1cf21211a400)

## 1. [`mb_strlen`](https://www.php.net/manual/ja/function.mb-strlen.php) を使ったナイーブな俳句の判定

[`mb_strlen`](https://www.php.net/manual/ja/function.mb-strlen.php)を使えば日本語の文字数カウントができるため、17文字であれば俳句と判定します。  
しかし漢字などが混じっていると正確に判定ができません。

```sh
$ cd check-haiku-v1
$ php ./check-haiku-v1.php
小田原でみんなで一句詠みたいな
上五: 小田原でみ (5音)
中七: んなで一句詠み (7音)
下五: たいな (3音)
合計: 15音

これは俳句ではありません。
```

詳しくは [check-haiku-v1のREADME](./check-haiku-v1/README.md)をご覧ください。

## 2. [logue/igo-php](https://github.com/logue/igo-php) を利用した形態素解析による俳句の判定

形態素解析をすることで、漢字の読みは文章の区切り目を判別し俳句の判定をします。  
しかし辞書に読みが存在しない単語を使う場合は上手く動作しません(「PHP」に関しては読みをハードコードしてあります)。

```sh
$ cd check-haiku-v2
$ php ./check-haiku-v2.php
小田原でみんなで一句詠みたいな
上五: 小田原で (読み: オダワラデ) (5音)
中七: みんなで一句 (読み: ミンナデイック) (7音)
下五: 詠みたいな (読み: ヨミタイナ) (5音)
合計: 17音

これは俳句です。
```

詳しくは [check-haiku-v2のREADME](./check-haiku-v2/README.md)をご覧ください。

## 3. OpenAI の API を利用した俳句の判定

AIに対して具体的なプロンプトを渡すことで、一定の精度で俳句の判定をしてくれます。
しかしリクエストのたびにお金がかかるのと、入力次第では確率的に違うレスポンスを返すことがあります。

```sh
$ cd check-haiku-v3
$ export OPENAI_API_KEY=<あなたのAPIキー>
$ php ./check-haiku-v3.php
小田原でみんなで一句詠みたいな
上五: 小田原で (読み: オダワラデ) (5音)
中七: みんなで一句 (読み: ミンナデイック) (7音)
下五: 詠みたいな (読み: ヨミタイナ) (5音)
合計: 17音

これは俳句です。
```

```sh
$ cd check-haiku-v3
$ export OPENAI_API_KEY=<あなたのAPIキー>
$ php ./check-haiku-v3.php
十七文字の文章を作る
申し訳ありませんが、そのリクエストにはお応えできません。俳句かどうかを判定するための文章を提供してください。
```

詳しくは [check-haiku-v3のREADME](./check-haiku-v3/README.md)をご覧ください。
