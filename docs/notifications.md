# Notifications

#### Supported Messengers:
- Telegram (via bot)

#### The following events are currently available for notifications:

| Event               | Description                                                                | Arguments       |
|---------------------|----------------------------------------------------------------------------|-----------------|
| lint_started        | The event is created at the moment when the linter has just started.       | request         |
| lint_finished       | The event is created at the moment when the linter has completed its work. | request, result |
| rule_was_failed     | The event is created at the moment when the linter rule was failed.        | rule, notes     |
| rule_was_successful | The event is created at the moment when the linter rule was successful.    | rule            |

#### Templating

The template engine [Twig](https://twig.symfony.com) is used to render the message.

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
        👀 Review on PR "{{ request.title | raw }}" by {{ request.author.login }} at {{ request.createdAt.format('Y-m-d H:i') }}
        
        🌲 {{ request.sourceBranch }} ➡ {{ request.targetBranch }}
        
        🌐 {{ request.uri }}
        
        📉 Notes: {{ result.notes.count }}
        
        {% for note in result.notes %}
        - {{ note.description | raw }}
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
        👀 Review on PR "{{ request.title | raw }}" by {{ request.author.login }} at {{ request.createdAt.format('Y-m-d H:i') }}
        
        🌲 {{ request.sourceBranch }} ➡ {{ request.targetBranch }}
        
        🌐 {{ request.uri }}
        
        📉 Notes: {{ result.notes.count }}
        
        {% for note in result.notes %}
        - {{ note.description | raw }}
        {% endfor %}
```

#### Notification Sound

You can enable notification sound for time period.

```yaml
notifications:
  channels:
    dev:
      type: 'telegram_bot'
      chat_id: 'env(MR_LINTER_TELEGRAM_CHAT_ID)'
      bot_token: 'env(MR_LINTER_TELEGRAM_BOT_TOKEN)'
      sound_at: '09:00-21:00'
```
