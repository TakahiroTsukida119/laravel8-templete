# laravel8-jwt-auth

Laravel8でJWT認証+Vue3+Typescriptのテンプレ<br>

## 環境

- Laravel 8.83.1
- PHP 8.1.2
- MySQL 8.0.*

## 推奨プラグイン
このプロジェクトでは以下のプラグインの使用を推奨しています。<br>
レベルにかかわらず導入することでコードの品質がぐっと上がるので導入をお勧めします！

### laravel-ide-helperについて
Laravelは内部でマジックメソッドが多様されている都合上、補完が効かないことによる打ち間違いやnull考慮漏れの
バグが発生しやすいフレームワークです。そんなLaravelの補完を改善してくれるのが、
この「***laravel-ide-helper***」になります。

このツールを使うと、リレーションやFacadeのクラス、 Modelのfield変数の型の補完などが効くようになり、
実装自体が楽になり、上記プラグインと組み合わせればnullの考慮漏れなんかもかなり減らすことができます。

スムーズなプロジェクト運営のためにもこちらのツールの利用をお願いします。

### 使用方法
```bash
php artisan ide-helper:generate            # PHPDoc generation for Laravel Facades
php artisan ide-helper:models --nowrite    # PHPDocs for models
php artisan ide-helper:meta                # PhpStorm Meta file
```
「ide-helper:models」に関してはModelの追加があった時には再度実行しなおしてください。
また、データベースと接続していないと実行できないため、appコンテナ内で上記コマンドを実行してください

### 注意点
「ide-helper:models」のコマンドには２種類の動作が存在し、Modelファイルに直接型を埋める処理と、
別ファイルに型を指定する処理があります。前者はコードがかなり汚れてしまうので、
後者の動作を利用するようにしてください。
（--nowrite オプションをつけた場合は強制的に後者の動作を利用します）

--nowriteオプションをつけなかった場合は途中でModelのファイルにタイプヒンティング情報を情報を 上書きしないようにするかをどうか聞かれるので、そのままエンターキーを押せば大丈夫です

## コーディング規約


## 環境構築手順

- clone

```shell
$ git clone git@github.com:TakahiroTsukida119/laravel8-jwt-auth.git
$ cd laravel8-jwt-auth
```

- .env.example をコピー

```shell
$ cp .env.example .env
```

- ビルド
```shell
$ make build
```

- コンテナ立ち上げ (linuxの人はファイルパーミッションの関係で必須)

```shell
$ make up
```

- 以下のコンテナが立ち上がっていることを確認

```shell
$ make ps
CONTAINER ID   IMAGE                        COMMAND                  CREATED         STATUS              PORTS                                        NAMES
e791f256497e   manage_server_nginx          "/docker-entrypoint.…"   6 minutes ago   Up About a minute   0.0.0.0:80->80/tcp                           manage-nginx
4f561dfb15be   manage_server_app            "docker-php-entrypoi…"   6 minutes ago   Up About a minute   0.0.0.0:9000->9000/tcp                       manage-app
eae1e56b795f   manage_server_queue_worker   "docker-php-entrypoi…"   6 minutes ago   Up About a minute   9000/tcp                                     manage-queue-worker
ca499824e04d   manage_server_mysql          "docker-entrypoint.s…"   6 minutes ago   Up 2 minutes        0.0.0.0:3306->3306/tcp, 33060/tcp            manage-mysql
4a08f20492b5   schickling/mailcatcher       "mailcatcher --no-qu…"   6 minutes ago   Up 2 minutes        1025/tcp, 0.0.0.0:1080->1080/tcp             manage-mailcatcher
6b3409f6cf97   redis:6.2-buster             "docker-entrypoint.s…"   6 minutes ago   Up 2 minutes        0.0.0.0:6379->6379/tcp                       manage-redis
149c56a97424   minio/minio                  "bash -c '/opt/bin/m…"   6 minutes ago   Up 2 minutes        9000/tcp, 0.0.0.0:9001-9002->9001-9002/tcp   manage-minio


```

- 各種install

```shell
$ make shell  // コンテナに入る
$ composer install
$ yarn
```

- migration と npm run (コンテナ内)
```shell
$ php artisan migrate:fresh --seed
$ yarn dev 
#or
$ yarn watch
```

- /etc/hostsに以下の内容を***追記***

```shell
$ sudo vi /etc/hosts

127.0.0.1 admin.localhost
```

## 各種アクセス方法
- ローカルでのメールサーバーのアクセス方法
  ブラウザで `http://localhost:1080`にアクセス

- minioのアクセス方法
  ブラウザで `http://localhost:9001`にアクセス。

```
access_key: access_key
secret_key: secret_key
```

を入力することでログイン可能.


## 各種コマンド

- コンテナ立ち上げ、停止、起動一覧

```
$ make up // 立ち上げ
$ make stop // 停止
$ make ps // 起動一覧
```

- アプリケーション用のコンテナに入る（Linuxの人はファイルパーミッションなどの関係で必須）

```shell
$ make shell
```

- laravel-ide-helperを実行する
```shell
$ make ide-helper
```

## minio立ち上げ時にデフォルトでバケットを作りたいとき
初期状態では`test`という名前のバケットが作成されるようになっている。

```
create-bucket:
    container_name: laravel-template-create-bucket
    image: minio/mc
    entrypoint: [""]
    command:
      - /bin/sh
      - -c
      - |
            until (mc config host add minio http://minio:9000 access_key secret_key) do echo 'wait until add host' && sleep 1; done;
            mc mb minio/public ←ここでpublicバケットを作成
            mc policy set public minio/public ← バケットの権限をpublicに設定
            mc mb minio/private ← ここでprivateバケットを作成
            mc policy set private minio/private ← バケットの権限をprivateに設定
    environment:
      MINIO_ROOT_USER: access_key
      MINIO_ROOT_PASSWORD: secret_key
```

`test`の部分を別の名前にすれば別のバケットが作成される
また、コマンドを複数実行すれば複数のバケットをデフォルトで作成することができる。

## ローカルサーバのHTTPS化をしなければならない場合
現在、このプロジェクトのローカル用のnginxイメージはHTTPSに対応しています。
下記の対応を追加で行うことで、HTTPSを使用することができます

### 1. FiloSottile/mkcertをローカルにインストールする
mkcertのリポジトリのREADMEを見ながらmkcertをインストールします。
(FiloSottile/mkcert https://github.com/FiloSottile/mkcert)

### 2. "mkcert -install"を実行する
下記コマンドを実行します。このコマンドを実行することでmkcertを利用して発行した証明書をブラウザの信用済み証明書リストに追加できるようになります（多分正しくない説明）
```bash
mkcert -instll
```

### 3. 通常通り、"make up"を実行する
いつもどおり、`make up`を実行します。