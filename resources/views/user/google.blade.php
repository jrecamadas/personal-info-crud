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
        <link rel="stylesheet" href="{{ asset('css/bundle.min.css')  }}" />
    </head>
    <body class="ks-navbar-fixed ks-sidebar-default ks-sidebar-position-fixed ks-page-header-fixed ks-theme-primary"> <!-- remove ks-page-header-fixed to unfix header -->
            @if($isSuccess)
                <script type="text/javascript">
                    localStorage.setItem("auth_token", "{{$accessToken}}");
                    var mainUrl = '/login/google', successPage = '/success';
                    window.location.href = mainUrl + successPage;
                </script>
            @else
                <script type="text/javascript">
                    setTimeout(function() {
                        window.location.href = '/login';
                    }, 3000);
                </script>
                <div style="text-align: center;">
                    <h3>
                        It looks like your <span class="t-blue">G</span><span class="t-red">o</span><span class="t-yellow">o</span><span class="t-blue">g</span><span class="t-green">l</span><span class="t-red">e</span> account is not connected to the system.
                    </h3>
                    <br>
                    <h5>
                        Redirecting you back to <a href="/login">login page</a>...
                    </h5>
                </div>
            @endif

            <style type="text/css">
                .t-red {
                    color: red;
                }
                .t-blue {
                    color: blue;
                } 
                .t-yellow {
                    color: yellow;
                }
                .t-green {
                    color: green;
                }
            </style>
    </body>
</html>
