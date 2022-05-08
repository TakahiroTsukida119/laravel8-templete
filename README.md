# laravel8-jwt-auth

Laravel8でJWT認証+Vue3+Typescriptのテンプレ<br>

## 環境

- Laravel 8.83.1
- PHP 8.1.2
- MySQL 8.0.*
- OpenApi 3.0.2

## OpenApiGeneratorについて
SwaggerUIコンテナがローカルで立っており、<br>`localhost:8080`にアクセスすることでSwaggerUI上でAPIスキーマを確認・検証することができます。

### スキーマの更新
appコンテナ内のルートディレクトリで以下を実行すると<br>`/dist/openapi.json`が自動で更新されます。
```bash
make api-generate
```
※SwaggerUIを更新させたい場合はブラウザをリロードしてください。

## 環境構築手順

- clone

```shell
$ git clone git@github.com:TakahiroTsukida119/laravel8-templete.git
$ cd laravel8-templete
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
CONTAINER ID   IMAGE                            COMMAND                  CREATED      STATUS          PORTS                                        NAMES
a21c3362f7e7   laravel8-templete_nginx          "/docker-entrypoint.…"   6 days ago   Up 50 minutes   0.0.0.0:80->80/tcp                           laravel8-template-nginx
1bd627d10fd0   laravel8-templete_app            "docker-php-entrypoi…"   6 days ago   Up 50 minutes   0.0.0.0:9000->9000/tcp                       laravel8-template-app
7d56389acede   laravel8-templete_queue_worker   "docker-php-entrypoi…"   6 days ago   Up 50 minutes   9000/tcp                                     laravel8-template-queue-worker
6020cf953f33   schickling/mailcatcher           "mailcatcher --no-qu…"   6 days ago   Up 50 minutes   1025/tcp, 0.0.0.0:1080->1080/tcp             laravel8-template-mailcatcher
35d27cceca9f   redis:6.2-buster                 "docker-entrypoint.s…"   6 days ago   Up 50 minutes   0.0.0.0:6379->6379/tcp                       laravel8-template-redis
5d610d98fbae   laravel8-templete_mysql          "docker-entrypoint.s…"   6 days ago   Up 50 minutes   0.0.0.0:3306->3306/tcp, 33060/tcp            laravel8-template-mysql
8b3e0187208e   swaggerapi/swagger-ui:latest     "/docker-entrypoint.…"   6 days ago   Up 50 minutes   80/tcp, 0.0.0.0:8080->8080/tcp               laravel8-template-server-openapi
49899fdf128f   minio/minio                      "bash -c '/opt/bin/m…"   6 days ago   Up 50 minutes   9000/tcp, 0.0.0.0:9001-9002->9001-9002/tcp   laravel8-template-minio

```

- 各種install

```shell
$ make shell  // コンテナに入る
$ composer install
$ yarn
```

- migration と npm run (コンテナ内)
```shell
$ make fresh
$ yarn dev 
#or
$ yarn watch
```

## 各種アクセス方法
- ローカルでのメールサーバーのアクセス方法
  ブラウザで `http://localhost:1080`にアクセス

- minioのアクセス方法
  ブラウザで `http://localhost:9001`にアクセス。
- Swaggerのアクセス方法 ブラウザで`localhost:8080`にアクセス。

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

- アプリケーション用のコンテナに入る

```shell
$ make shell
```

- laravel-ide-helperを実行する
```shell
$ make ide-helper
```
