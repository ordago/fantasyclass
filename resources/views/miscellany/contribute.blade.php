<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'FantasyClass') }}</title>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">

  <!-- Styles -->
  <link media="all" href="{{ mix('css/app.css') }}" rel="stylesheet">

  <!-- Mobile -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2, user-scalable=1">

  <!-- Pace loader -->
  <script src="/js/pace.min.js" defer></script>

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id={{ env('GOOGLE_ANALYTICS') }}"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', "{{ env('GOOGLE_ANALYTICS') }}");
  </script>

  <!-- Cookies -->
  <link media="all" rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css" />


  <!-- PWA -->

  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="manifest" href="/site.webmanifest">
  <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="apple-mobile-web-app-title" content="FantasyClass">
  <meta name="application-name" content="FantasyClass">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">
  <meta name="apple-mobile-web-app-capable" content="yes">

  <style>
    :root {
      --brandColor: hsl(166, 67%, 51%);
      --background: rgb(247, 247, 247);
      --textDark: hsla(0, 0%, 0%, 0.66);
      --textLight: hsla(0, 0%, 0%, 0.33);
    }

    body {
      background: url('/img/contribute.png');
      height: 100vh;
      color: var(--textDark);
      font-size: 2em;
    }

    .field:not(:last-child) {
      margin-bottom: 1rem;
    }

    .register {
      margin-top: 10rem;
      background: white;
      border-radius: 10px;
    }

    .left,
    .right {
      padding: 4.5rem;
    }

    .left {
      border-right: 5px solid var(--background);
    }

    .left .title {
      font-weight: 800;
      letter-spacing: -2px;
    }

    .left .colored {
      color: var(--brandColor);
      font-weight: 500;
      margin-top: 1rem !important;
      letter-spacing: -1px;
    }

    .left p {
      color: var(--textLight);
      font-size: 1.5rem;
    }

    .right .title {
      font-weight: 800;
      letter-spacing: -1px;
    }

    .right .description {
      margin-top: 1rem;
      margin-bottom: 1rem !important;
      color: var(--textLight);
      font-size: 1.5rem;
    }

    .right small {
      color: var(--textLight);
    }

    input {
      font-size: 1rem;
    }

    input:focus {
      border-color: var(--brandColor) !important;
      box-shadow: 0 0 0 1px var(--brandColor) !important;
    }

    .fab,
    .fas {
      color: var(--textLight);
      margin-right: 1rem;
    }
  </style>

</head>

<body>
  <section class="container">
    <div class="columns is-multiline">
      <div class="column is-8 is-offset-2 register">
        <div class="card">
          <header class="card-header p-4 has-text-center has-background-info-light">
            <h3 class="has-text-center is-size-3"><i class="fa fa-smile-beam colored"></i> Nos gusta verte por aquí</h3>
          </header>
          <div class="card-content">
            <div class="content">
              <p class="card-text">Sabemos que cuesta contribuir en proyectos digitales, pero si estás aquí es porque crees que se tiene que valorar el trabajo aunque éste no sea tangible.</p>
              <p class="card-text">¿Para qué será tu aportación? La plataforma tiene gastos mensuales relacionados con el dominio y el alojamiento. Por otra parte, están todas las horas dedicadas al proyecto, que no són pocas ... ¡Y todas las que quedan! Además de servir como inyección de moral
                <i class="fas mx-2 fa-smile-wink colored"></i>
              </p>
              <p class="card-text">Si quieres colaborar y agradecer el trabajo en la plataforma, lo puedes hacer de dos maneras:</p>
              <div>
                <a href="https://www.patreon.com/join/fantasyclass" class="button m-1 is-primary" target="_blank"><i class="fab fa-patreon"></i> Aportación mensual (Sponsors)</a>
                <a href="https://www.paypal.me/gamificaOnline?locale.x=es_ES" class="button m-1 is-primary" target="_blank"><i class="fab fa-paypal"></i> Aportación única</a>
              </div>
              <h3>Colaboradores</h3>
              <div class="columns fs-2 is-multiline">
                <span class="p-2 m-2 is-flex has-all-centered column rounded has-background-info-light">
                  <a href="https://twitter.com/xavier_climent">Xavier Climent</a> <i class="fas mx-2 fa-hand-rock"></i>
                </span>
                <span class="p-2 m-2 is-flex has-all-centered column rounded has-background-info-light">
                  <a href="https://twitter.com/manzanequejesus">Jesús Manzaneque</a> <i class="fas mx-2 fa-hand-spock"></i>
                </span>
                <span class="p-2 m-2 is-flex has-all-centered column rounded has-background-info-light">
                  <i class="fas mx-2 fa-infinity"></i> Guillermo Guerrero <i class="fas mx-2 fa-hand-peace"></i>
                </span>
                <span class="p-2 m-2 is-flex has-all-centered column rounded has-background-info-light">
                  <i class="fas mx-2 fa-palette"></i> <a href="http://leideedimari.com">Maria Ghirardi</a> <i class="fas mx-2 fa-robot"></i> <i class="fas mx-2 fa-skull-crossbones"></i>
                </span>
                <span class="p-2 m-2 is-flex has-all-centered column rounded has-background-info-light">
                  Nacho <i class="fas mx-2 fa-bug"></i> <i class="fas mx-2 fa-laptop-code"></i>
                </span>
                <span class="p-2 m-2 is-flex has-all-centered column rounded has-background-info-light">
                  Carlos<i class="fas mx-2 fa-hand-rock"></i>
                </span>
                <span class="p-2 m-2 is-flex has-all-centered column rounded has-background-info-light">
                  Isabel Hernández <i class="fas mx-2 fa-hand-peace"></i>
                </span>
                <span class="p-2 m-2 is-flex has-all-centered column rounded has-background-info-light">
                  <a  href="https://aprendecoreano.com">Ander García</a> <i class="fas mx-2 fa-hand-spock"></i>
                </span>
                <span class="p-2 m-2 is-flex has-all-centered column rounded has-background-info-light">
                  Trini Ardid <i class="fas mx-2 fa-hand-spock"></i>
                </span>
                <span class="p-2 m-2 is-flex has-all-centered column rounded has-background-info-light">
                  Luis Navarro Rodríguez <i class="fas mx-2 fa-hand-rock"></i>
                </span>
                <span class="p-2 m-2 is-flex has-all-centered column rounded has-background-info-light">
                  <a href="https://www.instagram.com/teacher_sarraceno/">Jesús Mínguez Corrales</a> <i class="fas mx-2 fa-hand-peace"></i>
                </span>
              </div>
            </div>
          </div>
          <footer class=" p-4">
            <p class="has-text-centered is-size-6"><strong>¡Muchísimas gracias por ayudar a que FantasyClass continue adelante!</strong></p>
           
          </footer>
        </div>


        <div class="card-header">
        </div>
        <div class="card-body bg-light text-dark">

        </div>
      </div>
    </div>
  </section>

  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/90342cb187.js" crossorigin="anonymous"></script>

  <!-- <script src="https://h5p.org/sites/all/modules/h5p/library/js/h5p-resizer.js" charset="UTF-8"></script> -->
</body>

</html>
</body>

</html>