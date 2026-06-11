<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Galaxy FIFA World Cup Prediction</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;800&family=Barlow:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ── Custom properties ── */
        :root {
            --fifa-navy: #1a1f5e;
            --fifa-navy-dark: #0f1340;
            --fifa-gold: #f5c518;
            --fifa-gold-dark: #c9a000;
        }

        body {
            font-family: 'Barlow', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ── Stadium background ── */
        .bg-stadium {

            background-image: url('/images/st.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            animation: slowZoom 20s ease-in-out infinite alternate;
        }

        @media (max-width: 576px) {
            .bg-stadium {
                background-size: contain;
                /* Shows FULL image instead of cover */
                background-position: center top;
                /* Aligns from top */
                background-repeat: no-repeat;
                background-attachment: scroll;
                background-color: #000000;
                /* Black background for empty areas */
                min-height: 100vh;
                width: 100%;
            }
        }

        @keyframes slowZoom {
            from {
                background-size: 105%;
            }

            to {
                background-size: 112%;
            }
        }

        /* ── Top bar ── */
        .navbar-fifa {
            background: rgba(10, 15, 60, 0.55) !important;
            backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(245, 197, 24, .18);
        }

        .navbar-brand-fifa {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: .04em;
            text-transform: uppercase;
            color: var(--fifa-gold) !important;
        }

        .btn-topbar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, .22);
            background: rgba(255, 255, 255, .08);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background .2s;
        }

        .btn-topbar:hover {
            background: rgba(255, 255, 255, .2);
            color: #fff;
        }

        /* ── Hero text card ── */
        .card-hero {
            background: rgba(15, 20, 75, 0.72);
            border: 1px solid rgba(245, 197, 24, .22);
            backdrop-filter: blur(12px);
            border-radius: 14px;
            color: #fff;
            animation: fadeUp .7s ease both;
        }

        .card-hero h2 {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 800;
            font-size: 2rem;
            text-transform: uppercase;
            letter-spacing: .04em;
            line-height: 1.1;
        }

        .card-hero p {
            font-weight: 300;
            font-size: .9rem;
            line-height: 1.65;
            color: rgba(255, 255, 255, .82);
        }

        /* ── Login card ── */
        .card-login {
            background: rgba(240, 243, 252, .8);
            border-radius: 14px;
            border: none;
            box-shadow: 0 24px 80px rgba(10, 15, 60, .55);
            animation: fadeUp .7s .15s ease both;

        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(22px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-login h1 {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 800;
            font-size: 1.65rem;
            text-transform: uppercase;
            letter-spacing: .04em;
            line-height: 1.15;
            color: var(--fifa-navy);
        }

        /* ── Field labels ── */
        .form-label-fifa {
            font-size: .72rem;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #3d4260;
        }

        /* ── Inputs ── */
        .input-group-fifa .form-control {
            border: 1.5px solid #c4c9d8;
            border-left: none;
            font-family: 'Barlow', sans-serif;
            font-size: .92rem;
            color: #0f1340;
            padding: 10px 14px;
            background: #fff;
            border-radius: 0 8px 8px 0 !important;
        }

        .input-group-fifa .form-control:focus {
            border-color: var(--fifa-navy);
            box-shadow: 0 0 0 3px rgba(26, 31, 94, .12);
        }

        .input-group-fifa .input-group-text {
            background: #fff;
            border: 1.5px solid #c4c9d8;
            border-right: none;
            color: #c4c9d8;
            border-radius: 8px 0 0 8px !important;
        }

        .input-group-fifa .form-control.is-invalid {
            border-color: #f87171;
        }

        .input-group-fifa .btn-toggle-pw {
            border: 1.5px solid #c4c9d8;
            border-left: none;
            background: #fff;
            color: #7a8099;
            border-radius: 0 8px 8px 0 !important;
            padding: 0 12px;
        }

        .input-group-fifa .btn-toggle-pw:hover {
            color: var(--fifa-navy);
        }

        /* ── Remember me ── */
        .form-check-input:checked {
            background-color: var(--fifa-navy);
            border-color: var(--fifa-navy);
        }

        /* ── Forgot link ── */
        .link-forgot {
            font-weight: 600;
            font-size: .88rem;
            color: var(--fifa-navy);
            text-decoration: none;
        }

        .link-forgot:hover {
            color: var(--fifa-gold-dark);
            text-decoration: underline;
        }

        /* ── Login button ── */
        .btn-login-fifa {
            background: var(--fifa-navy);
            color: #fff;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            border: none;
            border-radius: 8px;
            padding: 12px;
            box-shadow: 0 4px 18px rgba(26, 31, 94, .35);
            transition: background .2s, box-shadow .2s, transform .1s;
        }

        .btn-login-fifa:hover {
            background: #252c7a;
            box-shadow: 0 6px 24px rgba(26, 31, 94, .45);
            color: #fff;
        }

        .btn-login-fifa:active {
            transform: translateY(1px);
        }

        .btn-login-fifa:disabled {
            opacity: .65;
        }

        /* ── Register link ── */
        .link-register {
            font-weight: 600;
            color: var(--fifa-navy);
            text-decoration: none;
        }

        .link-register:hover {
            color: var(--fifa-gold-dark);
        }

        /* ── Divider ── */
        .divider-text {
            font-size: .75rem;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: #7a8099;
        }

        /* ── Social buttons ── */
        .btn-social {
            border: 1.5px solid #c4c9d8;
            background: #fff;
            border-radius: 8px;
            width: 56px;
            height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #3d4260;
            text-decoration: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .btn-social:hover {
            border-color: var(--fifa-navy);
            box-shadow: 0 2px 10px rgba(26, 31, 94, .15);
            color: var(--fifa-navy);
        }

        /* ── Footer ── */
        .footer-fifa {
            background: rgba(10, 15, 60, 0.60);
            backdrop-filter: blur(6px);
            border-top: 1px solid rgba(255, 255, 255, .08);
            font-size: .72rem;
            letter-spacing: .05em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .5);
        }

        .footer-fifa a {
            color: rgba(255, 255, 255, .5);
            text-decoration: none;
        }

        .footer-fifa a:hover {
            color: var(--fifa-gold);
        }
    </style>
</head>

<body>

    <!-- ── Page Wrapper ── -->
    <div class="bg-stadium d-flex align-items-center justify-content-center"
        style="padding-top:70px; padding-bottom:60px;">
        <div class="container">
            <div class="row align-items-center justify-content-center g-4">

                <!-- ── Hero Card ── -->
                <div class="col-lg-6 col-md-6 d-none d-md-block">

                </div>

                <!-- ── Login Card ── -->
                <div class="col-lg-4 col-md-5 col-sm-10 col-12">
                    <div class="card-login p-4 p-lg-5">

                        <h1 class="mb-2 text-center">World Cup 2026 • Prediction Game</h1>
                        <h2 class="mb-2 text-center" style="font-size:1.2rem;">Galaxy Bangladesh</h2>
                        <p class="text-black mb-4" style="font-size:.87rem;">
                            Your predictions could put you on top. Log in and let's find out.
                        </p>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="alert alert-success py-2 px-3 mb-3" role="alert" style="font-size:.84rem;">
                                {{ session('status') }}
                            </div>
                        @endif

                        <!-- Validation Errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger py-2 px-3 mb-3" role="alert" style="font-size:.84rem;">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" id="loginForm">
                            @csrf

                            <!-- Email -->
                            <div class="mb-3">
                                {{-- <label for="email" class="form-label form-label-fifa">
                                    <b>Email Address / Employee Code</b>
                                </label> --}}
                                <div class="input-group input-group-fifa">
                                    <span class="input-group-text">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="text" id="email" name="email"
                                        class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                        placeholder="Enter your email/ Employee Code" value="{{ old('email') }}"
                                        required autofocus autocomplete="username">
                                </div>
                                @error('email')
                                    <div class="text-danger mt-1" style="font-size:.78rem;">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                {{-- <label for="password" class="form-label form-label-fifa">Password</label> --}}
                                <div class="input-group input-group-fifa">
                                    <span class="input-group-text">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password" id="password" name="password"
                                        class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                        placeholder="••••••••" required autocomplete="current-password">
                                    <button type="button" class="btn-toggle-pw" id="togglePw"
                                        aria-label="Toggle password">
                                        <i class="bi bi-eye" id="eyeIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="text-danger mt-1" style="font-size:.78rem;">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remember Me + Forgot -->
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember_me" style="font-size:.88rem;">
                                        Remember me
                                    </label>
                                </div>
                                {{-- @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="link-forgot">
                                        Forgot your password?
                                    </a>
                                @endif --}}
                            </div>

                            <!-- Submit -->
                            <button type="submit" class="btn btn-login-fifa w-100 mb-3" id="submitBtn">
                                Log In
                            </button>
                        </form>

                        <!-- Register -->
                        @if (Route::has('register'))
                            <p class="text-center mb-4" style="font-size:.87rem; color:#7a8099;">
                                New to the arena?
                                <a href="{{ route('register') }}" class="link-register">Create account →</a>
                            </p>
                        @endif

                    </div><!-- /card-login -->
                </div>

            </div><!-- /row -->
        </div><!-- /container -->
    </div>

    <!-- ── Footer ── -->
    <footer class="footer-fifa fixed-bottom py-2">
        <div class="d-flex flex-wrap align-items-center justify-content-center gap-3">
            <span>Developed by Information Technology</span>
            <span>Galaxy Bangladesh</span>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Password toggle
        document.getElementById('togglePw').addEventListener('click', function() {
            const pw = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');
            if (pw.type === 'password') {
                pw.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                pw.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        });

        // Disable submit on click
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.textContent = 'Signing in…';
        });
    </script>

</body>

</html>
