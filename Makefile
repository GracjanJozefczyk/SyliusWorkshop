.PHONY: install

install:
	@make composer-install
	@make rdb
	@make frontend

composer-install:
	@docker-compose exec app composer install

rdb:
	@docker-compose exec app sh -c 'if bin/console doctrine:query:sql "SELECT 1" > /dev/null 2>&1; then bin/console doctrine:database:drop --force; fi'
	@docker-compose exec app bin/console doctrine:database:create
	@docker-compose exec app bin/console doctrine:migrations:migrate -n
	@docker-compose exec app bin/console sylius:fixtures:load -n

frontend:
	@docker-compose exec app yarn install
	@docker-compose exec app yarn encore dev

php-shell:
	@docker-compose exec app sh

behat:
	@docker-compose exec -e APP_ENV=test -e APP_DEBUG=0 app vendor/bin/behat
