<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | TruePath Express</title>

    <link rel="icon" type="image/png" href="/assets/favicon/favicon-32x32.png" sizes="32x32">
    <link rel="shortcut icon" href="/assets/favicon/favicon.ico">

    <!-- Phosphor Icons -->
    <link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/bold/style.css">

    <!-- Main CSS for design tokens -->
    <link rel="stylesheet" href="/assets/css/main.css">

    <style>
        /* Auth page layout */
        .auth {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .auth__form-side {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: var(--space-2xl);
            background-color: var(--color-white);
        }

        .auth__form-wrap {
            width: 100%;
            max-width: 420px;
        }

        .auth__logo {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
            margin-bottom: var(--space-3xl);
            text-decoration: none;
        }

        .auth__logo img {
            height: 36px;
            width: auto;
        }

        .auth__logo span {
            font-size: var(--font-size-xl);
            font-weight: 600;
            color: var(--color-primary);
            letter-spacing: var(--letter-spacing-wide);
        }

        .auth__heading {
            font-size: var(--font-size-3xl);
            color: var(--color-primary);
            margin-bottom: var(--space-sm);
        }

        .auth__subheading {
            font-size: var(--font-size-base);
            color: var(--color-text-light);
            margin-bottom: var(--space-2xl);
        }

        .auth__form .form-group {
            margin-bottom: var(--space-xl);
        }

        .auth__form .form-label {
            font-size: var(--font-size-sm);
            font-weight: 500;
            color: var(--color-text);
            margin-bottom: var(--space-sm);
        }

        .auth__input-wrap {
            position: relative;
        }

        .auth__input-wrap .form-input {
            padding-left: var(--space-2xl);
        }

        .auth__input-wrap .auth__input-icon {
            position: absolute;
            left: var(--space-md);
            top: 50%;
            transform: translateY(-50%);
            color: var(--color-gray-400);
            font-size: var(--font-size-lg);
            pointer-events: none;
        }

        .auth__input-wrap .auth__toggle-pass {
            position: absolute;
            right: var(--space-md);
            top: 50%;
            transform: translateY(-50%);
            color: var(--color-gray-400);
            font-size: var(--font-size-lg);
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
        }

        .auth__input-wrap .auth__toggle-pass:hover {
            color: var(--color-text);
        }

        .auth__form .btn {
            width: 100%;
            padding: var(--space-md) var(--space-xl);
            font-size: var(--font-size-md);
        }

        .auth__links {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: var(--space-xl);
        }

        .auth__links a {
            font-size: var(--font-size-sm);
            color: var(--color-accent);
            transition: color var(--transition-fast);
        }

        .auth__links a:hover {
            color: #E64F00;
        }

        .auth__footer {
            text-align: center;
            margin-top: var(--space-2xl);
            font-size: var(--font-size-sm);
            color: var(--color-text-light);
        }

        .auth__footer a {
            color: var(--color-accent);
            font-weight: 500;
        }

        .auth__footer a:hover {
            color: #E64F00;
        }

        /* Brand side */
        .auth__brand-side {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--color-primary);
            position: relative;
            overflow: hidden;
            padding: var(--space-3xl);
        }

        .auth__brand-side::before {
            content: '';
            position: absolute;
            top: -20%;
            right: -20%;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: var(--color-secondary);
            opacity: 0.15;
        }

        .auth__brand-side::after {
            content: '';
            position: absolute;
            bottom: -15%;
            left: -15%;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: var(--color-accent);
            opacity: 0.08;
        }

        .auth__brand-content {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 400px;
        }

        .auth__brand-icon {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius-xl);
            background: rgba(255, 91, 4, 0.15);
            color: var(--color-accent);
            font-size: 2.5rem;
            margin: 0 auto var(--space-2xl);
        }

        .auth__brand-content h2 {
            color: var(--color-white);
            font-size: var(--font-size-3xl);
            margin-bottom: var(--space-lg);
            line-height: var(--line-height-snug);
        }

        .auth__brand-content p {
            color: var(--color-gray-300);
            font-size: var(--font-size-base);
            line-height: var(--line-height-relaxed);
        }

        /* Error message */
        .auth__error {
            display: none;
            padding: var(--space-md);
            border-radius: var(--radius-md);
            background-color: rgba(146, 20, 12, 0.08);
            border: 1px solid rgba(146, 20, 12, 0.2);
            color: var(--color-crimson);
            font-size: var(--font-size-sm);
            margin-bottom: var(--space-xl);
            align-items: center;
            gap: var(--space-sm);
        }

        .auth__error.show {
            display: flex;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .auth {
                grid-template-columns: 1fr;
            }

            .auth__brand-side {
                display: none;
            }

            .auth__form-side {
                padding: var(--space-xl);
            }
        }

        @media (max-width: 576px) {
            .auth__form-side {
                padding: var(--space-lg);
            }

            .auth__heading {
                font-size: var(--font-size-2xl);
            }
        }
    </style>
</head>
<body>
    <div class="auth">
        <!-- Form Side -->
        <div class="auth__form-side">
            <div class="auth__form-wrap">
                <a href="/" class="auth__logo">
                    <img src="/assets/images/logo/3.png" alt="TruePath Express">
                    <span>TruePath Express</span>
                </a>

                <h1 class="auth__heading">Welcome Back</h1>
                <p class="auth__subheading">Sign in to your admin dashboard</p>

                <div class="auth__error" id="authError">
                    <i class="ph-bold ph-warning-circle"></i>
                    <span id="authErrorMsg"></span>
                </div>

                <form class="auth__form" id="loginForm">
                    <div class="form-group">
                        <label class="form-label" for="email">Email Address</label>
                        <div class="auth__input-wrap">
                            <i class="ph-bold ph-envelope auth__input-icon"></i>
                            <input type="email" id="email" name="email" class="form-input" placeholder="admin@truepathexpress.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <div class="auth__input-wrap">
                            <i class="ph-bold ph-lock auth__input-icon"></i>
                            <input type="password" id="password" name="password" class="form-input" placeholder="Enter your password" required>
                            <button type="button" class="auth__toggle-pass" onclick="togglePassword()">
                                <i class="ph-bold ph-eye" id="passIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="auth__links">
                        <label style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer; font-size: var(--font-size-sm); color: var(--color-text-light);">
                            <input type="checkbox" name="remember" style="accent-color: var(--color-accent);">
                            Remember me
                        </label>
                        <a href="/admin.auth.forgotpassword">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn btn--primary" id="submitBtn">
                        <i class="ph-bold ph-sign-in"></i> Sign In
                    </button>
                </form>

                <div class="auth__footer">
                    Don't have an account? <a href="/admin.auth.register">Create Account</a>
                </div>
            </div>
        </div>

        <!-- Brand Side -->
        <div class="auth__brand-side">
            <div class="auth__brand-content">
                <div class="auth__brand-icon">
                    <i class="ph-bold ph-package"></i>
                </div>
                <h2>Manage Your Shipments With Ease</h2>
                <p>Access your admin dashboard to create packages, track deliveries, and manage transactions all in one place.</p>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <script>
        // Toast notification function
        function showToast(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast toast--${type}`;
            toast.innerHTML = `
                <i class="ph-bold ${type === 'success' ? 'ph-check-circle' : type === 'error' ? 'ph-x-circle' : 'ph-info'}"></i>
                <span>${message}</span>
            `;

            container.appendChild(toast);

            setTimeout(() => toast.classList.add('show'), 10);

            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 400);
            }, 4000);
        }

        function togglePassword() {
            var input = document.getElementById('password');
            var icon = document.getElementById('passIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'ph-bold ph-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'ph-bold ph-eye';
            }
        }

        document.getElementById('loginForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            var btn = document.getElementById('submitBtn');
            var errorBox = document.getElementById('authError');
            var errorMsg = document.getElementById('authErrorMsg');

            btn.disabled = true;
            btn.innerHTML = '<i class="ph-bold ph-spinner"></i> Signing in...';
            errorBox.classList.remove('show');

            try {
                var res = await fetch('/api/auth/login.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        email: document.getElementById('email').value,
                        password: document.getElementById('password').value
                    })
                });

                var data = await res.json();

                if (data.success) {
                    showToast('Login successful! Redirecting to dashboard...', 'success');
                    setTimeout(() => {
                        window.location.href = '/admin.dashboard';
                    }, 1000);
                } else {
                    errorMsg.textContent = data.message || 'Invalid credentials';
                    errorBox.classList.add('show');
                    showToast(data.message || 'Invalid credentials', 'error');
                }
            } catch (err) {
                errorMsg.textContent = 'Connection error. Please try again.';
                errorBox.classList.add('show');
                showToast('Connection error. Please try again.', 'error');
            }

            btn.disabled = false;
            btn.innerHTML = '<i class="ph-bold ph-sign-in"></i> Sign In';
        });
    </script>
</body>
</html>
