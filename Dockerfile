FROM php:8.2-alpine

RUN apk add --update git zip gcc libc-dev autoconf make && rm -rf /var/cache/apk/*

RUN pecl install pcov && docker-php-ext-enable pcov

COPY --from=composer:2.4.0 /usr/bin/composer /usr/bin/composer

COPY ./ /app/

WORKDIR /app

RUN composer install

ENTRYPOINT ["/app/bin/mr-linter"]
