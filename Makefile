
all: check deploy

check: check-foaf test

check-foaf: data/foaf.ttl
	@rapper -q -i turtle $^ > /dev/null && echo "Parsed $^ without any errors."

test:
	phpunit --strict test

coverage:
	phpunit --strict --coverage-html=./coverage test

deploy:
	@git diff-index --quiet HEAD || { echo "Working directory is dirty." ; exit 1; }
	git push njh@njh.me:/srv/www/njh.me master


.PHONY: all check check-foaf test coverage deploy
