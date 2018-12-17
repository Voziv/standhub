FROM php:7.2-apache-stretch

########################################
# Install Prerequisites
########################################
RUN apt-get update
RUN DEBIAN_FRONTEND=noninteractive \
    apt-get install -y \
    bash \
    curl \
    git \
    mercurial \
    patch \
    subversion \
    zip \
    zlib1g-dev \
    --no-install-recommends \
     && rm -rf /var/lib/apt/lists/* \
     && docker-php-ext-install zip

RUN echo "memory_limit=-1" > "$PHP_INI_DIR/conf.d/memory-limit.ini" \
 && echo "date.timezone=${PHP_TIMEZONE:-UTC}" > "$PHP_INI_DIR/conf.d/date_timezone.ini"

########################################
# Install composer
########################################
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /tmp
ENV COMPOSER_VERSION 1.7.2

RUN curl --silent --fail --location --retry 3 --output /tmp/installer.php --url https://raw.githubusercontent.com/composer/getcomposer.org/b107d959a5924af895807021fcef4ffec5a76aa9/web/installer \
 && php -r " \
    \$signature = '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061'; \
    \$hash = hash('SHA384', file_get_contents('/tmp/installer.php')); \
    if (!hash_equals(\$signature, \$hash)) { \
        unlink('/tmp/installer.php'); \
        echo 'Integrity check failed, installer is either corrupt or worse.' . PHP_EOL; \
        exit(1); \
    }" \
 && php /tmp/installer.php --no-ansi --install-dir=/usr/bin --filename=composer --version=${COMPOSER_VERSION} \
 && composer --ansi --version --no-interaction \
 && rm -rf /tmp/* /tmp/.htaccess

########################################
# Install application dependencies
########################################
WORKDIR /var/www/html
RUN echo $PWD
COPY ./composer.json ./composer.lock* ./

# RUN composer config github-oauth.github.com YOUROAUTHKEYHERE
RUN composer install --prefer-dist --no-dev --no-scripts --no-autoloader --ansi --no-interaction

########################################
# Configure apache
########################################
COPY apache.conf /etc/apache2/sites-available/ratehub.conf
RUN a2enmod rewrite && \
    a2enmod expires && \
    a2enmod headers && \
    a2dissite 000-default && \
    a2dissite default-ssl && \
    a2ensite ratehub

########################################
# Copy code as late as possible
# as it changes the most
########################################
COPY --chown=www-data:www-data ./ .
RUN composer dump-autoload -o

########################################
# Healthcheck
########################################
HEALTHCHECK --interval=5s --timeout=3s \
  CMD curl -f http://localhost/ping || exit 1

WORKDIR /var/www/html/public
