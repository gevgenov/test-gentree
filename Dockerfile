FROM php:8.2-cli-alpine

ARG user
ARG uid
ARG gid

RUN apk add jq
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

RUN install-php-extensions \
        @composer \
        ds

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN addgroup --gid $gid $user \
    && adduser -u $uid -G $user -s /bin/sh -D $user

# Set working directory
WORKDIR /app

USER $user
