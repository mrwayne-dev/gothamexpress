<?php $pageTitle = 'Track Your Package'; ?>
<?php include_once __DIR__ . '/../../includes/header.php'; ?>

<!-- Hero -->
<section class="hero hero--page">
    <img
        src="/assets/images/sections/track-bg.webp"
        srcset="/assets/images/sections/track-bg-480w.webp 480w,
                /assets/images/sections/track-bg-800w.webp 800w,
                /assets/images/sections/track-bg-1200w.webp 1200w,
                /assets/images/sections/track-bg.webp 1920w"
        sizes="100vw"
        alt="Package tracking"
        class="hero__bg"
        width="1920"
        height="1080"
        fetchpriority="high">
    <div class="hero__overlay"></div>
    <div class="hero__content">
        <span class="hero__label"><i class="ph-bold ph-magnifying-glass"></i> Package Tracking</span>
        <h1 class="hero__title">Track Your Package</h1>
        <p class="hero__desc">Enter your tracking ID and email to view the current status of your shipment.</p>
    </div>
</section>

<!-- Tracking Form Section -->
<section class="tracking-section">
    <div class="container">
        <div class="tracking-form">
            <h3 class="tracking-form__title">Enter Your Details</h3>

            <form id="trackingForm">
                <div class="form-group">
                    <label class="form-label" for="trackEmail">Email Address</label>
                    <input type="email" id="trackEmail" name="email" class="form-input" placeholder="e.g. john.doe@example.com" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="trackId">Tracking ID</label>
                    <input type="text" id="trackId" name="tracking_id" class="form-input" placeholder="e.g. TPX-7A3F9B2C" required>
                </div>

                <button type="submit" class="btn btn--primary btn--lg" style="width: 100%;">
                    <i class="ph-bold ph-magnifying-glass"></i> Track Package
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Modals -->
<?php include_once __DIR__ . '/../../includes/payment-modal.php'; ?>
<?php include_once __DIR__ . '/../../includes/track-order-modal.php'; ?>

<script src="/assets/js/payment.js" defer></script>
<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
