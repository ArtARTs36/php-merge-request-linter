# Comments

You can receive comments on merge request page.

#### Post strategies

| Strategy      | Description                                |
|---------------|--------------------------------------------|
| single        | Each linter run will overwrite one comment |
| single_append | Each linter run append one comment         |
| new           | Each linter run creates a new comment      |

#### Templating

The template engine [Twig](https://twig.symfony.com) is used to render the message.

Simple template:
```html
Review on PR "{{ request.title }}"
```

#### Example configuration:

```yaml
comments:
  strategy: 'single'
  messages:
    - template: |
        I found {{ result.notes.count }} notes in your Pull Request:
        {% for note in result.notes %}
        - {{ note.description | raw }}
        {% endfor %}
```

#### Example configuration (only "master"):

```yaml
comments:
  strategy: 'single'
  messages:
    - template: |
        I found {{ result.notes.count }} notes in your Pull Request:
        {% for note in result.notes %}
        - {{ note.description | raw }}
        {% endfor %}
      when: 
        request.targetBranch: 
          equals: "master"
```

