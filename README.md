# telegram-authorization-spammer

<img src="https://upload.wikimedia.org/wikipedia/commons/8/82/Telegram_logo.svg" alt="Telegram" width="50"/>

Sending authorization messages to users from Telegram with your domain.
```
%user%, we received a request to log in on %domain% with your Telegram account.

To authorize this request, use the 'Confirm' button below. 

Browser: %user_agent%
IP: %ip% (%location%)

If you didn't request this, use the 'Decline' button or ignore this message.
```

### Install
1. Clone repository
```bash
git clone https://github.com/kagestonedragon/telegram-authorization-spammer.git && cd telegram-authorization-spammer
```
2. Install dependencies via `composer`
```bash
composer install
```
3. Chain your telegram bot with your domain
4. Set up environment variables in `.env`
5. Execute command with `php`
```bash
/usr/bin/php bin/console telegram:authorization_spammer --country_code RU
```

### Options
- `--phones_list` [`-phl`] — path to file with phones list
  - ***default*** — _/resources/phones_list_
- `--user_agents_list` [`-ual`] — path to file with user agents list
  - ***default*** — _/resources/user_agents_list_
- `--proxies_list` [`-prl`]— path to file with proxies list
  - ***default*** — _/resources/proxies_list_
- `--country_code` [`-cc`] — country code (_ISO-3166 Alpha 2_)
- `--logger` [`-l`] — custom logger from config
