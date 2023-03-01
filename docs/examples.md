# Examples of usage

[See examples of custom rules](custom-rule.md#examples)

## Don't forget to include the task number in the request header

Imagine you are a PHPStorm developer at JetBrains, your project in the tracker is called ["WI"](https://youtrack.jetbrains.com/issues/WI).

Then your configuration will be as follows:

```yaml
rules:
  "@mr-linter/title_starts_with_task_number":
    projectName: "WI"
```

## Don't forget to include labels

The simplest example that allows you to set any labels.

```yaml
rules:
  "@mr-linter/has_any_labels": {}
```

You can also specify a list of allowed labels.

```yaml
rules:
  "@mr-linter/has_any_labels_of":
    labels:
      - Feature
      - Bug
      - Docs
      - Tests
      - Optimization
```

## Keep a Changelog

This example shows how to make the changelog update required on the **master** branch.

```yaml
rules:
  "@mr-linter/has_changes":
    - changes:
        - file: "CHANGELOG.MD"
      when:
        targetBranch:
          equals: "master"
```

## Don't forget to update your app version

Imagine that you are a developer of the Laravel framework, with every merge in the **master**, you need to update the application version in the [**Application.php**](https://github.com/laravel/framework/blob/10.x/src/Illuminate/Foundation/Application.php#L41) file. 

To remember to update the **VERSION** constant, use the following configuration.

```yaml
rules:
  "@mr-linter/has_changes":
    - changes:
        - file: "src/Illuminate/Foundation/Application.php"
          updatedPhpConstant: "VERSION"
      when:
        targetBranch:
          equals: "master"
```
