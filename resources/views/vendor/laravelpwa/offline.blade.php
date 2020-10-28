<!DOCTYPE html>
<html>

<head>
    <title>Offline</title>

    <meta charset="utf-8">

    <!-- Mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2, user-scalable=1">

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

</head>

<body>
    <section class="hero is-info is-fullheight">
        <div class="hero-head">
            </div>

            <div class="hero-body">
                <div class="container has-text-centered">
                    <div class="column is-6 is-offset-3">
                        <h1 class="title">
                            Offline 😢
                        </h1>
                        <h2 class="subtitle">
                            {{ __('offline.connection') }} 
                        </h2>
                        <div class="box">
                            <div class="field has-text-centered">
                                <p class="has-text-centered">
                                    <a class="button" onclick="location.reload()">
                                        🔃 {{ __('offline.try') }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </section>


</html>