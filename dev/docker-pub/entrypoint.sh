#!/bin/sh

# based on: https://github.com/composer/docker/blob/main/2.4/docker-entrypoint.sh
isCommand() {
  # Retain backwards compatibility with common CI providers,
  # see: https://github.com/composer/docker/issues/107
  if [ "$1" = "sh" ]; then
    return 1
  fi
}

# check if the first argument passed in looks like a flag
if [ "${1#-}" != "$1" ]; then
  set -- tini -- mr-linter "$@"
# check if the first argument passed in is mr-linter
elif [ "$1" = 'mr-linter' ]; then
  set -- tini -- "$@"
# check if the first argument passed in matches a known command
elif isCommand "$1"; then
  set -- tini -- mr-linter "$@"
fi

exec "$@"
