## Utilities

### To import the project

[Laravel Installation](https://laravel.com/docs/7.x/installation)

Register in [mailtrap.io](https://mailtrap.io)
Configure .env:

``` 
 MAIL_MAILER=smtp
 MAIL_HOST=smtp.mailtrap.io
 MAIL_PORT=2525
 MAIL_USERNAME=
 MAIL_PASSWORD=
 MAIL_ENCRYPTION=null
 MAIL_FROM_ADDRESS=register@gamifica.online
 MAIL_FROM_NAME="${APP_NAME}"
```

To enable Google Login:
Go to https://console.developers.google.com/, register a project and get the Oauth ID and SECRET put them in .env

```
GOOGLE_CLIENT_ID=
GOOGLE_SECRET=
GOOGE_REDIRECT=http://localhost:8000/callback/google
```

## After every pull from the server
```
 php artisan migrate:fresh
 php artisan db:seed
```
These commands will recreate the DB, wipe all the data and create a user admin/admin

### Refresh strings to VUE translation

https://github.com/kg-bot/laravel-localization-to-vue

```
 php artisan export:messages-flat
```

### Plugin documentation

Translation in vue:
https://github.com/kg-bot/laravel-localization-to-vue
https://medium.com/@sumeshvasu/laravel-vuejs-localization-with-package-laravel-localization-to-vue-73a87d2eec78

Toasts:
https://github.com/shakee93/vue-toasted

Popper tippy:
 - Blade: https://github.com/andcarpi/laravel-popper
 - Vue: https://kabbouchi.github.io/vue-tippy/4.0/demo.html

## License

FantasyClass is licensed under the [MIT license](https://opensource.org/licenses/MIT).
