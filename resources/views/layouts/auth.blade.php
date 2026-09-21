<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Login' }} - TERA PT Utama Telekomindo</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --tera-primary: #1d68e1;
            --tera-primary-hover: #1555bd;
            --tera-dark: #0f172a;
            --tera-gray-bg: #f8fafc;
            --tera-border: #e2e8f0;
            --tera-muted: #64748b;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--tera-gray-bg);
            color: var(--tera-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .auth-container {
            width: 100%;
            max-width: 440px;
        }

        .auth-card {
            background: #ffffff;
            border: 1px solid var(--tera-border);
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.06), 0 8px 10px -6px rgba(15, 23, 42, 0.04);
            padding: 2.25rem;
            transition: all 0.2s ease-in-out;
        }

        .brand-logo-text {
            color: var(--tera-primary);
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: 0.06em;
            line-height: 1.1;
        }

        .brand-subtitle {
            font-size: 0.78rem;
            color: var(--tera-muted);
            font-weight: 500;
            letter-spacing: 0.02em;
        }

        .auth-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--tera-dark);
            margin-bottom: 0.35rem;
        }

        .auth-description {
            font-size: 0.85rem;
            color: var(--tera-muted);
            line-height: 1.45;
        }

        .form-label {
            font-size: 0.84rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.4rem;
        }

        .form-control {
            border-radius: 10px;
            border: 1.5px solid var(--tera-border);
            padding: 0.65rem 0.95rem;
            font-size: 0.9rem;
            transition: all 0.15s ease;
        }

        .form-control:focus {
            border-color: var(--tera-primary);
            box-shadow: 0 0 0 4px rgba(29, 104, 225, 0.12);
        }

        .form-control.is-invalid {
            border-color: #ef4444;
            background-image: none;
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.12);
        }

        .input-group-password {
            position: relative;
        }

        .password-toggle-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--tera-muted);
            cursor: pointer;
            padding: 0;
            z-index: 10;
            display: flex;
            align-items: center;
            font-size: 1.1rem;
        }

        .password-toggle-btn:hover {
            color: var(--tera-dark);
        }

        .btn-primary-tera {
            background-color: var(--tera-primary);
            border-color: var(--tera-primary);
            color: #ffffff;
            font-weight: 600;
            font-size: 0.92rem;
            padding: 0.72rem 1.25rem;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .btn-primary-tera:hover, .btn-primary-tera:focus {
            background-color: var(--tera-primary-hover);
            border-color: var(--tera-primary-hover);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(29, 104, 225, 0.25);
        }

        .form-check-input:checked {
            background-color: var(--tera-primary);
            border-color: var(--tera-primary);
        }

        .form-check-label {
            font-size: 0.85rem;
            color: #475569;
            cursor: pointer;
        }

        .auth-link {
            color: var(--tera-primary);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: color 0.15s ease;
        }

        .auth-link:hover {
            color: var(--tera-primary-hover);
            text-decoration: underline;
        }

        .company-footer {
            font-size: 0.78rem;
            color: var(--tera-muted);
            text-align: center;
            margin-top: 1.5rem;
        }
    </style>
    @stack('styles')
</head>
<body>

    <div class="auth-container">
        @yield('content')

        <div class="company-footer">
            &copy; {{ date('Y') }} PT Utama Telekomindo &bull; TERA v1.0
        </div>
    </div>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        // Password visibility toggle handler
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (!input || !icon) return;

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
