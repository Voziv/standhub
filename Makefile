.PHONY: coverage cs fixcs it test build push login
.DEFAULT: build

NAME   := ratehub/credit-score-service
TAG    := $$(git rev-parse --short HEAD)
IMG    := ${NAME}:${TAG}
LATEST := ${NAME}:latest

build:
	@docker build -t ${IMG} .
	@docker tag ${IMG} ${LATEST}

push:
	@docker push ${NAME}

login:
	@docker login -u ${DOCKER_USER} -p ${DOCKER_PASS}

it: cs test

coverage: vendor
	vendor/bin/phpunit --configuration phpunit.xml --coverage-text

cs: vendor
	vendor/bin/phpcs

fixcs: vendor
	vendor/bin/phpcbf

test: vendor
	vendor/bin/phpunit --configuration=phpunit.xml

vendor: composer.json composer.lock
	composer selfupdate
	composer validate
	composer install --no-interaction --prefer-dist
