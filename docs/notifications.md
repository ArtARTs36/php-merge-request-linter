## Notifications

#### Supported Messengers:
- Telegram (via bot)

#### The following events are currently available for notifications:

| Event         | Description                                                                | Arguments       |
|---------------|----------------------------------------------------------------------------|-----------------|
| lint_started  | The event is created at the moment when the linter has just started        | request         |
| lint_finished | The event is created at the moment when the linter has completed its work. | request, result |

#### Templating

The template engine [twig](https://twig.symfony.com) is used to render the message.

Simple template:
```html
Review on PR "{{ request.title }}"
```

#### Example configuration:

```yaml
notifications:
  channels:
    dev:
      type: 'telegram_bot'
      chat_id: 'env(MR_LINTER_TELEGRAM_CHAT_ID)'
      bot_token: 'env(MR_LINTER_TELEGRAM_BOT_TOKEN)'
  on:
    lint_finished:
      channel: 'dev'
      template: |
        👀 Review on PR "{{ request.title }}" by {{ request.author.login }} at {{ request.createdAt.format('Y-m-d H:i') }}
        
        🌲 {{ request.sourceBranch }} ➡ {{ request.targetBranch }}
        
        🌐 {{ request.uri }}
        
        📉 Notes: {{ result.notes.count }}
        
        {% for note in result.notes %}
        - {{ note.description }}
        {% endfor %}
```

#### Example configuration:

```yaml
notifications:
  channels:
    dev:
      type: 'telegram_bot'
      chat_id: 'env(MR_LINTER_TELEGRAM_CHAT_ID)'
      bot_token: 'env(MR_LINTER_TELEGRAM_BOT_TOKEN)'
  on:
    lint_finished:
      channel: 'dev'
      template: |
        👀 Review on PR "{{ request.title }}" by {{ request.author.login }} at {{ request.createdAt.format('Y-m-d H:i') }}
        
        🌲 {{ request.sourceBranch }} ➡ {{ request.targetBranch }}
        
        🌐 {{ request.uri }}
        
        📉 Notes: {{ result.notes.count }}
        
        {% for note in result.notes %}
        - {{ note.description }}
        {% endfor %}
```

#### Example configuration (only "master"):

```yaml
notifications:
  channels:
    dev:
      type: 'telegram_bot'
      chat_id: 'env(MR_LINTER_TELEGRAM_CHAT_ID)'
      bot_token: 'env(MR_LINTER_TELEGRAM_BOT_TOKEN)'
  on:
    lint_finished:
      channel: 'dev'
      when:
        request.targetBranch:
          equals: "master"
      template: |
        👀 Review on PR "{{ request.title }}" by {{ request.author.login }} at {{ request.createdAt.format('Y-m-d H:i') }}
        
        🌲 {{ request.sourceBranch }} ➡ {{ request.targetBranch }}
        
        🌐 {{ request.uri }}
        
        📉 Notes: {{ result.notes.count }}
        
        {% for note in result.notes %}
        - {{ note.description }}
        {% endfor %}
```
