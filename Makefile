# usage as `make try MR_ID=1 TOKEN=aszbdg3htyhtgrfg5h5`
try:
	GITHUB_ACTIONS=1 GITHUB_REPOSITORY=artarts36/php-merge-request-linter GITHUB_GRAPHQL_URL=https://api.github.com/graphql GITHUB_REF_NAME=${MR_ID}/merge MR_LINTER_GITHUB_HTTP_TOKEN=${TOKEN} ./bin/mr-linter lint

docker-build:
	docker build . -t artarts36/merge-request-linter

docker-lint:
	docker run artarts36/merge-request-linter lint

# usage as `make docker-pub-build MR_LINTER_VERSION=0.2.0`
docker-pub-build:
	docker build -f ./dev/docker-pub/Dockerfile . -t artarts36/merge-request-linter:${MR_LINTER_VERSION} --build-arg MR_LINTER_VERSION=${MR_LINTER_VERSION}

# usage as `MR_LINTER_DOCKER_USER=root MR_LINTER_DOCKER_PASSWORD=root make docker-pub-push MR_LINTER_VERSION=0.2.0`
docker-pub-push:
	docker login -u ${MR_LINTER_DOCKER_USER} -p ${MR_LINTER_DOCKER_PASSWORD}
	docker push artarts36/merge-request-linter:${MR_LINTER_VERSION}

# usage as `make docker-pub-try MR_LINTER_VERSION=0.2.0 MR_ID=10 TOKEN=aszbdg3htyhtgrfg5h5`
docker-pub-try:
	docker run \
		-it \
		-e GITHUB_ACTIONS=1 \
		-e GITHUB_REPOSITORY=artarts36/php-merge-request-linter \
		-e GITHUB_GRAPHQL_URL=https://api.github.com/graphql \
		-e GITHUB_REF_NAME=${MR_ID}/merge \
		-e MR_LINTER_GITHUB_HTTP_TOKEN=${TOKEN} \
		-v "${PWD}/.mr-linter.json:/app/.mr-linter.json:ro" \
		artarts36/merge-request-linter:${MR_LINTER_VERSION} lint
