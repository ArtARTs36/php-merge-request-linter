composer update --no-interaction --no-progress --no-dev --prefer-stable --optimize-autoloader

dev/build/vendor/bin/box compile

git checkout composer.json
composer update --no-interaction --no-progress -q
