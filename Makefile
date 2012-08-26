
all: check deploy 

check-foaf: data/foaf.ttl
	@rapper -q -i turtle $^ > /dev/null && echo "Parsed $^ without any errors."

check: check-foaf

deploy:
	@git diff-index --quiet HEAD || { echo "Working directory is dirty." ; exit 1; }
	git push njh@njh.me:/srv/www/njh.me master
