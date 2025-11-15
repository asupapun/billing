<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>{{ \App\CPU\translate('admin') }} | {{ \App\CPU\translate('login') }}</title>

    <link rel="shortcut icon" href="{{ asset('assets/admin/img/favicon.png') }}">

    <!-- Correct CSS paths -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/google-fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendor.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/icon-set/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/theme.minc619.css?v=1.0') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/toastr.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/auth-page.css') }}">
</head>

<body class="bg-one-auth">
<main id="content" role="main" class="main">

    @php
        $shop_logo = \App\Models\BusinessSetting::where('key','shop_logo')->value('value') ?? 'default.png';
        $shop_logo_path = asset('storage/app/public/shop/'.$shop_logo);
    @endphp

    <div class="auth-wrapper">

        <!-- LEFT SIDE -->
        <div class="auth-wrapper-left" style="
            background: url('{{ asset('assets/admin/img/auth-bg.png') }}') 
            no-repeat center left/cover;
        ">
            <div class="auth-left-cont">
                <img class="onerror-image"
                     src="{{ onErrorImage($shop_logo, $shop_logo_path, asset('assets/admin/img/160x160/img2.jpg'), 'shop/') }}"
                     alt="{{ \App\CPU\translate('Logo') }}">

                <h2 class="title">
                    <span class="d-block text-primary">{{ \App\CPU\translate('The Ultimate') }}</span>
                    <strong class="color-EC255A">{{ \App\CPU\translate('POS Solution') }}...</strong>
                </h2>
            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div class="auth-wrapper-right">

            <label class="badge badge-soft-danger __login-badge color-EC255A">
                {{ \App\CPU\translate('Software version') }}: {{ env('SOFTWARE_VERSION') }}
            </label>

            <div class="auth-wrapper-form">

                <form class="js-validate" action="{{ route('admin.auth.login') }}" method="post">
                    @csrf

                    <div class="auth-header mb-5">
                        <h2 class="title">{{ \App\CPU\translate('Sign In') }}</h2>
                        <div>{{ \App\CPU\translate('Welcome Back. Login to your panel') }}</div>
                    </div>

                    <div class="js-form-message form-group">
                        <label class="input-label text-capitalize" for="signinSrEmail">
                            {{ \App\CPU\translate('Your email') }}
                        </label>

                        <input type="email" class="form-control form-control-lg"
                               name="email" id="signinSrEmail"
                               placeholder="{{ \App\CPU\translate('email@address.com') }}"
                               required>
                    </div>

                    <div class="js-form-message form-group">
                        <label class="input-label" for="signupSrPassword">
                            {{ \App\CPU\translate('Password') }}
                        </label>

                        <div class="input-group input-group-merge">
                            <input type="password"
                                   class="js-toggle-password form-control form-control-lg"
                                   name="password" id="signupSrPassword"
                                   placeholder="{{ \App\CPU\translate('8+ characters required') }}"
                                   required
                                   data-hs-toggle-password-options='{
                                       "target": "#changePassTarget",
                                       "defaultClass": "tio-hidden-outlined",
                                       "showClass": "tio-visible-outlined",
                                       "classChangeTarget": "#changePassIcon"
                                   }'>

                            <div id="changePassTarget" class="input-group-append">
                                <a class="input-group-text" href="javascript:">
                                    <i id="changePassIcon" class="tio-visible-outlined"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-lg btn-block btn-primary mt-5">
                        {{ \App\CPU\translate('sign_in') }}
                    </button>
                </form>

                @if(env('APP_MODE') == 'demo')
                    <div class="auto-fill-data-copy mt-3">
                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                            <div>
                                <span><strong>Email:</strong> admin@admin.com</span><br>
                                <span><strong>Password:</strong> 12345678</span>
                            </div>
                            <button class="btn action-btn btn--primary m-0 copy_cred">
                                <i class="tio-copy"></i>
                            </button>
                        </div>
                    </div>
                @endif

            </div>
        </div>

    </div>
</main>

<!-- Correct JS paths -->
<script src="{{ asset('assets/admin/js/vendor.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/theme.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/toastr.js') }}"></script>
<script src="{{ asset('assets/admin/js/auth-page.js') }}"></script>

{!! Toastr::message() !!}

@if($errors->any())
    <script>
        @foreach($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    </script>
@endif

</body>
</html>
