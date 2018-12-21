<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Standhub') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:200,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #f7f7f7;
            font-family: 'Roboto', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .content {
            text-align: center;
            background: rgba(0, 0, 0, 0.85);
            box-shadow: #1b1e21 10px 10px 10px;
            padding: 4rem;
        }

        .title {
            font-size: 84px;
        }

        .google-sign-in {
            display: block;
            width: 382px;
            height: 92px;
            background: url('img/signin-assets/web/2x/btn_google_signin_dark_normal_web@2x.png') no-repeat center center;
        }

        .google-sign-in:active {
            background: url('img/signin-assets/web/2x/btn_google_signin_dark_pressed_web@2x.png') no-repeat center center;
        }

        .google-sign-in:focus {
            background: url('img/signin-assets/web/2x/btn_google_signin_dark_focus_web@2x.png') no-repeat center center;
            outline: none;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .splash {
            background: url('/img/splash.jpg');
            background-size: cover;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height splash">
    <div class="content">
        <div class="title m-b-md">
            Standhub
        </div>
        @if (Route::has('google-login'))
            <div>
                <a class="google-sign-in" href="{{ route('google-login') }}"></a>
            </div>
        @endif
    </div>
</div>
</body>
</html>
