## Development

### Pipeline

Our pipeline consists of the following steps:

- **Dependency check** via [ComposerRequireChecker](https://github.com/maglnet/ComposerRequireChecker/)
- **Lint Pull Request**
- **Check code style** via [PHP CS Fixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer)
- **Static Analyse** via [PHPStan](https://github.com/phpstan/phpstan)
- **Check architecture** via [Deptrac](https://github.com/qossmic/deptrac)
- **Run tests** via [PHPUnit](https://github.com/sebastianbergmann/phpunit)

### Development Commands

| Command                  | Description                                          |
|--------------------------|------------------------------------------------------|
| composer test            | Run tests (via PHPUnit)                              |
| composer lint            | Run lint (via PHPCsFixer)                            |
| composer deptrac         | Run deptrac                                          |
| make deps-check          | Check composer requires (via ComposerRequireChecker) |
| make check               | Run test, lint, stat-analyse, deptrac                |
| make docs                | Build docs (rule page, Config JSON Schema)           |
| make env                 | Add .env file                                        |
| make try MR_ID=10        | Run MR-Linter on really pull request                 |
| make try-gitlab MR_ID=10 | Run MR-Linter on really merge request                |
