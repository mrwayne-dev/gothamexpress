<?php $pageTitle = 'About Us'; ?>
<?php include_once __DIR__ . '/../../includes/header.php'; ?>

<!-- Hero -->
<section class="hero hero--page">
    <img
        src="/assets/images/sections/about-bg.webp"
        srcset="/assets/images/sections/about-bg-480w.webp 480w,
                /assets/images/sections/about-bg-800w.webp 800w,
                /assets/images/sections/about-bg-1200w.webp 1200w,
                /assets/images/sections/about-bg.webp 1920w"
        sizes="100vw"
        alt="Logistics fleet"
        class="hero__bg"
        width="1920"
        height="1080"
        fetchpriority="high">
    <div class="hero__overlay"></div>
    <div class="hero__content">
        <span class="hero__label"><i class="ph-bold ph-info"></i> About TruePath Express</span>
        <h1 class="hero__title">Who We Are</h1>
        <p class="hero__desc">A global logistics company committed to delivering excellence, one package at a time.</p>
    </div>
</section>

<!-- Section 1: Our Story -->
<section class="section">
    <div class="container">
        <div class="split">
            <div class="split__image">
                <img src="/assets/images/sections/container.jpg" alt="Company operations">
            </div>
            <div class="split__content">
                <span class="section-label">Our Story</span>
                <h2 class="section-title">Built on Trust, Driven by Speed</h2>
                <p>TruePath Express was founded with a clear mission: to make global shipping accessible, transparent, and reliable. We saw the gaps in the consignment industry — lost packages, unclear tracking, hidden fees — and built a platform that eliminates them all.</p>
                <p>Today, we serve customers in over 120 countries, handling everything from small parcels to large freight shipments with the same level of care and precision.</p>
            </div>
        </div>
    </div>
</section>

<!-- Section 2: Values -->
<section class="section section--alt">
    <div class="container">
        <div class="section-header">
            <span class="section-label">Our Values</span>
            <h2 class="section-title">What Drives Us Forward</h2>
        </div>

        <div class="grid grid--3">
            <div class="card">
                <div class="card__icon">
                    <i class="ph-bold ph-shield-check"></i>
                </div>
                <h4 class="card__title">Integrity</h4>
                <p class="card__text">We handle every shipment with honesty and full transparency. No hidden costs, no surprises — just reliable service you can count on.</p>
            </div>

            <div class="card">
                <div class="card__icon">
                    <i class="ph-bold ph-lightning"></i>
                </div>
                <h4 class="card__title">Speed</h4>
                <p class="card__text">Time matters. Our optimized logistics network ensures your packages move swiftly from origin to destination without unnecessary delays.</p>
            </div>

            <div class="card">
                <div class="card__icon">
                    <i class="ph-bold ph-globe-hemisphere-west"></i>
                </div>
                <h4 class="card__title">Global Reach</h4>
                <p class="card__text">With partners and routes spanning every continent, we deliver wherever you need — from major cities to remote locations worldwide.</p>
            </div>
        </div>
    </div>
</section>

<!-- Section 3: Stats -->
<section class="section section--dark">
    <div class="container">
        <div class="section-header">
            <span class="section-label">By The Numbers</span>
            <h2 class="section-title">Our Impact in Numbers</h2>
        </div>

        <div class="stats-row">
            <div class="stats-row__item">
                <h3 class="stats-row__number">15,000+</h3>
                <p class="stats-row__label">Packages Delivered</p>
            </div>
            <div class="stats-row__item">
                <h3 class="stats-row__number">120+</h3>
                <p class="stats-row__label">Countries Served</p>
            </div>
            <div class="stats-row__item">
                <h3 class="stats-row__number">5,000+</h3>
                <p class="stats-row__label">Happy Customers</p>
            </div>
            <div class="stats-row__item">
                <h3 class="stats-row__number">99.8%</h3>
                <p class="stats-row__label">Satisfaction Rate</p>
            </div>
        </div>
    </div>
</section>

<!-- Section 4: Testimonials -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-label">Testimonials</span>
            <h2 class="section-title">What Our Clients Say</h2>
        </div>

        <div class="testimonials">
            <div class="testimonials__track" id="testimonialsTrack">
                <div class="testimonials__slide">
                    <div class="testimonials__card">
                        <div class="testimonials__stars">
                            <i class="ph-bold ph-star"></i>
                            <i class="ph-bold ph-star"></i>
                            <i class="ph-bold ph-star"></i>
                            <i class="ph-bold ph-star"></i>
                            <i class="ph-bold ph-star"></i>
                        </div>
                        <p class="testimonials__quote">TruePath Express transformed our supply chain completely. Their tracking system is flawless, and every single shipment has arrived on time. I wouldn't trust anyone else with our logistics.</p>
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=120&h=120&fit=crop" alt="James Mitchell" class="testimonials__avatar">
                        <div class="testimonials__name">James Mitchell</div>
                        <div class="testimonials__role">Operations Director, Pinnacle Retail</div>
                    </div>
                </div>

                <div class="testimonials__slide">
                    <div class="testimonials__card">
                        <div class="testimonials__stars">
                            <i class="ph-bold ph-star"></i>
                            <i class="ph-bold ph-star"></i>
                            <i class="ph-bold ph-star"></i>
                            <i class="ph-bold ph-star"></i>
                            <i class="ph-bold ph-star"></i>
                        </div>
                        <p class="testimonials__quote">We ship fragile electronics globally, and TruePath handles them with incredible care. Their real-time tracking gives our customers peace of mind, and their support team is always responsive.</p>
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=120&h=120&fit=crop" alt="Sarah Chen" class="testimonials__avatar">
                        <div class="testimonials__name">Sarah Chen</div>
                        <div class="testimonials__role">CEO, TechWave Electronics</div>
                    </div>
                </div>

                <div class="testimonials__slide">
                    <div class="testimonials__card">
                        <div class="testimonials__stars">
                            <i class="ph-bold ph-star"></i>
                            <i class="ph-bold ph-star"></i>
                            <i class="ph-bold ph-star"></i>
                            <i class="ph-bold ph-star"></i>
                            <i class="ph-bold ph-star"></i>
                        </div>
                        <p class="testimonials__quote">Switching to TruePath was the best logistics decision we've made. The pricing is transparent, delivery times are consistent, and their dashboard makes managing shipments effortless.</p>
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=120&h=120&fit=crop" alt="David Okonkwo" class="testimonials__avatar">
                        <div class="testimonials__name">David Okonkwo</div>
                        <div class="testimonials__role">Founder, Meridian Imports</div>
                    </div>
                </div>

                <div class="testimonials__slide">
                    <div class="testimonials__card">
                        <div class="testimonials__stars">
                            <i class="ph-bold ph-star"></i>
                            <i class="ph-bold ph-star"></i>
                            <i class="ph-bold ph-star"></i>
                            <i class="ph-bold ph-star"></i>
                            <i class="ph-bold ph-star"></i>
                        </div>
                        <p class="testimonials__quote">As a small business, reliable shipping is everything to us. TruePath Express delivers without fail across three continents. Their service level rivals companies ten times their size.</p>
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=120&h=120&fit=crop" alt="Maria Rodriguez" class="testimonials__avatar">
                        <div class="testimonials__name">Maria Rodriguez</div>
                        <div class="testimonials__role">Owner, Brava Artisan Goods</div>
                    </div>
                </div>
            </div>

            <div class="testimonials__nav">
                <button class="testimonials__btn" id="testimonialPrev" aria-label="Previous testimonial">
                    <i class="ph-bold ph-arrow-left"></i>
                </button>
                <div class="testimonials__dots" id="testimonialDots">
                    <button class="testimonials__dot active" data-index="0" aria-label="Go to slide 1"></button>
                    <button class="testimonials__dot" data-index="1" aria-label="Go to slide 2"></button>
                    <button class="testimonials__dot" data-index="2" aria-label="Go to slide 3"></button>
                    <button class="testimonials__dot" data-index="3" aria-label="Go to slide 4"></button>
                </div>
                <button class="testimonials__btn" id="testimonialNext" aria-label="Next testimonial">
                    <i class="ph-bold ph-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta">
    <div class="container">
        <h2>Ready to Experience the TruePath Difference?</h2>
        <p>Ship with confidence knowing your packages are in trusted hands.</p>
        <a href="/contact" class="btn btn--primary btn--lg">
            <i class="ph-bold ph-chat-circle"></i> Get In Touch
        </a>
    </div>
</section>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
