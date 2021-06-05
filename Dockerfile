FROM php:8.0-cli-alpine

ENV PANTHER_NO_SANDBOX 1
ENV PANTHER_NO_HEADLESS 0
ENV PANTHER_CHROME_ARGUMENTS '--disable-dev-shm-usage'

ENV APP_ENV 'dev'

COPY --from=composer:2.0 /usr/bin/composer /usr/local/bin/composer

RUN apk add --no-cache chromium chromium-chromedriver libzip-dev \
 && docker-php-ext-install zip

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install --no-scripts --no-autoloader --no-dev --no-interaction --no-ansi --prefer-dist --quiet

COPY ./ ./

RUN composer dump-autoload --classmap-authoritative

ENTRYPOINT ["/app/bin/console"]
CMD ["run"]