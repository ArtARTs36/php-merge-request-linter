# Creating custom rules

The standard set of validation rules may not be enough for you. You can define your rules with [conditional operators](conditions.md).

So, all custom conditions are described through the **custom** rule. You need to put your rules in the **rules** section.

## Examples

## 1. Branch must be in kebab-case

Give branches a consistent naming style with this configuration.

```yaml
rules:
  custom:
    - definition: "Branch must be in kebab-case"
      rules:
        sourceBranch:
          isKebabCase: true
```

## 2. Labels must be in StudlyCase

In this configuration, the "$all" keyword means that each label must be in a studly case.

```yaml
rules:
  custom:
    - definition: "Drafts disabled on master"
      rules:
        labels:
          $all:
            isStudlyCase: true
```

## 3. A bug fix request must have a list of bug fixes

This configuration causes a list of fixed bugs to be listed under the 2 level heading.

```yaml
rules:
  custom:
    - definition: "Description must have list of fixed bugs"
      rules:
        descriptionMarkdown:
          containsHeading2: "Fixed"
      when:
        labels:
          has: "Bug"
```
