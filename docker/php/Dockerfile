FROM php:8-fpm

RUN apt update

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt install -y \
	libicu-dev \
	libzip-dev \
	zip \
	git

RUN docker-php-ext-configure intl \
	&& docker-php-ext-install intl \
	&& docker-php-ext-install zip

ARG NEWRELIC_VERSION=12.9.0.38

RUN curl -L "https://download.newrelic.com/php_agent/archive/$NEWRELIC_VERSION/newrelic-php5-$NEWRELIC_VERSION-linux.tar.gz" | tar -C /tmp -zx

RUN export NR_INSTALL_USE_CP_NOT_LN=1 \
    && export NR_INSTALL_SILENT=1 \
    && /tmp/newrelic-php5*/newrelic-install install \
    && rm -fr /tmp/newrelic-php5* /tmp/nrinstall*

ARG NEWRELIC_LICENSE_KEY
ARG COMPOSE_PROJECT_NAME
ARG NEWRELIC_DAEMON_ADDRESS

RUN sed -i \
    -e "s/newrelic.license = \"REPLACE_WITH_REAL_KEY\"/newrelic.license = \"${NEWRELIC_LICENSE_KEY}\"/" \
    -e "s/newrelic.appname = \"PHP Application\"/newrelic.appname = \"${COMPOSE_PROJECT_NAME}\"/" \
    -e "s/;newrelic.daemon.address = \"\/tmp\/.newrelic.sock\"/newrelic.daemon.address = \"${NEWRELIC_DAEMON_ADDRESS}\"/" \
    -e "s/;newrelic.daemon.app_connect_timeout =.*/newrelic.daemon.app_connect_timeout = 15s/" \
#    -e "s/;newrelic.daemon.start_timeout =.*/newrelic.daemon.start_timeout = 5s/" \
#    -e "s/;newrelic.enabled = true/newrelic.enabled = true/" \
    -e "s/;newrelic.daemon.dont_launch =.*/newrelic.daemon.dont_launch = 3/" \
    /usr/local/etc/php/conf.d/newrelic.ini

WORKDIR /var/www/project
