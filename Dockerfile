FROM php:8.0-cli-alpine

COPY --from=composer:2.0 /usr/bin/composer /usr/local/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install --no-scripts --no-autoloader --no-dev --no-interaction --no-ansi --prefer-dist --quiet

COPY ./ ./

RUN composer dump-autoload --classmap-authoritative

ENTRYPOINT ["/app/bin/console"]
CMD ["run"]