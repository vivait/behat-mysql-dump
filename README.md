# Vivait\Behat\Context\DbDump\DbDumpContext

This context will dump a database to a file when a scenario in [Behat](http://behat.org/en/latest/) fails.

The filename will be:

`behat-scenario-failed-{scenarioTitle}-{dateStamp}.sql`

So if you have a scenario that was run:

```
Scenario: A user can perform a search with advanced filtering
```

The filename would be along the lines of:

`behat-scenario-failed-A user can perform a search with advanced filtering-20170124113226.sql`

## Compatibility / Requirements

* PHP 5.6 and above, 7.0 and above

## Installation

`composer require vivait/behat-mysql-dump --dev`

## Usage

Configure Behat by adding the context to your `behat.yml` file

```yml
default:
    suites:
        mysuite:
            contexts:
                - Vivait\Behat\Context\DbDump\DbDumpContext:
                    - 'database_username_here'
                    - 'database_password_here'
                    - 'database_name_here'
                    - '/output/directory/here'
```

If using the [Behat Symfony 2 Extension](https://github.com/Behat/Symfony2Extension) you can use Symfony parameters like so:

```yml
default:
    suites:
        mysuite:
            contexts:
                - Vivait\Behat\Context\DbDump\DbDumpContext:
                    - '%%database_user%%'
                    - '%%database_password%%'
                    - '%%database_name%%'
                    - '%%kernel.root_dir%%/logs'
```

## Contributing

This started as a project internally that we used on some of our projects, if there's new features / ideas you think could be useful please feel free to suggest them, or submit a PR!

Although this project is small, openness and inclusivity are taken seriously. To that end the following code of conduct has been adopted.

[Contributor Code of Conduct](CONTRIBUTING.md)
