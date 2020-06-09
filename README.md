### To import the project

[Laravel Installation](https://laravel.com/docs/7.x/installation)

### Requirements

Requirement: php 7.4+
https://docs.spatie.be/laravel-medialibrary/v8/installation-setup/

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
 composer update
 php artisan migrate:fresh
 php artisan db:seed
```
These commands will recreate the DB, wipe all the data and create a user admin/admin

### Controller syntax

| Verb      | Path                | Action  | Route Name    |
|-----------|---------------------|---------|---------------|
| GET       | /photo              | index   | photo.index   |
| GET       | /photo/create       | create  | photo.create  |
| POST      | /photo              | store   | photo.store   |
| GET       | /photo/{photo}      | show    | photo.show    |
| GET       | /photo/{photo}/edit | edit    | photo.edit    |
| PUT/PATCH | /photo/{photo}      | update  | photo.update  |
| DELETE    | /photo/{photo}      | destroy | photo.destroy |

### Refresh strings to VUE translation

https://github.com/kg-bot/laravel-localization-to-vue

```
 php artisan export:messages-flat
```

### Classroom settings management vie VUE

 axios
    .patch("/classroom/" + this.code + "/setting", {
        _method: "patch",
        prop: [ property name ],
        action: "toggle"
    })

For now it's only implemented toggle.

### Plugin documentation

Translation in vue:
https://github.com/kg-bot/laravel-localization-to-vue
https://medium.com/@sumeshvasu/laravel-vuejs-localization-with-package-laravel-localization-to-vue-73a87d2eec78

Toasts:
https://github.com/shakee93/vue-toasted

Popper tippy:
 - Vue: https://kabbouchi.github.io/vue-tippy/4.0/demo.html

 LaravelSettings:
 https://github.com/ARCANEDEV/LaravelSettings/blob/master/_docs/3-Usage.md

 Vue Croppa:
 https://github.com/zhanziyang/vue-croppa

## License

FantasyClass is licensed under the [MIT license](https://opensource.org/licenses/MIT).
