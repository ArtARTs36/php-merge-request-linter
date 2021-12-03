# Library without dev deps
composer update --no-interaction --no-progress --no-dev --prefer-stable --optimize-autoloader

# Build box
cd dev/build/ && composer install

# cd to home

cd ../../

echo "y" | composer require guzzlehttp/guzzle

# Compile phar
dev/build/vendor/bin/box compile

git checkout composer.json

if [ -z ${NOT_UPDATE_AFTER_BUILD} ]; then
  composer update --no-interaction --no-progress -q;
fi
