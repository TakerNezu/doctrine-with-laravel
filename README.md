# IntegratingDoctrineWithLaravel

DoctrineとLaravelをシンプルに連携するためのライブラリ

## Install

composer install takeru-nezu/integrating-doctrine-with-laravel

## Setup

note: 現在は、XMLMetadataにのみ対応

resource/xml -> XMLMetadataを配置
app/Entities -> MetadataとつなげるEntityクラスを配置
database/migrations -> コマンド結果のマイグレーションファイルが配置される

DB情報は config/detabaseを経由して、.envを参照

## Howto

このライブラリのメインの特徴は、コマンドツールをLaravelのスタイルに合わせているところです。

以下の方法で、利用できるコマンドを確認でいます。

各コマンドは本家のDoctrineコマンドを忠実に再現しています。

php artisan help doctrine
