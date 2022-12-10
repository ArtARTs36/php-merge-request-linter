FROM php:8.1

ARG MR_LINTER_VERSION

RUN apt update && apt install -y tini

RUN curl -L -f https://github.com/ArtARTs36/php-merge-request-linter/releases/download/${MR_LINTER_VERSION}/mr-linter.phar --output /usr/bin/mr-linter

RUN chmod +x /usr/bin/mr-linter

COPY dev/docker-pub/entrypoint.sh /docker-entrypoint.sh

RUN chmod +x /docker-entrypoint.sh

WORKDIR /app/

ENTRYPOINT ["/docker-entrypoint.sh"]
