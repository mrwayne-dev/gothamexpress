<?php $pageTitle = 'Services'; ?>
<?php include_once __DIR__ . '/../../includes/header.php'; ?>

<!-- Hero -->
<section class="hero hero--page">
    <img src="https://images.unsplash.com/photo-1494412574643-ff11b0a5eb19?w=1920&q=80" alt="Shipping containers" class="hero__bg">
    <div class="hero__overlay"></div>
    <div class="hero__content">
        <span class="hero__label"><i class="ph-bold ph-gear-six"></i> Our Services</span>
        <h1 class="hero__title">What We Offer</h1>
        <p class="hero__desc">Comprehensive logistics solutions designed to move your packages across the globe with speed and precision.</p>
    </div>
</section>

<!-- Section 1: Service Cards -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-label">Our Solutions</span>
            <h2 class="section-title">Logistics Services Built For You</h2>
            <p class="section-desc" style="margin: 0 auto;">Whether you need express air delivery or cost-effective ground shipping, we have the right solution for every consignment.</p>
        </div>

        <div class="grid grid--3">
            <div class="card card--bordered">
                <div class="card__icon">
                    <i class="ph-bold ph-airplane-tilt"></i>
                </div>
                <h4 class="card__title">Air Freight</h4>
                <p class="card__text">Priority air shipping for urgent consignments. Packages are transported via our global airline network, reaching any destination within 2-5 business days.</p>
            </div>

            <div class="card card--bordered">
                <div class="card__icon">
                    <i class="ph-bold ph-truck"></i>
                </div>
                <h4 class="card__title">Ground Shipping</h4>
                <p class="card__text">Reliable overland transportation with complete route tracking. Ideal for domestic and regional shipments that need consistent, dependable delivery.</p>
            </div>

            <div class="card card--bordered">
                <div class="card__icon">
                    <i class="ph-bold ph-anchor"></i>
                </div>
                <h4 class="card__title">Sea Freight</h4>
                <p class="card__text">Cost-effective ocean cargo for bulk and oversized shipments. Our sea freight routes connect major ports across every continent.</p>
            </div>

            <div class="card card--bordered">
                <div class="card__icon">
                    <i class="ph-bold ph-package"></i>
                </div>
                <h4 class="card__title">Express Delivery</h4>
                <p class="card__text">Same-day and next-day delivery options for time-critical packages. We prioritize speed without compromising on safety.</p>
            </div>

            <div class="card card--bordered">
                <div class="card__icon">
                    <i class="ph-bold ph-warehouse"></i>
                </div>
                <h4 class="card__title">Warehousing</h4>
                <p class="card__text">Secure storage facilities at strategic locations worldwide. Store your goods safely until they are ready for dispatch.</p>
            </div>

            <div class="card card--bordered">
                <div class="card__icon">
                    <i class="ph-bold ph-chart-line-up"></i>
                </div>
                <h4 class="card__title">Supply Chain</h4>
                <p class="card__text">End-to-end supply chain management. From procurement to final delivery, we optimize every link in your logistics chain.</p>
            </div>
        </div>
    </div>
</section>

<!-- Section 2: Why Choose Us -->
<section class="section section--alt">
    <div class="container">
        <div class="split split--reverse">
            <div class="split__image">
                <video autoplay muted loop playsinline>
                    <source src="/assets/images/sections/animation.mp4" type="video/mp4">
                </video>
            </div>
            <div class="split__content">
                <span class="section-label">Why TruePath</span>
                <h2 class="section-title">Why Customers Choose Us</h2>
                <p>We combine cutting-edge technology with hands-on expertise to deliver a logistics experience that is second to none.</p>
                <div class="feature-list">
                    <div class="feature-list__item">
                        <div class="feature-list__icon">
                            <i class="ph-bold ph-map-pin"></i>
                        </div>
                        <div class="feature-list__text">
                            <h5>Live Package Tracking</h5>
                            <p>Monitor your shipment status at every checkpoint in real-time.</p>
                        </div>
                    </div>
                    <div class="feature-list__item">
                        <div class="feature-list__icon">
                            <i class="ph-bold ph-lock"></i>
                        </div>
                        <div class="feature-list__text">
                            <h5>Secure Handling</h5>
                            <p>Every package is insured and handled by trained professionals.</p>
                        </div>
                    </div>
                    <div class="feature-list__item">
                        <div class="feature-list__icon">
                            <i class="ph-bold ph-currency-dollar"></i>
                        </div>
                        <div class="feature-list__text">
                            <h5>Transparent Pricing</h5>
                            <p>No hidden fees. What you see is what you pay — always.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section 3: CTA -->
<section class="cta">
    <div class="container">
        <h2>Need a Custom Shipping Solution?</h2>
        <p>Contact our logistics team and we'll create a tailored plan for your consignment needs.</p>
        <a href="/contact" class="btn btn--primary btn--lg">
            <i class="ph-bold ph-chat-circle"></i> Contact Us
        </a>
    </div>
</section>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
