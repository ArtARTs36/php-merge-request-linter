ifneq ("$(wildcard .env)","")
	include .env
	export
endif

.PHONY: docs

env:
	echo "MR_LINTER_GITHUB_HTTP_TOKEN=token\nMR_LINTER_GITLAB_HTTP_TOKEN=token\n" > .env
	echo "E2E_MR_LINTER_GITHUB_HTTP_TOKEN=token\nE2E_MR_LINTER_GITLAB_HTTP_TOKEN=token" >> .env
	echo "E2E_MR_LINTER_BITBUCKET_APP_USER=token\nE2E_MR_LINTER_BITBUCKET_APP_PASSWORD=token\n" >> .env

# usage as `make try MR_ID=1`
try:
	GITHUB_ACTIONS=1 \
	GITHUB_REPOSITORY=artarts36/php-merge-request-linter \
	GITHUB_GRAPHQL_URL=https://api.github.com/graphql \
	GITHUB_REF_NAME=${MR_ID}/merge \
	./bin/mr-linter lint --debug --metrics

# usage as `make try-phar MR_ID=1`
try-phar: build-phar
	GITHUB_ACTIONS=1 \
	GITHUB_REPOSITORY=artarts36/php-merge-request-linter \
	GITHUB_GRAPHQL_URL=https://api.github.com/graphql \
	GITHUB_REF_NAME=${MR_ID}/merge \
	./bin/build/mr-linter.phar lint --debug --metrics

# usage as `make try MR_ID=1`
try-docker: docker-build
	docker run \
		--env-file .env \
		--env GITHUB_ACTIONS=1 \
		--env GITHUB_REPOSITORY=artarts36/php-merge-request-linter \
		--env GITHUB_GRAPHQL_URL=https://api.github.com/graphql \
		--env GITHUB_REF_NAME=${MR_ID}/merge \
		artarts36/merge-request-linter:testing "lint" --debug --metrics

# usage as `make try-gitlab MR_ID=1`
try-gitlab:
	GITLAB_CI=1 \
	CI_MERGE_REQUEST_IID=${MR_ID} \
	CI_MERGE_REQUEST_PROJECT_ID=41749211 \
	CI_SERVER_URL=https://gitlab.com \
 	./bin/mr-linter lint --debug --metrics

# usage as `make try-bitbucket MR_ID=2`
try-bitbucket:
	BITBUCKET_PROJECT_KEY=ArtARTs36 \
	BITBUCKET_PR_ID=${MR_ID} \
	BITBUCKET_WORKSPACE=ArtARTs36 \
	BITBUCKET_REPO_SLUG=test-repo \
 	./bin/mr-linter lint --debug --metrics

docker-build:
	docker build . -t artarts36/merge-request-linter:testing

docker-lint: docker-build
	docker run artarts36/merge-request-linter lint

# usage as `make docker-pub-build MR_LINTER_VERSION=0.2.0`
docker-pub-build:
	docker build -f ./dev/docker-pub/Dockerfile . -t artarts36/merge-request-linter:${MR_LINTER_VERSION} --build-arg MR_LINTER_VERSION=${MR_LINTER_VERSION}

# usage as `MR_LINTER_DOCKER_USER=root MR_LINTER_DOCKER_PASSWORD=root make docker-pub-push MR_LINTER_VERSION=0.2.0`
docker-pub-push:
	@docker login -u ${MR_LINTER_DOCKER_USER} -p ${MR_LINTER_DOCKER_PASSWORD}
	docker push artarts36/merge-request-linter:${MR_LINTER_VERSION}

# usage as `MR_LINTER_DOCKER_USER=root MR_LINTER_DOCKER_PASSWORD=root make docker-pub-push-as-latest MR_LINTER_VERSION=0.2.0`
docker-pub-push-as-latest:
	@docker login -u ${MR_LINTER_DOCKER_USER} -p ${MR_LINTER_DOCKER_PASSWORD}
	docker tag artarts36/merge-request-linter:${MR_LINTER_VERSION} artarts36/merge-request-linter:latest
	docker push artarts36/merge-request-linter:latest

# usage as `make docker-pub-try MR_LINTER_VERSION=0.2.0 MR_ID=10 TOKEN=aszbdg3htyhtgrfg5h5`
docker-pub-try:
	docker run \
		-it \
		-e GITHUB_ACTIONS=1 \
		-e GITHUB_REPOSITORY=artarts36/php-merge-request-linter \
		-e GITHUB_GRAPHQL_URL=https://api.github.com/graphql \
		-e GITHUB_REF_NAME=${MR_ID}/merge \
		-e MR_LINTER_GITHUB_HTTP_TOKEN=${TOKEN} \
		-v "${PWD}/.mr-linter.yml:/app/.mr-linter.yml:ro" \
		artarts36/merge-request-linter:${MR_LINTER_VERSION} lint

docs:
	php docs/Builder/build_rules.php
	php docs/Builder/build_config_json_schema.php
	php docs/Builder/build_conditions.php

docs-docker: docker-build
	docker run \
		--rm \
		--volume ./:/app \
		--env-file .env \
		--entrypoint "make" \
		artarts36/merge-request-linter:testing "docs"

deps-check:
	@test -f composer-require-checker.phar || wget \
		https://github.com/maglnet/ComposerRequireChecker/releases/latest/download/composer-require-checker.phar -O composer-require-checker.phar && \
		chmod +x composer-require-checker.phar
	./composer-require-checker.phar check --config-file=${PWD}/composer-require-checker.json composer.json --verbose

check: deps-check
	composer lint
	composer stat-analyse
	composer deptrac
	composer test

info:
	./bin/mr-linter info

dump:
	./bin/mr-linter dump

dump-docker: docker-build
	docker run \
		--volume ./:/app \
		--entrypoint "make" \
		artarts36/merge-request-linter:testing "dump"

push-docs:
	php ./vendor/bin/docs-retriever

lint-docker: docker-build
	docker run \
		--env-file .env \
		--entrypoint "composer" \
		artarts36/merge-request-linter:testing "lint"

lint-fix-docker: docker-build
	docker run \
		--rm \
		--volume ./:/app/ \
		--env-file .env \
		--entrypoint "composer" \
		artarts36/merge-request-linter:testing "lint-fix"

stat-analyse-docker: docker-build
	docker run \
		--rm \
		--env-file .env \
		--entrypoint "composer" \
		artarts36/merge-request-linter:testing "stat-analyse"

test-e2e:
	composer test-e2e

test-e2e-docker: docker-build
	docker run \
		--env-file .env \
		--entrypoint "composer" \
		artarts36/merge-request-linter:testing "test-e2e"

test-docker: docker-build
	docker run \
		--volume ./:/app/ \
		--env-file .env \
		--entrypoint "composer" \
		artarts36/merge-request-linter:testing "test"

deptrac-docker: docker-build
	docker run \
		--env-file .env \
		--entrypoint "composer" \
		artarts36/merge-request-linter:testing "deptrac"

check-docker: lint-docker stat-analyse-docker test-docker deptrac-docker

build-phar:
	composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader
	cd dev/build/ && composer install
	./dev/build/vendor/bin/box compile
