.DEFAULT_GOAL := help
user := $(shell id -u)
group := $(shell id -g)
dc := USER_ID=$(user) GROUP_ID=$(group) docker-compose
de := docker-compose exec
dr := $(dc) run --rm
sy := $(de) php bin/console
user := $(shell id -u)
group := $(shell id -g)
drtest := $(dc) -f docker-compose.test.yml run --rm
node := $(dr) node
php := $(dr) --no-deps php

.PHONY: help
help: ## Affiche cette aide
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'





.PHONY: build-docker
build-docker:
	$(dc) pull --ignore-pull-failures
	$(dc) build php
	$(dc) build messenger
	$(dc) build node

.PHONY: dev
dev: vendor/autoload.php ## Lance le serveur de développement
	$(dc) up

.PHONY: devmac
devmac: ## Sur MacOS on ne préfèrera exécuter PHP en local pour les performances
	docker-compose -f docker-compose.macos.yml up

.PHONY: seed
seed: vendor/autoload.php ## Génère des données dans la base de données (docker-compose up doit être lancé)
	$(sy) doctrine:migrations:migrate -q
	$(sy) hautelook:fixtures:load -q

.PHONY: migration
migration: vendor/autoload.php ## Génère les migrations
	$(sy) make:migration

.PHONY: migrate
migrate: vendor/autoload.php ## Migre la base de données (docker-compose up doit être lancé)
	$(sy) doctrine:migrations:migrate -q

.PHONY: rollback
rollback:
	$(sy) doctrine:migration:migrate prev

.PHONY: test
test: vendor/autoload.php node_modules/time ## Execute les tests
	$(drtest) phptest vendor/bin/phpunit
.PHONY: cov
cov: vendor/autoload.php node_modules/time ## Execute les tests
	$(drtest) phptest vendor/bin/phpunit --coverage-html html

.PHONY: tt
tt: vendor/autoload.php ## Lance le watcher phpunit
	$(drtest) phptest bin/console cache:clear --env=test
	$(drtest) phptest vendor/bin/phpunit-watcher watch --filter="nothing"

.PHONY: security-check
security-check: vendor/autoload.php ## Check pour les vulnérabilités des dependencies
	$(de) php local-php-security-checker --path=/var/www

.PHONY: validate
validate: vendor/autoload.php ## Génère les migrations
	docker run -v $(PWD):/app -w /app -t --rm php:8.0-cli-alpine php -d memory_limit=-1 bin/console doctrine:schema:validate --skip-sync

.PHONY: drop
drop: vendor/autoload.php ## Génère les migrations
	$(sy) doctrine:database:drop --force

.PHONY: create
create: vendor/autoload.php ## Génère les migrations
	$(sy) doctrine:database:create

.PHONY: container
container: vendor/autoload.php ## Génère les migrations
	docker run -v $(PWD):/app -w /app -t --rm php:8.0-cli-alpine php -d memory_limit=-1 bin/console lint:container

.PHONY: lint
lint: vendor/autoload.php ## Analyse le code
	docker run -v $(PWD):/app -w /app -t --rm php:8.0-cli-alpine php -d memory_limit=-1 bin/console lint:container
	docker run -v $(PWD):/app -w /app -t --rm php:8.0-cli-alpine php -d memory_limit=-1 ./vendor/bin/phpstan analyse
.PHONY: format
format: ## Formate le code
	npx prettier-standard --lint --changed "assets/**/*.{js,css,jsx}"
	docker run -v $(PWD):/app -w /app -t --rm php:8.0-cli-alpine php -d memory_limit=-1 ./vendor/bin/phpcbf
	docker run -v $(PWD):/app -w /app -t --rm php:8.0-cli-alpine php -d memory_limit=-1 ./vendor/bin/php-cs-fixer fix
.PHONY: de
de:
	$(de) php fish
# -----------------------------------
# Dépendances
# -----------------------------------
vendor/autoload.php: composer.lock
	$(php) composer install
	touch vendor/autoload.php

node_modules/time: yarn.lock
	$(node) yarn

public/assets: node_modules/time
	$(node) yarn run build

var/dump:
	mkdir var/dump

public/assets/manifest.json: package.json
	$(node) yarn
	$(node) yarn run build

