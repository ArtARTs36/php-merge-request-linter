# usage as `make try MR_ID=1 TOKEN=aszbdg3htyhtgrfg5h5`
try:
	GITHUB_ACTIONS=1 GITHUB_REPOSITORY=artarts36/php-merge-request-linter GITHUB_GRAPHQL_URL=https://api.github.com/graphql GITHUB_REF_NAME=${MR_ID}/merge MR_LINTER_GITHUB_HTTP_TOKEN=${TOKEN} ./bin/mr-linter lint

docker-build:
	docker build . -t artarts36/merge-request-linter

docker-lint:
	docker run artarts36/merge-request-linter lint

# usage as `make docker-pub-build MR_LINTER_VERSION=0.2.0`
docker-pub-build:
	docker build -f ./dev/docker-pub/Dockerfile . -t artarts36/merge-request-linter --build-arg MR_LINTER_VERSION=${MR_LINTER_VERSION}
