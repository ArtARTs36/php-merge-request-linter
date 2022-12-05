# usage as `make try MR_ID=1 TOKEN=aszbdg3htyhtgrfg5h5`
try:
	GITHUB_ACTIONS=1 GITHUB_REPOSITORY=artarts36/php-merge-request-linter GITHUB_GRAPHQL_URL=https://api.github.com/graphql GITHUB_REF_NAME=${MR_ID}/merge MR_LINTER_GITHUB_HTTP_TOKEN=${TOKEN} ./bin/mr-linter lint
