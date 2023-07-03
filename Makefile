start:
	docker-compose -f docker-compose.yml up -d --build
	docker-compose -f docker-compose.yml run php composer install

stop:
	docker-compose -f docker-compose.yml stop

test:
	docker-compose -f docker-compose.yml run php ./vendor/bin/phpunit