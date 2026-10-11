<?php include_once __DIR__ . '/head.php'; ?>

<!-- Navigation -->
<nav class="navbar" id="navbar">
    <div class="navbar__wrapper">
        <div class="container navbar__inner">

            <a href="/" class="navbar__logo">
                <img src="/assets/images/logo/3.png" alt="TruePath Express Logo" class="navbar__logo-img" width="180" height="48">
                <span class="navbar__logo-text">TruePath Express</span>
            </a>

            <ul class="navbar__menu" id="navMenu">
                <li><a href="/about" class="navbar__link <?php echo basename($_SERVER['PHP_SELF']) === 'about.php' ? 'active' : ''; ?>">About</a></li>
                <li><a href="/services" class="navbar__link <?php echo basename($_SERVER['PHP_SELF']) === 'services.php' ? 'active' : ''; ?>">Services</a></li>
                <li><a href="/tracking" class="navbar__link <?php echo basename($_SERVER['PHP_SELF']) === 'tracking.php' ? 'active' : ''; ?>">Tracking</a></li>
                <li><a href="/contact" class="navbar__link <?php echo basename($_SERVER['PHP_SELF']) === 'contact.php' ? 'active' : ''; ?>">Contact</a></li>
                <li class="navbar__cta">
                    <a href="/tracking" class="btn btn--primary btn--sm">Track Package</a>
                </li>
            </ul>

            <button class="navbar__toggle" id="navToggle" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>

        </div>
    </div>
</nav>
