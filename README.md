## Contibute

Patreon us!
https://www.patreon.com/join/gamifica

Buy us some beers / coffes :)
https://www.paypal.com/paypalme/gamificaOnline


## Contibutions

Coders
- Joan Climent.
- Jose García (maps)
- Ignacio Salazar (students password and evaluation report). 
- Xavi Franch (profile).

Help and sponsors
- [@laulualalu (logo).](https://instagram.com/laulualalu) 
- [Xavier Climent.](https://twitter.com/xavier_climent) 
- [Jesús Manzaneque.](https://twitter.com/manzanequejesus) 
- Guillermo Guerrero. 
- [Maria Ghirardi (graphics).](http://leideedimari.com/)  
- [Jujo (graphics).](https://twitter.com/soyjujo_juanjo) 
- Carlos.
- [Ander García.](https://aprendecoreano.com/) 
- Isabel Hernández.
- [Kiean Wong (graphics).](https://www.instagram.com/kieanwong.art/)  
- Trini Ardid
- Luis Navarro Rodríguez
- Víctor Corrale
- [Jesús Mínguez Corrales](https://www.instagram.com/teacher_sarraceno/) 
- Francisco Martínez
- [Wity](https://www.facebook.com/oscarflofer) 

## Contribute to the project
### To import the project

[Laravel Installation](https://laravel.com/docs/7.x/installation)

### Requirements

Requirement: php 7.4+
https://docs.spatie.be/laravel-medialibrary/v8/installation-setup/

php-gmp extension

MariaDB +10.2.7 (or mysql with json support)

Register in [mailtrap.io](https://mailtrap.io)

Configure .env:
``` 
 MAIL_MAILER=smtp
 MAIL_HOST=smtp.mailtrap.io
 MAIL_PORT=2525
 MAIL_USERNAME=
 MAIL_PASSWORD=
 MAIL_ENCRYPTION=null
 MAIL_FROM_ADDRESS=register@fantasyclass.app
 MAIL_FROM_NAME="${APP_NAME}"
```

To enable and protect chat:
```
CHAT_KEY=
CHATBRO_KEY=
CHATBRO_ID=
```

To enable Google Login:
Go to https://console.developers.google.com/, register a project and get the Oauth ID and SECRET put them in .env

```
GOOGLE_CLIENT_ID=
GOOGLE_SECRET=
GOOGLE_REDIRECT=http://localhost:8000/callback/google
GOOGLE_APP_ID=
GOOGLE_ANALYTICS=
```

Other settings:

```
# Max students in pagination (IMPORTANT)
MIX_MAX_STUDENTS=40

# To encrypt / decrypt some URL
SECRET_CRYPT=
SECRET_CRYPT_IV=

# To enable notifications
VAPID_PUBLIC_KEY=
VAPID_PRIVATE_KEY=
```

### After every pull from the server
```
 composer install
 npm install
 php artisan migrate
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

### Classroom settings management via VUE

 axios
    .patch("/classroom/" + this.code + "/setting", {
        _method: "patch",
        prop: [ property name ],
        action: "toggle"
    })

axios
    .patch("/classroom/" + this.code + "/setting", {
        _method: "patch",
        prop: [ property name ],
        value: [ property value ],
        action: "update"
    })

### Plugin documentation

Translation in vue:
https://github.com/kg-bot/laravel-localization-to-vue
https://medium.com/@sumeshvasu/laravel-vuejs-localization-with-package-laravel-localization-to-vue-73a87d2eec78

Editor:
https://leecason.github.io/element-tiptap/

Toasts:
https://github.com/Maronato/vue-toastification

Popper tippy:
 - Vue: https://kabbouchi.github.io/vue-tippy/4.0/demo.html

LaravelSettings:
https://github.com/ARCANEDEV/LaravelSettings/blob/master/_docs/3-Usage.md

Vue Croppa:
https://github.com/zhanziyang/vue-croppa

Confetti:
https://github.com/catdad/canvas-confetti

```
import confetti from 'canvas-confetti'
```

Vue-slider-component:
https://github.com/NightCatSama/vue-slider-component

Laravel-excel
https://laravel-excel.com/

Vue-excel
https://github.com/jecovier/vue-json-excel#readme

Google captcha:
https://laravel-recaptcha-docs.biscolab.com/docs/intro

Google API
https://github.com/pulkitjalan/google-apiclient

Fortune wheel
https://github.com/XiaoLin1995/vue-fortune-wheel

Long click
https://github.com/ittus/vue-long-click (not implemented yet)

Web push
https://github.com/laravel-notification-channels/webpush

Chat
https://github.com/antoine92190/vue-advanced-chat

Feedback
https://github.com/IvanSotelo/VueFeedbackReaction

Animations
https://animate.style/

Vue select image
https://github.com/mazipan/vue-select-image

Vue.Draggable
https://github.com/SortableJS/Vue.Draggable

MIME (info)
https://github.com/hhsadiq/laravel-mime-type

Vue-flip
https://github.com/kgrandemange/vue-flip

Timeline
https://github.com/luyilin/vue-cute-timeline

Countdown
https://vac.js.org/

Calendar
https://github.com/antoniandre/vue-cal

vue-keypress
https://github.com/lupas/vue-keypress

wardle / wordle
https://github.com/bpapin19/wardle
https://github.com/yyx990803/vue-wordle

## 3rd party Licenses

- All sprites in "public/img/pets" folder are from habitica (https://habitica.com) with no changes:
https://github.com/HabitRPG/habitica/ and are licensed by: http://creativecommons.org/licenses/by-nc-sa/3.0/

- Google Play and the Google Play logo are trademarks of Google LLC.

## License

FantasyClass is licensed under the [MIT license](https://opensource.org/licenses/MIT).
