<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>FantasyClass</title>
    <!-- Bulma Version 0.9.0-->
    <link rel="stylesheet" href="https://unpkg.com/bulma@0.9.1/css/bulma.min.css" />
    <link rel="stylesheet" type="text/css" href="/css/home.css" />
    <!-- <link rel="stylesheet" type="text/css" href="/css/app.css" /> -->
    <script src="https://kit.fontawesome.com/90342cb187.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" href="favicon.png" />

    <!-- Mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2, user-scalable=1">



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

</head>

<body>
    <div class="topr lang is-rounded has-background-light has-text-dark" style="width: auto; font-size: 1em">
        <i class="fal fa-globe"></i> <a href="/locale/es">es</a> <i class="fal fa-ellipsis-v"></i> <a href="/locale/ca">ca</a> <i class="fal fa-ellipsis-v"></i> <a href="/locale/en">en</a>
    </div>
    <!-- Begin Preloader -->
    <div class="preloader-wrapper">
        <div class="preloader">
            <img src="img/preloader.gif" alt="" />
        </div>
    </div>
    <!-- End Preloader-->
    <!-- Begin Scroll Up Button -->

    <form action="#home">
        <button id="toTop" title="Go to top">
            <i class="fas fa-angle-up"></i>
        </button>
    </form>
    <!-- End Scroll Up Button -->

    <!-- Begin Header -->
    <div class="header-wrapper pb-0" id="home">
        <!-- Begin Hero -->
        <section class="hero is-medium">
            <!-- End Mobile Nav -->
            <!-- Begin Hero Content-->
            <div class="hero-body">
                <div class="container has-text-centered">
                    <h2 class="title">FantasyClass</h2>
                    <h1 class="subtitle"></h1>
                    <h1 class="subtitle">{{ __('home.subtitle') }}</h1>
                    <h1 class="subtitle">
                        <a class="button" href="/login">
                            <i class="fad fa-unlock mr-2"></i> {{ __('auth.login') }}
                        </a>
                        <a class="button is-link is-light" href="/register">
                            <i class="fad fa-user-plus mr-2"></i> {{ __('auth.register') }}
                        </a>
                    </h1>
                </div>
            </div>
            <!-- End Hero Content-->
            <!-- Begin Hero Menu -->
            <div class="hero-foot ">
                <div class="hero-foot--wrapper">
                    <div class="columns">
                        <div class="column is-12 hero-menu-desktop has-text-centered">
                            <ul>
                                <li class="is-active">
                                    <a href="#home">{{ __('home.start') }}</a>
                                </li>
                                <li>
                                    <a href="#options">{{ __('home.features') }}</a>
                                </li>
                                <li>
                                    <a href="#gamification">{{ __('home.gamification') }}</a>
                                </li>
                                <li>
                                    <a href="#screens">{{ __('home.screenshots') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Hero Menu -->
        </section>
        <!-- End Hero -->
    </div>
    <!-- End Header -->



    <!-- Begin Main Content -->
    <div class="main-content pt-0">
        <!-- Begin Services Content -->
        <div class="section-color services" id="options">
            <div class="container">
                <div class="columns is-multiline">

                    <div class="columns is-12">
                        <div class="column is-4 has-text-centered" data-aos="fade-in" data-aos-easing="linear">
                            <i class="fab fa-telegram fa-3x"></i>
                            <hr />
                            <h2>
                                {!! __('home.feature_telegram') !!} <a class="has-text-light" href="https://t.me/joinchat/G9NbVFS50HGQdHpEaawZkA" target="_blank">Telegram</a>
                            </h2>
                        </div>
                        <div class="column is-4 has-text-centered" data-aos="fade-in" data-aos-easing="linear">
                            <i class="fad fa-euro-sign fa-3x"></i>
                            <hr />
                            <h2>
                                {!! __('home.feature_free') !!}
                            </h2>
                        </div>
                        <div class="column is-4 has-text-centered" data-aos="fade-in" data-aos-easing="linear">
                            <i class="fad fa-code fa-3x"></i>
                            <hr />
                            <h2>
                                {!! __('home.feature_open') !!}
                                <a class="has-text-light" href="https://github.com/climentjoan/fantasyclass" target="_blank">Github</a>
                            </h2>
                        </div>
                    </div>
                    <hr />
                    <div class="columns is-12">
                        <div class="column is-4 has-text-centered" data-aos="fade-in" data-aos-easing="linear">
                            <i class="fad fa-rocket fa-3x"></i>
                            <hr />
                            <h2>
                                {!! __('home.feature_easy') !!}
                            </h2>
                        </div>
                        <div class="column is-4 has-text-centered" data-aos="fade-in" data-aos-easing="linear">
                            <i class="fad fa-gamepad fa-3x"></i>
                            <hr />
                            <h2>
                                {!! __('home.feature_fun') !!}
                            </h2>
                        </div>
                        <div class="column is-4 has-text-centered" data-aos="fade-in" data-aos-easing="linear">
                            <i class="fad fa-brackets-curly fa-3x"></i>
                            <hr />
                            <h2>
                                {!! __('home.feature_changelog') !!}
                                <a class="has-text-light" href="https://github.com/climentjoan/fantasyclass/blob/master/CHANGELOG.md">CHANGELOG</a>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Services Content -->


        <!-- Begin About Me Section -->
        <div class="section-light about-me" id="gamification">
            <div class="container">
                <div class="column is-12 about-me">
                    <h1 class="title has-text-centered section-title">{{ __('home.more') }}</h1>
                </div>
                <div class="columns is-multiline">
                    <div class="column is-6 has-vertically-aligned-content" data-aos="fade-right">
                        <p class="is-larger">
                            <strong>{{ __('home.universe') }}</strong>
                        </p>
                        <br />
                        <p>
                            {{ __('home.universe_text') }}
                        </p>
                        <br />
                        <div class="is-divider"></div>
                        <div class="columns about-links">
                            <div class="column">
                                <p class="heading">
                                    <strong>{{ __('home.activities') }}</strong>
                                </p>
                                <p class="subheading">
                                    {{ __('home.activities_text') }}
                                </p>
                            </div>
                            <div class="column">
                                <p class="heading">
                                    <strong>{{ __('home.classes') }}</strong>
                                </p>
                                <p class="subheading">
                                    {{ __('home.classes_text') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="column is-6 right-image " data-aos="fade-left">
                        <img class="is-rounded" src="/img/home/students.png" alt="" />
                    </div>
                </div>
            </div>
        </div>
        <!-- End About Me Content -->

        <!-- Begin Work Content -->
        <div class="section-dark my-work" id="screens">
            <div class="container">
                <div class="columns is-multiline" data-aos="fade-in" data-aos-easing="linear">
                    <div class="column is-12">
                        <h1 class="title has-text-centered section-title">{{ __('home.screenshots') }}</h1>
                    </div>
                    <div class="column is-6">
                        <figure class="image is-2by1 work-item" style="background-image: url('/img/home/1.png');"></figure>
                    </div>
                    <div class="column is-6">
                        <figure class="image is-2by1 work-item" style="background-image: url('/img/home/2.png');"></figure>
                    </div>
                    <div class="column is-6">
                        <figure class="image is-2by1 work-item" style="background-image: url('/img/home/3.png');"></figure>
                    </div>
                    <div class="column is-6">
                        <figure class="image is-2by1 work-item" style="background-image: url('/img/home/4.png');"></figure>
                    </div>
                    <!-- <div class="column is-6">
                        <figure class="image is-2by1 work-item" style="background-image: url('/img/home/5.png');"></figure>
                    </div>
                    <div class="column is-6">
                        <figure class="image is-2by1 work-item" style="background-image: url('/img/home/6.png');"></figure>
                    </div> -->
                </div>
            </div>
        </div>
        <!-- End Work Content -->
    </div>
    <!-- End Main Content -->

    <!-- Begin Footer -->
    <div class="footer">
        <p>
            FantasyClass 2020
            <a target="_blank" href="https://twitter.com/GamificaOnline"><i class="fab fa-twitter"></i></a>
            <i class="fal fa-ellipsis-v"></i>
            <a target="_blank" href="https://github.com/climentjoan/fantasyclass"><i class="fab fa-github"></i></a>
            <i class="fal fa-ellipsis-v"></i>
            <a target="_blank" href="https://t.me/joinchat/G9NbVFS50HGQdHpEaawZkA"><i class="fab fa-telegram"></i></a>
            <i class="fal fa-ellipsis-v"></i>
            <a target="_blank" href="/policy">Privacy Policy</a>
        </p>
    </div>
    <!-- End Footer -->

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/js/home.js"></script>
    <link href="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.js"></script>
    <script>
        AOS.init({
            easing: "ease-out",
            duration: 800,
        });
    </script>

    <script type="text/javascript">
        // Initialize the service worker
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/serviceworker.js', {
                registrationStrategy: 'registerImmediately',
                scope: '/'
            }).then(function(registration) {
                // Registration was successful
                // console.log('Laravel PWA: ServiceWorker registration successful with scope: ', registration.scope);
            }, function(err) {
                // registration failed :(
                console.log('Laravel PWA: ServiceWorker registration failed: ', err);
            });
        }
    </script>
</body>

</html>