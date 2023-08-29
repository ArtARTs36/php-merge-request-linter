FROM php:8.1-alpine

RUN apk add --update git zip && rm -rf /var/cache/apk/*

COPY --from=composer:2.4.0 /usr/bin/composer /usr/bin/composer

COPY ./ /app/

WORKDIR /app

RUN composer install

ENTRYPOINT ["/app/bin/mr-linter"]
