# PHP Chatbox Widget - Telegram Web Chat Widget

![PHP Version](https://img.shields.io/badge/php-8.4%2B-blue)
![License](https://img.shields.io/badge/license-MIT-green)

This guide walks you through deploying a live chatbox widget on your website that sends messages to your Telegram bot and receives replies in real time all without third-party services.

* * *

## Features

- Works with your own Telegram bot
- Visitors can chat with you directly from your site
- You reply from Telegram, and replies show in the widget
- No database or third-party platform required
- Clean interface and lightweight PHP/JS/HTML stack

* * *

## Prerequisites

- A web server with PHP 7.2+
- HTTPS domain
- A Telegram account
- Basic file access to your server

* * *

### Step 1: Create Your Telegram Bot

1. Open Telegram and start a chat with [@BotFather](https://t.me/BotFather)
2. Type `/start`, then `/newbot`
3. Give your bot a name and a unique username (must end in `bot`)
4. BotFather gives you a **bot token** like:

```
123456789:ABCdefGhIJKlmNoPQRstuVWXyz
```

5. **Save this token** — you'll need it in the next steps.

* * *

### Step 2: Get Your Telegram `chat_id`

To send messages from your site to your Telegram, you need your `chat_id`.

**Do this exactly:**

1. **Temporarily disable any webhook**:

```
https://api.telegram.org/bot<YOUR_BOT_TOKEN>/deleteWebhook
```

2. **Send a message to your bot** in Telegram (e.g., "hello")

3. **Get your chat ID**:
   Visit this URL in your browser:

```
https://api.telegram.org/bot<YOUR_BOT_TOKEN>/getUpdates
```

4. In the JSON response, look for:

```json
"chat": {
  "id": 6878449599,
  "first_name": "YourName",
  ...
}
```

Copy the `id` — that’s your personal `chat_id`

5. **Restore the webhook** (you must do this after):

```
https://api.telegram.org/bot<YOUR_BOT_TOKEN>/setWebhook?url=https://yourdomain.com/chatbox/telegram.php
```

* * *

### Step 3: Upload the Files to Your Server

Upload the following files to a directory like `/chatbox/`:

```
chatbox/
├── bridge.php       # Sends messages to Telegram
├── reply.php        # Returns new replies to browser
├── clear.php        # Deletes reply file after display
├── telegram.php     # Receives Telegram replies (webhook)
├── widget.html      # The chat window UI
├── widget.js        # Loader script to display widget
```

> Example path for WordPress:  
> `/wp-content/themes/your-theme/chatbox/`

* * *

###Step 4: Configure `bridge.php`

Open `bridge.php` and set:

```php
$botToken = 'YOUR_BOT_TOKEN';
$chatId = 'YOUR_CHAT_ID';
```

- `botToken`: from BotFather
- `chatId`: the number you got from `getUpdates`

**Confirm it worked:**

```bash
https://api.telegram.org/bot<YOUR_BOT_TOKEN>/getWebhookInfo
```

You should see:
```json
"url": "https://yourdomain.com/chatbox/telegram.php",
"pending_update_count": 0
```

* * *

### Step 5: Edit widget.html

```html
const chatboxbaseurl = 'https://example.com';
...
const headerColor = config.headerColor || "#6e35c4";
const buttonColor = config.buttonColor || "#6e35c4";
const agentName = config.agentName || "Team Support";
const agentAvatar = config.agentAvatar || "https://yourdomain.com/path/to/avatar.png";
const agentResponseTime = config.agentResponseTime || "Typically replies within few minutes";
window.parent.postMessage({type:"setButtonColor", color:buttonColor}, "*");
...
```

* * *

### Step 6: Embed the Widget in Your Site

In your site’s HTML (e.g., `footer.php`), before `</body>`, add:

```html
<script>window.chatboxbaseurl = 'https://yourdomain.com';</script>
<script src="https://yourdomain.com/chatbox/widget.js"></script>
```

If you want to customize the look or label, edit `widget.js`:

```js
window.chatWidgetConfig = {
  headerColor: '#0078d7',
  buttonColor: '#0078d7',
  agentName: 'Support Team',
  agentAvatar: 'https://yourdomain.com/path-to-avatar.png',
  agentResponseTime: 'Typically replies in 5 minutes',
  chatHtmlUrl: 'https://yourdomain.com/chatbox/widget.html'
};
```

* * *

### How It All Works

| Direction            | File         | Purpose                                 |
|----------------------|--------------|-----------------------------------------|
| Site → Telegram      | `bridge.php` | Sends visitor messages via Telegram API |
| Telegram → Site      | `telegram.php` | Receives replies and stores them      |
| Widget polls reply   | `reply.php`  | Returns stored reply for visitor        |
| Widget clears reply  | `clear.php`  | Deletes the reply once shown            |
| Chat interface       | `widget.html`, `widget.js` | UI and JS polling logic   |

* * *

### Testing

1. Open your website with the widget
2. Start a chat — it should appear in Telegram instantly
3. Reply **by tapping “Reply”** in Telegram or by starting the message with `[ID:xxxxxx]`
4. The message will appear in the visitor’s chat within ~3 seconds

* * *

### Troubleshooting

| Problem                          | Fix                                                                  |
|----------------------------------|----------------------------------------------------------------------|
| `getUpdates` returns nothing     | Run `deleteWebhook` first                                            |
| Replies not showing              | Ensure you reply via Telegram using **Reply** or `[ID:visitorId]`    |
| `reply.json` not created         | Check file permissions and that `telegram.php` is called             |
| Widget doesn’t load              | Check paths to `widget.js` and `widget.html`                         |
| No webhook data arrives          | Check HTTPS and run `setWebhook` correctly                           |

* * *

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/your-feature`).
3. Make your changes and commit them (`git commit -m "Add your feature"`).
4. Push to your branch (`git push origin feature/your-feature`).
5. Open a pull request with a clear description of your changes.

Ensure your code follows PEP 8 style guidelines and includes appropriate tests.

* * *

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

* * *

## Contact

For any issues, suggestions, or questions regarding the project, please open a new issue on the official GitHub repository or reach out directly to the maintainer through the [GitHub Issues](issues) page for further assistance and follow-up.