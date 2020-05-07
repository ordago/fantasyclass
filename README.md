## Utilities

### To import the project

[Laravel Installation](https://laravel.com/docs/7.x/installation)

Register in [mailtrap.io](https://mailtrap.io)
Configure .env:

` MAIL\_MAILER=smtp
` MAIL\_HOST=smtp.mailtrap.io
` MAIL\_PORT=2525
` MAIL\_USERNAME=
` MAIL\_PASSWORD=
` MAIL\_ENCRYPTION=null
` MAIL\_FROM_ADDRESS=register@gamifica.online
` MAIL\_FROM_NAME="${APP\_NAME}"

### Refresh strings to VUE translation

> php artisan export:messages-flat

### Migrate and seed

> php artisan migrate

> php artisan migrate:fresh (drop all data)

> php artisan db:seed (add user admin@gamifica.online / admin)

## License

FantasyClass is licensed under the [MIT license](https://opensource.org/licenses/MIT).