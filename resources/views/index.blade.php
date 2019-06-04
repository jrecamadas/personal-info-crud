<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Full Scale Rocks!</title>
        <meta name="csrf-token" content="{{ csrf_token()  }}">
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
        <link rel="icon" href="{{ asset('images/fs-icon-150x150.png')  }}" size="32x32" />
        <link rel="icon" href="{{ asset('images/fs-icon')  }}" size="192x192" />
        <link rel="stylesheet" type="text/css" href="{{ asset('fonts/line-awesome/css/line-awesome.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('fonts/montserrat/styles.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('fonts/kosmo/styles.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('fonts/weather/css/weather-icons.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/bundle.min.css') . '?r=' . rand()  }}" />
    </head>
    <body class="ks-navbar-fixed ks-sidebar-default ks-sidebar-position-fixed ks-page-header-fixed ks-theme-primary"> <!-- remove ks-page-header-fixed to unfix header -->
        <div id="app">
            <router-view></router-view>
        </div>
        <script src="{{ asset('js/bundle.min.js') . '?r=' . rand() }}"></script>
    </body>
</html>
