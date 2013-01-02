PHPUNIT=php ./vendor/bin/phpunit
COMPOSER_FLAGS=--dev

all: composer-install check deploy

composer-install: composer.phar
	php composer.phar $(COMPOSER_FLAGS) install

composer.phar:
	curl -s -z composer.phar -o composer.phar http://getcomposer.org/composer.phar

check: check-foaf test

check-foaf: data/foaf.ttl
	@rapper -q -i turtle $^ > /dev/null && echo "Parsed $^ without any errors."

test:
	$(PHPUNIT) --strict test

coverage:
	$(PHPUNIT) --strict --coverage-html=./coverage test

deploy:
	@git diff-index --quiet HEAD || { echo "Working directory is dirty." ; exit 1; }
	git push njh@njh.me:/srv/www/njh.me master

clean:
	rm -f composer.phar
	rm -Rf vendor/
	rm -Rf coverage/

.PHONY: all check check-foaf test coverage deploy
