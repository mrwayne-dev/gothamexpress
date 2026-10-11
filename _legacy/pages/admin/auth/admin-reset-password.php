<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | TruePath Express</title>

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
            background: rgba(7, 80, 86, 0.1);
            color: var(--color-secondary);
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
            padding-right: var(--space-3xl);
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

        .auth__input-wrap .auth__toggle-password {
            position: absolute;
            right: var(--space-md);
            top: 50%;
            transform: translateY(-50%);
            color: var(--color-gray-400);
            font-size: var(--font-size-lg);
            cursor: pointer;
            transition: color var(--transition-fast);
        }

        .auth__input-wrap .auth__toggle-password:hover {
            color: var(--color-text);
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
            background: rgba(7, 80, 86, 0.2);
            color: var(--color-secondary);
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
                    <i class="ph-bold ph-lock-key"></i>
                </div>

                <h1 class="auth__heading">Reset Password</h1>
                <p class="auth__subheading">Enter your new password below. Make sure it's at least 8 characters long and secure.</p>

                <div class="auth__error" id="authError">
                    <i class="ph-bold ph-warning-circle"></i>
                    <span id="authErrorMsg"></span>
                </div>

                <div class="auth__success" id="authSuccess">
                    <i class="ph-bold ph-check-circle"></i>
                    <span id="authSuccessMsg"></span>
                </div>

                <form class="auth__form" id="resetForm">
                    <input type="hidden" id="token" name="token">

                    <div class="form-group">
                        <label class="form-label" for="password">New Password</label>
                        <div class="auth__input-wrap">
                            <i class="ph-bold ph-lock auth__input-icon"></i>
                            <input type="password" id="password" name="password" class="form-input" placeholder="Enter new password" required minlength="8">
                            <i class="ph-bold ph-eye auth__toggle-password" id="togglePassword" data-target="password"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="confirmPassword">Confirm Password</label>
                        <div class="auth__input-wrap">
                            <i class="ph-bold ph-lock auth__input-icon"></i>
                            <input type="password" id="confirmPassword" name="confirmPassword" class="form-input" placeholder="Confirm new password" required minlength="8">
                            <i class="ph-bold ph-eye auth__toggle-password" id="toggleConfirmPassword" data-target="confirmPassword"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn btn--primary" id="submitBtn">
                        <i class="ph-bold ph-check-circle"></i> Reset Password
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
                <h2>Secure Password Reset</h2>
                <p>Create a strong password to protect your admin account. We recommend using a mix of letters, numbers, and special characters.</p>
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

        // Extract token from URL on page load
        const urlParams = new URLSearchParams(window.location.search);
        const token = urlParams.get('token');
        const errorBox = document.getElementById('authError');
        const errorMsg = document.getElementById('authErrorMsg');

        // Validate token exists
        if (!token) {
            errorMsg.textContent = 'Invalid reset link. No token provided.';
            errorBox.classList.add('show');
            showToast('Invalid reset link. No token provided.', 'error');
            document.getElementById('submitBtn').disabled = true;
        } else {
            document.getElementById('token').value = token;
        }

        // Password visibility toggle
        document.getElementById('togglePassword').addEventListener('click', function() {
            const input = document.getElementById('password');
            if (input.type === 'password') {
                input.type = 'text';
                this.classList.remove('ph-eye');
                this.classList.add('ph-eye-slash');
            } else {
                input.type = 'password';
                this.classList.remove('ph-eye-slash');
                this.classList.add('ph-eye');
            }
        });

        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const input = document.getElementById('confirmPassword');
            if (input.type === 'password') {
                input.type = 'text';
                this.classList.remove('ph-eye');
                this.classList.add('ph-eye-slash');
            } else {
                input.type = 'password';
                this.classList.remove('ph-eye-slash');
                this.classList.add('ph-eye');
            }
        });

        // Form submission
        document.getElementById('resetForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const btn = document.getElementById('submitBtn');
            const successBox = document.getElementById('authSuccess');
            const successMsg = document.getElementById('authSuccessMsg');
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            btn.disabled = true;
            btn.innerHTML = '<i class="ph-bold ph-spinner"></i> Resetting...';
            errorBox.classList.remove('show');
            successBox.classList.remove('show');

            // Validate passwords match
            if (password !== confirmPassword) {
                errorMsg.textContent = 'Passwords do not match. Please try again.';
                errorBox.classList.add('show');
                showToast('Passwords do not match. Please try again.', 'error');
                btn.disabled = false;
                btn.innerHTML = '<i class="ph-bold ph-check-circle"></i> Reset Password';
                return;
            }

            // Validate password length
            if (password.length < 8) {
                errorMsg.textContent = 'Password must be at least 8 characters long.';
                errorBox.classList.add('show');
                showToast('Password must be at least 8 characters long.', 'error');
                btn.disabled = false;
                btn.innerHTML = '<i class="ph-bold ph-check-circle"></i> Reset Password';
                return;
            }

            try {
                const res = await fetch('/api/auth/reset-password.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        token: token,
                        password: password
                    })
                });

                const data = await res.json();

                if (data.status === 'success') {
                    successMsg.textContent = data.message || 'Password reset successful! Redirecting to login...';
                    successBox.classList.add('show');
                    showToast('Password reset successful! Redirecting to login...', 'success');
                    document.getElementById('resetForm').reset();

                    // Redirect to login after 3 seconds
                    setTimeout(function() {
                        window.location.href = '/admin.auth.login';
                    }, 3000);
                } else {
                    errorMsg.textContent = data.message || 'Password reset failed. Please try again.';
                    errorBox.classList.add('show');
                    showToast(data.message || 'Password reset failed. Please try again.', 'error');
                    btn.disabled = false;
                    btn.innerHTML = '<i class="ph-bold ph-check-circle"></i> Reset Password';
                }
            } catch (err) {
                errorMsg.textContent = 'Connection error. Please try again.';
                errorBox.classList.add('show');
                showToast('Connection error. Please try again.', 'error');
                btn.disabled = false;
                btn.innerHTML = '<i class="ph-bold ph-check-circle"></i> Reset Password';
            }
        });
    </script>
</body>
</html>
