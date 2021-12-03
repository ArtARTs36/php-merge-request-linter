# Library without dev deps
composer update --no-interaction --no-progress --no-dev --prefer-stable --optimize-autoloader

# Build box
cd dev/build/ && composer install

# cd to home

cd ../../

# Compile phar
dev/build/vendor/bin/box compile

composer update --no-interaction --no-progress -q
