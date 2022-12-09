FROM php:8.1

ARG MR_LINTER_VERSION

RUN curl -L https://github.com/ArtARTs36/php-merge-request-linter/releases/download/${MR_LINTER_VERSION}/mr-linter.phar --output /usr/bin/mr-linter

RUN chmod +x /usr/bin/mr-linter

ENTRYPOINT ["/usr/bin/mr-linter"]
