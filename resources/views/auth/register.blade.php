<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Modern Blue Theme</title>

    <!-- COPY SEMUA STYLE DARI LOGIN (SAMA PERSIS) -->
    <style>
        /* === Bootstrap Inline CSS (dipertahankan dari login) === */
        *,::after,::before{box-sizing:border-box}
        body{margin:0;font-family:system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif;}

        .container{width:100%;padding-right:.75rem;padding-left:.75rem;margin:auto;}
        @media (min-width:576px){.container{max-width:540px}}
        @media (min-width:768px){.container{max-width:720px}}
        @media (min-width:992px){.container{max-width:960px}}
        @media (min-width:1200px){.container{max-width:1140px}}

        .row{display:flex;flex-wrap:wrap}
        .col-12{width:100%}
        .col-md-8{width:66.6666%}
        .col-lg-6{width:50%}
        .col-xl-4{width:33.3333%}

        .card{background:white;border-radius:.375rem;border:1px solid rgba(0,0,0,.125)}

        /* === CUSTOM STYLES LOGIN (SAMA DENGAN LOGIN) === */
        :root {
            --primary-blue: #001f3f;
            --primary-blue-light: #003d7a;
            --accent-blue: #0074D9;
            --white: #ffffff;
            --border-color: #e0e7ff;
        }

        body {
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-blue-light));
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .login-card {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp .6s ease-out;
        }

        @keyframes slideUp {
            from {opacity: 0; transform: translateY(30px)}
            to   {opacity: 1; transform: translateY(0)}
        }

        .card-header-custom {
            background: linear-gradient(135deg, var(--primary-blue), var(--accent-blue));
            color: white;
            padding: 2.5rem 2rem;
            text-align: center;
        }

        .card-header-custom h2 {font-size: 2rem; margin: 0}
        .card-header-custom p {opacity: .9; margin-top:.5rem}

        .login-icon {
            width: 80px; height: 80px;
            background: rgba(255,255,255,.15);
            border-radius: 50%;
            display: flex; justify-content:center; align-items:center;
            margin: 0 auto 1.5rem;
            border: 3px solid rgba(255,255,255,.3);
            backdrop-filter: blur(8px);
        }

        .form-label {color: var(--primary-blue); font-weight:600}
        .form-control {
            border: 2px solid var(--border-color);
            border-radius: 10px;
            padding: .75rem 1rem;
            transition: .3s;
        }
        .form-control:focus {
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 .2rem rgba(0,116,217,.15);
            transform: translateY(-2px);
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--accent-blue), var(--primary-blue));
            color:white; border:none; border-radius:10px;
            padding:.75rem 2.5rem; font-weight:600;
            box-shadow:0 4px 15px rgba(0,116,217,.3);
            transition:.3s;
        }
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow:0 6px 20px rgba(0,116,217,.4);
        }

        .text-link {
            color: var(--accent-blue);
            text-decoration:none;
            font-weight:500;
        }
        .text-link:hover {
            color: var(--primary-blue);
            text-decoration:underline;
        }
    </style>
</head>

<body>
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-4">

                <div class="card login-card">

                    <!-- HEADER SAMA DENGAN LOGIN -->
                    <div class="card-header-custom">
                        <div class="login-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="white" viewBox="0 0 24 24">
                                <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z"/>
                            </svg>
                        </div>
                        <h2>Create Account</h2>
                        <p>Register to get started</p>
                    </div>

                    <!-- BODY -->
                    <div class="card-body p-4 p-md-5">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name -->
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       name="name" value="{{ old('name') }}" required placeholder="Enter your name">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" required placeholder="Enter your email">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       name="password" required placeholder="Create password">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                       name="password_confirmation" required placeholder="Confirm password">
                                @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Button -->
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <a href="{{ route('login') }}" class="text-link">
                                    Already have an account?
                                </a>

                                <button class="btn btn-primary-custom">
                                    Register
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
