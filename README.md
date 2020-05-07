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

### Refresh strings to VUE translation

```
 php artisan export:messages-flat
```

### Migrate and seed

```
 php artisan migrate
 php artisan migrate:fresh (drop all data)
 php artisan db:seed (add user admin@gamifica.online / admin)
```

## License

FantasyClass is licensed under the [MIT license](https://opensource.org/licenses/MIT).