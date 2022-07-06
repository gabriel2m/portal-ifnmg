FROM php:8.1-fpm-alpine

RUN apk add --no-cache \
		acl \
		fcgi \
		file \
		gettext \
		git \
		gnu-libiconv \
		npm \
	;

# install gnu-libiconv and set LD_PRELOAD env to make iconv work fully on Alpine image.
ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so

RUN set -eux; \
	apk add --no-cache --virtual .build-deps \
		$PHPIZE_DEPS \
		icu-dev \
		libzip-dev \
		zlib-dev \
		libpq-dev \
	; \
	\
	docker-php-ext-configure zip; \
	docker-php-ext-install -j$(nproc) \
		intl \
		zip \
        pdo_pgsql \
	; \
	pecl install \
		apcu-5.1.21 \
	; \
	docker-php-ext-enable \
		apcu \
		opcache \
	; \
	\
	runDeps="$( \
		scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
			| tr ',' '\n' \
			| sort -u \
			| awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
	)"; \
	apk add --no-cache --virtual .phpexts-rundeps $runDeps;

###########################################################################
# XDEBUG
###########################################################################

ARG INSTALL_XDEBUG=false

RUN if [ ${INSTALL_XDEBUG} = true ]; then \
	pecl install xdebug-3.1.5; \
	docker-php-ext-enable xdebug \
;fi

###########################################################################

RUN pecl clear-cache; \
	apk del .build-deps

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

ARG UID=1000
ENV UID ${UID}
ARG GID=1000
ENV GID ${GID}

RUN addgroup -g ${GID} app

RUN adduser -u ${UID} -G app -D app

USER app
	
COPY ./.docker/app/php.ini /usr/local/etc/php/php.ini

WORKDIR /srv/app
