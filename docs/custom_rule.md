## Creating custom rules

The standard set of validation rules may not be enough for you. You can define your rules with [conditional operators](conditions.md).

So, all custom conditions are described through the **custom** rule. You need to put your rules in the **rules** section.

### Examples

#### 1. Branch must be in kebab-case

```yaml
rules:
  custom:
    - definition: "Branch must be in kebab-case"
      rules:
        sourceBranch:
          isKebabCase: true
```

#### 2. Prohibit creating drafts on the "master" branch

```yaml
rules:
  custom:
    - definition: "Drafts disabled on master"
      rules:
        isDraft:
          equals: false
      when:
        targetBranch:
          equals: "master"
```

#### 3. Labels must be in StudlyCase

```yaml
rules:
  custom:
    - definition: "Drafts disabled on master"
      rules:
        labels:
          $all:
            isStudlyCase: true
```

#### 4. A bug fix request must have a list of bug fixes

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
