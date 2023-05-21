FROM php:8.1

COPY --from=composer:2.4.0 /usr/bin/composer /usr/bin/composer

COPY ./ /app/

WORKDIR /app

RUN composer install

ENTRYPOINT ["/app/bin/mr-linter"]
