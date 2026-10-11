<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | TruePath Express</title>

    <link rel="icon" type="image/png" href="/assets/favicon/favicon-32x32.png" sizes="32x32">
    <link rel="shortcut icon" href="/assets/favicon/favicon.ico">

    <!-- Phosphor Icons -->
    <link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/bold/style.css">

    <!-- Main CSS for design tokens -->
    <link rel="stylesheet" href="/assets/css/main.css">

    <style>
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

        .auth__icon-box {
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius-lg);
            background: rgba(255, 91, 4, 0.1);
            color: var(--color-accent);
            font-size: 2rem;
            margin-bottom: var(--space-xl);
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
            line-height: var(--line-height-relaxed);
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

        .auth__form .btn {
            width: 100%;
            padding: var(--space-md) var(--space-xl);
            font-size: var(--font-size-md);
        }

        .auth__back {
            display: inline-flex;
            align-items: center;
            gap: var(--space-sm);
            margin-top: var(--space-2xl);
            font-size: var(--font-size-sm);
            color: var(--color-text-light);
            transition: color var(--transition-fast);
        }

        .auth__back:hover {
            color: var(--color-accent);
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

        .auth__success {
            display: none;
            padding: var(--space-md);
            border-radius: var(--radius-md);
            background-color: rgba(10, 122, 66, 0.08);
            border: 1px solid rgba(10, 122, 66, 0.2);
            color: var(--color-success);
            font-size: var(--font-size-sm);
            margin-bottom: var(--space-xl);
            align-items: center;
            gap: var(--space-sm);
        }

        .auth__success.show {
            display: flex;
        }

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

                <div class="auth__icon-box">
                    <i class="ph-bold ph-key"></i>
                </div>

                <h1 class="auth__heading">Forgot Password?</h1>
                <p class="auth__subheading">No worries. Enter your email address and we'll send you a reset link to get back into your account.</p>

                <div class="auth__error" id="authError">
                    <i class="ph-bold ph-warning-circle"></i>
                    <span id="authErrorMsg"></span>
                </div>

                <div class="auth__success" id="authSuccess">
                    <i class="ph-bold ph-check-circle"></i>
                    <span id="authSuccessMsg"></span>
                </div>

                <form class="auth__form" id="forgotForm">
                    <div class="form-group">
                        <label class="form-label" for="email">Email Address</label>
                        <div class="auth__input-wrap">
                            <i class="ph-bold ph-envelope auth__input-icon"></i>
                            <input type="email" id="email" name="email" class="form-input" placeholder="Enter your registered email" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn--primary" id="submitBtn">
                        <i class="ph-bold ph-paper-plane-tilt"></i> Send Reset Link
                    </button>
                </form>

                <a href="/admin.auth.login" class="auth__back">
                    <i class="ph-bold ph-arrow-left"></i> Back to Sign In
                </a>
            </div>
        </div>

        <!-- Brand Side -->
        <div class="auth__brand-side">
            <div class="auth__brand-content">
                <div class="auth__brand-icon">
                    <i class="ph-bold ph-shield-check"></i>
                </div>
                <h2>Account Security First</h2>
                <p>We'll send a secure password reset link to your registered email. The link expires after 1 hour for your protection.</p>
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

        document.getElementById('forgotForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            var btn = document.getElementById('submitBtn');
            var errorBox = document.getElementById('authError');
            var errorMsg = document.getElementById('authErrorMsg');
            var successBox = document.getElementById('authSuccess');
            var successMsg = document.getElementById('authSuccessMsg');

            btn.disabled = true;
            btn.innerHTML = '<i class="ph-bold ph-spinner"></i> Sending...';
            errorBox.classList.remove('show');
            successBox.classList.remove('show');

            try {
                var res = await fetch('/api/auth/forgot-password.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        email: document.getElementById('email').value
                    })
                });

                var data = await res.json();

                if (data.status === 'success' || data.success) {
                    successMsg.textContent = data.message || 'Reset link sent! Check your email inbox.';
                    successBox.classList.add('show');
                    showToast('Password reset link sent! Check your email.', 'success');
                    document.getElementById('forgotForm').reset();
                } else {
                    errorMsg.textContent = data.message || 'Something went wrong';
                    errorBox.classList.add('show');
                    showToast(data.message || 'Something went wrong', 'error');
                }
            } catch (err) {
                errorMsg.textContent = 'Connection error. Please try again.';
                errorBox.classList.add('show');
                showToast('Connection error. Please try again.', 'error');
            }

            btn.disabled = false;
            btn.innerHTML = '<i class="ph-bold ph-paper-plane-tilt"></i> Send Reset Link';
        });
    </script>
</body>
</html>
