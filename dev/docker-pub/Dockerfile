FROM php:8.1-alpine

ARG MR_LINTER_VERSION

RUN apk add --update tini

RUN curl -L -f https://github.com/ArtARTs36/php-merge-request-linter/releases/download/${MR_LINTER_VERSION}/mr-linter.phar --output /usr/bin/mr-linter

RUN chmod +x /usr/bin/mr-linter

COPY dev/docker-pub/entrypoint.sh /docker-entrypoint.sh

RUN chmod +x /docker-entrypoint.sh

WORKDIR /app/

RUN rm -rf /var/cache/apk/*

ENTRYPOINT ["/docker-entrypoint.sh"]
