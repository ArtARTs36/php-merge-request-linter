FROM php:8.1

COPY ./ /app/

WORKDIR /app

ENTRYPOINT ["/app/bin/mr-linter"]
