<?php $pageTitle = 'Home'; ?>
<?php include_once __DIR__ . '/../../includes/header.php'; ?>

<!-- Hero Section -->
<section class="hero">
    <img
        src="/assets/images/sections/home-bg.webp"
        srcset="/assets/images/sections/home-bg-480w.webp 480w,
                /assets/images/sections/home-bg-800w.webp 800w,
                /assets/images/sections/home-bg-1200w.webp 1200w,
                /assets/images/sections/home-bg.webp 1920w"
        sizes="100vw"
        alt="Logistics"
        class="hero__bg"
        width="1920"
        height="1080"
        fetchpriority="high">
    <div class="hero__overlay"></div>
    <div class="hero__content">
        <span class="hero__label"><i class="ph-bold ph-package"></i> Global Logistics Solutions</span>
        <h1 class="hero__title">Delivering Trust Across Every Mile</h1>
        <p class="hero__desc">Fast, secure, and reliable consignment services worldwide. Track your packages in real-time and experience logistics done right.</p>
        <div class="hero__actions">
            <a href="/tracking" class="btn btn--primary btn--lg">
                <i class="ph-bold ph-magnifying-glass"></i> Track Your Package
            </a>
            <a href="/services" class="btn btn--outline-light btn--lg">
                Our Services
            </a>
        </div>
    </div>
</section>

<!-- Section 1: Stats -->
<section class="section">
    <div class="container">
        <div class="stats-row">
            <div class="stats-row__item">
                <h3 class="stats-row__number">15K+</h3>
                <p class="stats-row__label">Packages Delivered</p>
            </div>
            <div class="stats-row__item">
                <h3 class="stats-row__number">120+</h3>
                <p class="stats-row__label">Countries Served</p>
            </div>
            <div class="stats-row__item">
                <h3 class="stats-row__number">99%</h3>
                <p class="stats-row__label">On-Time Delivery</p>
            </div>
            <div class="stats-row__item">
                <h3 class="stats-row__number">24/7</h3>
                <p class="stats-row__label">Customer Support</p>
            </div>
        </div>
    </div>
</section>

<!-- Section 2: Services Overview -->
<section class="section section--alt">
    <div class="container">
        <div class="section-header">
            <span class="section-label">What We Do</span>
            <h2 class="section-title">Our Core Services</h2>
            <p class="section-desc" style="margin: 0 auto;">End-to-end logistics solutions tailored to your shipping needs, from local deliveries to international freight.</p>
        </div>

        <div class="grid grid--3">
            <div class="card card--bordered">
                <div class="card__icon">
                    <i class="ph-bold ph-airplane-tilt"></i>
                </div>
                <h4 class="card__title">Air Freight</h4>
                <p class="card__text">Express air shipping for time-sensitive consignments. Your packages reach any destination within days.</p>
            </div>

            <div class="card card--bordered">
                <div class="card__icon">
                    <i class="ph-bold ph-truck"></i>
                </div>
                <h4 class="card__title">Ground Shipping</h4>
                <p class="card__text">Reliable ground transportation with full tracking. Cost-effective solutions for domestic and regional deliveries.</p>
            </div>

            <div class="card card--bordered">
                <div class="card__icon">
                    <i class="ph-bold ph-anchor"></i>
                </div>
                <h4 class="card__title">Sea Freight</h4>
                <p class="card__text">Bulk and oversized shipments handled with care. Ocean freight services connecting ports worldwide.</p>
            </div>
        </div>
    </div>
</section>

<!-- Section 3: About Split -->
<section class="section">
    <div class="container">
        <div class="split">
            <div class="split__image">
                <img src="https://images.unsplash.com/photo-1553413077-190dd305871c?w=800&q=80" alt="Warehouse operations">
            </div>
            <div class="split__content">
                <span class="section-label">About Us</span>
                <h2 class="section-title">Trusted Logistics Partner Since Day One</h2>
                <p>TruePath Express is built on a foundation of trust, speed, and accountability. We handle every package as if it were our own, ensuring safe transit from origin to destination.</p>
                <div class="feature-list">
                    <div class="feature-list__item">
                        <div class="feature-list__icon">
                            <i class="ph-bold ph-shield-check"></i>
                        </div>
                        <div class="feature-list__text">
                            <h5>Insured Shipments</h5>
                            <p>Every package is fully insured against loss or damage during transit.</p>
                        </div>
                    </div>
                    <div class="feature-list__item">
                        <div class="feature-list__icon">
                            <i class="ph-bold ph-map-trifold"></i>
                        </div>
                        <div class="feature-list__text">
                            <h5>Real-Time Tracking</h5>
                            <p>Monitor your shipment status at every stage of the delivery process.</p>
                        </div>
                    </div>
                </div>
                <a href="/about" class="btn btn--primary">Learn More</a>
            </div>
        </div>
    </div>
</section>

<!-- Section 4: How It Works -->
<section class="section section--dark">
    <div class="container">
        <div class="section-header">
            <span class="section-label">How It Works</span>
            <h2 class="section-title">Ship In Three Simple Steps</h2>
        </div>

        <div class="process-grid">
            <div class="process-step">
                <div class="process-step__number">1</div>
                <h4 class="process-step__title" style="color: var(--color-white);">Create a Shipment</h4>
                <p class="process-step__text" style="color: var(--color-gray-300);">Provide your package details and destination. Our team processes your request immediately.</p>
            </div>
            <div class="process-step">
                <div class="process-step__number">2</div>
                <h4 class="process-step__title" style="color: var(--color-white);">Make Payment</h4>
                <p class="process-step__text" style="color: var(--color-gray-300);">Secure payment through our platform. Once confirmed, your package enters the transit pipeline.</p>
            </div>
            <div class="process-step">
                <div class="process-step__number">3</div>
                <h4 class="process-step__title" style="color: var(--color-white);">Track & Receive</h4>
                <p class="process-step__text" style="color: var(--color-gray-300);">Track your package in real-time until it arrives safely at your doorstep.</p>
            </div>
        </div>
    </div>
</section>



<!-- Section 5: CTA -->
<section class="cta">
    <div class="container">
        <h2>Ready to Ship With Confidence?</h2>
        <p>Join thousands of satisfied customers who trust TruePath Express for their logistics needs.</p>
        <a href="/tracking" class="btn btn--primary btn--lg">
            <i class="ph-bold ph-package"></i> Get Started Today
        </a>
    </div>
</section>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
