FROM php:8.1-fpm-buster

ENV TZ Asia/Tokyo

RUN apt-get update && \
  apt-get -y install --no-install-recommends git unzip libzip-dev libicu-dev libonig-dev && \
  apt-get clean && \
  rm -rf /var/lib/apt/lists/* && \
  docker-php-ext-install intl pdo_mysql zip bcmath
		
COPY ./php.ini /usr/local/etc/php/php.ini

COPY --from=composer:2.5.5 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# nodeインストール
RUN curl -sL https://deb.nodesource.com/setup_lts.x | bash -
RUN apt-get install -y nodejs

# ユーザーIDをセット
ARG UID=1000
# グループIDをセット
ARG GID=1000
# コンテナ内に名称dockerでグループを作成
RUN groupadd -g ${GID} docker
# コンテナ内に名称dockerでdockerグループに所属するユーザーを作成
RUN useradd -u ${UID} -g ${GID} -s /bin/bash/ -m docker
# コンテナを実行するユーザーを指定
USER ${UID}
