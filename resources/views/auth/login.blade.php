<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <style>
        /* Bootstrap 5.3 CSS - Inline Version */
        *,::after,::before{box-sizing:border-box}@media (prefers-reduced-motion:no-preference){:root{scroll-behavior:smooth}}body{margin:0;font-family:system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue","Noto Sans","Liberation Sans",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";font-size:1rem;font-weight:400;line-height:1.5;color:#212529;background-color:#fff;-webkit-text-size-adjust:100%;-webkit-tap-highlight-color:transparent}
        .container{width:100%;padding-right:var(--bs-gutter-x,.75rem);padding-left:var(--bs-gutter-x,.75rem);margin-right:auto;margin-left:auto}@media (min-width:576px){.container{max-width:540px}}@media (min-width:768px){.container{max-width:720px}}@media (min-width:992px){.container{max-width:960px}}@media (min-width:1200px){.container{max-width:1140px}}
        .row{--bs-gutter-x:1.5rem;--bs-gutter-y:0;display:flex;flex-wrap:wrap;margin-top:calc(-1 * var(--bs-gutter-y));margin-right:calc(-.5 * var(--bs-gutter-x));margin-left:calc(-.5 * var(--bs-gutter-x))}
        .col-12{flex:0 0 auto;width:100%}.col-md-8{flex:0 0 auto;width:66.66666667%}.col-lg-6{flex:0 0 auto;width:50%}.col-xl-4{flex:0 0 auto;width:33.33333333%}
        @media (min-width:768px){.col-md-8{width:66.66666667%}}@media (min-width:992px){.col-lg-6{width:50%}}@media (min-width:1200px){.col-xl-4{width:33.33333333%}}
        .card{position:relative;display:flex;flex-direction:column;min-width:0;word-wrap:break-word;background-color:#fff;background-clip:border-box;border:1px solid rgba(0,0,0,.125);border-radius:.375rem}
        .card-body{flex:1 1 auto;padding:1rem}
        .form-label{display:inline-block;margin-bottom:.5rem}
        .form-control{display:block;width:100%;padding:.375rem .75rem;font-size:1rem;font-weight:400;line-height:1.5;color:#212529;background-color:#fff;background-clip:padding-box;border:1px solid #ced4da;appearance:none;border-radius:.375rem;transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out}
        .form-control:focus{color:#212529;background-color:#fff;border-color:#86b7fe;outline:0;box-shadow:0 0 0 .25rem rgba(13,110,253,.25)}
        .form-check{display:block;min-height:1.5rem;padding-left:1.5em;margin-bottom:.125rem}
        .form-check-input{width:1em;height:1em;margin-top:.25em;vertical-align:top;background-color:#fff;background-repeat:no-repeat;background-position:center;background-size:contain;border:1px solid rgba(0,0,0,.25);appearance:none;color-adjust:exact}
        .form-check-input[type=checkbox]{border-radius:.25em}
        .form-check-input:checked{background-color:#0d6efd;border-color:#0d6efd}
        .form-check-label{display:inline-block;margin-bottom:0}
        .btn{display:inline-block;font-weight:400;line-height:1.5;color:#212529;text-align:center;text-decoration:none;vertical-align:middle;cursor:pointer;user-select:none;background-color:transparent;border:1px solid transparent;padding:.375rem .75rem;font-size:1rem;border-radius:.375rem;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out}
        .btn-primary{color:#fff;background-color:#0d6efd;border-color:#0d6efd}
        .btn-primary:hover{color:#fff;background-color:#0b5ed7;border-color:#0a58ca}
        .d-flex{display:flex!important}
        .justify-content-center{justify-content:center!important}
        .justify-content-between{justify-content:space-between!important}
        .align-items-center{align-items:center!important}
        .mt-2{margin-top:.5rem!important}.mt-3{margin-top:1rem!important}.mt-4{margin-top:1.5rem!important}
        .mb-2{margin-bottom:.5rem!important}.mb-3{margin-bottom:1rem!important}.mb-4{margin-bottom:1.5rem!important}
        .p-4{padding:1.5rem!important}.p-5{padding:3rem!important}
        .text-center{text-align:center!important}
        .text-decoration-none{text-decoration:none!important}
        .w-100{width:100%!important}
        .shadow-lg{box-shadow:0 1rem 3rem rgba(0,0,0,.175)!important}
        .rounded{border-radius:.375rem!important}
        .invalid-feedback{display:none;width:100%;margin-top:.25rem;font-size:.875em;color:#dc3545}
        .is-invalid~.invalid-feedback{display:block}
        .alert{position:relative;padding:1rem 1rem;margin-bottom:1rem;border:1px solid transparent;border-radius:.375rem}
        .alert-success{color:#0f5132;background-color:#d1e7dd;border-color:#badbcc}

        /* Custom Modern Styles */
        :root {
            --primary-blue: #001f3f;
            --primary-blue-light: #003d7a;
            --primary-blue-dark: #001529;
            --accent-blue: #0074D9;
            --white: #ffffff;
            --light-gray: #f8f9fa;
            --border-color: #e0e7ff;
        }

        body {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-light) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            padding: 2rem 0;
            width: 100%;
        }

        .login-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-header-custom {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--accent-blue) 100%);
            color: var(--white);
            padding: 2.5rem 2rem;
            text-align: center;
            border: none;
        }

        .card-header-custom h2 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .card-header-custom p {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
            font-size: 0.95rem;
        }

        .login-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            backdrop-filter: blur(10px);
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        .login-icon svg {
            width: 40px;
            height: 40px;
            fill: white;
        }

        .form-label {
            color: var(--primary-blue);
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border: 2px solid var(--border-color);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 0.2rem rgba(0, 116, 217, 0.15);
            transform: translateY(-2px);
        }

        .form-check-input {
            border: 2px solid var(--border-color);
            width: 1.2em;
            height: 1.2em;
            margin-top: 0.15em;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: var(--accent-blue);
            border-color: var(--accent-blue);
        }

        .form-check-label {
            color: #6c757d;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--accent-blue) 0%, var(--primary-blue) 100%);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2.5rem;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 116, 217, 0.3);
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 116, 217, 0.4);
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--accent-blue) 100%);
        }

        .forgot-link {
            color: var(--accent-blue);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .forgot-link:hover {
            color: var(--primary-blue);
            text-decoration: underline;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }

        .alert {
            border-radius: 10px;
            border: none;
            padding: 1rem 1.25rem;
            animation: slideDown 0.4s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .divider {
            text-align: center;
            margin: 1.5rem 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--border-color);
        }

        .divider span {
            background: white;
            padding: 0 1rem;
            position: relative;
            color: #6c757d;
            font-size: 0.85rem;
        }

        @media (max-width: 768px) {
            .card-header-custom {
                padding: 2rem 1.5rem;
            }
            
            .card-header-custom h2 {
                font-size: 1.5rem;
            }
            
            .login-icon {
                width: 60px;
                height: 60px;
            }
            
            .login-icon svg {
                width: 30px;
                height: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-4">
                <div class="card login-card">
                    <div class="card-header-custom">
                        <div class="login-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                            </svg>
                        </div>
                        <h2>Welcome Back</h2>
                        <p>Please login to your account</p>
                    </div>
                    
                    <div class="card-body p-4 p-md-5">
                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16" style="margin-right: 5px; vertical-align: text-bottom;">
                                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
                                    </svg>
                                    Email Address
                                </label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Enter your email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16" style="margin-right: 5px; vertical-align: text-bottom;">
                                        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2zM5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/>
                                    </svg>
                                    Password
                                </label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter your password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                                <label class="form-check-label" for="remember_me">
                                    Remember me
                                </label>
                            </div>

                            <!-- Submit Button and Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center">
                                @if (Route::has('password.request'))
                                    <a class="forgot-link" href="{{ route('password.request') }}">
                                        Forgot Password?
                                    </a>
                                @endif

                                <button type="submit" class="btn btn-primary-custom">
                                    Log In
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16" style="margin-left: 5px; vertical-align: text-bottom;">
                                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>