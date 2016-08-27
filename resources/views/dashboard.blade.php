<!DOCTYPE HTML>
<html>
    <head>
    
        <title>@lang('dashboard.page.title')</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="language" content="{{ $language }}" />
        <meta name="rate" content="{{ $rate }}" />
        <!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
        <link rel="stylesheet" href="assets/css/app.css" />
        <!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
        <!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
    
    </head>
    <body>

        <div id="page-wrapper">

            <header id="header">
                <h1><a href="/">@lang('dashboard.page.title')</a></h1>
                <nav>
                    <a href="#menu">@lang('dashboard.label.menu')</a>
                </nav>
            </header>

            <nav id="menu">
                <div class="inner">
                    <h2>@lang('dashboard.label.menu')</h2>
                    <fieldset>
                        <legend>@lang('dashboard.label.rate')</legend>
                        <span class="6u">
                            <input type="radio" id="rate-1m" class="rate-selector" name="rate" value="1">
                            <label for="rate-1m">1 min</label>
                        </span>
                        <span class="6u$">
                            <input type="radio" id="rate-5m" class="rate-selector" name="rate" value="5">
                            <label for="rate-5m">5 min</label>
                        </span>
                        <span class="6u">
                            <input type="radio" id="rate-15m" class="rate-selector" name="rate" value="15">
                            <label for="rate-15m">15 min</label>
                        </span>
                        <span class="6u$">
                            <input type="radio" id="rate-30m" class="rate-selector" name="rate" value="30">
                            <label for="rate-30m">30 min</label>
                        </span>
                    </fieldset>
                    <fieldset>
                        <legend>@lang('dashboard.label.language')</legend>
                        <span class="6u">
                            <input type="radio" id="language-it" class="language-selector" name="language" value="it">
                            <label for="language-it">Italiano</label>
                        </span>
                        <span class="6u$">
                            <input type="radio" id="language-en" class="language-selector" name="language" value="en">
                            <label for="language-en">English</label>
                        </span>
                    </fieldset>
                    <a href="#" class="close">@lang('dashboard.label.close')</a>
                </div>
            </nav>

            <section id="wrapper">
                <div class="wrapper">
                    <div class="inner">
                        <section>
                            <div class="table-wrapper">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>@lang('dashboard.label.date')</th>
                                            <th>@lang('dashboard.label.place')</th>
                                            <th>@lang('dashboard.label.magnitude')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
            </section>

            <section id="footer">
                <div class="inner">
                    <ul class="copyright">
                        <li>&copy; <a href="https://github.com/g4z">g4z</a> 2016 | @lang('dashboard.label.copyright') | @lang('dashboard.label.source') <a href="http://earthquake.usgs.gov/earthquakes/feed/">USGS</a></li>
                    </ul>
                </div>
            </section>

        </div>

    <!-- hello -->
        <script src="assets/js/vendor.js"></script>
        <script src="assets/js/app.js"></script>
        <!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->

    </body>
</html>
