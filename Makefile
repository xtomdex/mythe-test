up: docker-up
down: docker-down
restart: docker-down docker-up
docker-init: docker-down-clear docker-pull docker-up
app-test: app-test-fixtures app-test-all
app-init: app-composer-install app-migrations app-fixtures app-test
init: docker-init app-init

docker-up:
	docker-compose up -d --build

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

app-composer-install:
	docker-compose run --rm composer install --no-scripts

app-migrations:
	docker-compose run --rm php-cli ./bin/console doctrine:migrations:migrate --no-interaction
	docker-compose run --rm php-cli ./bin/console doctrine:migrations:migrate --env=test --no-interaction

app-fixtures:
	docker-compose run --rm php-cli ./bin/console doctrine:fixtures:load --no-interaction

app-test-all:
	docker-compose run --rm php-cli ./bin/phpunit

app-test-unit:
	docker-compose run --rm php-cli ./bin/phpunit --testsuite unit

app-test-fixtures:
	docker-compose run --rm php-cli ./bin/console doctrine:fixtures:load --env=test --no-interaction