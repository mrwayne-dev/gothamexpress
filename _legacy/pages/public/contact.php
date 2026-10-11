<?php $pageTitle = 'Contact Us'; ?>
<?php include_once __DIR__ . '/../../includes/header.php'; ?>

<!-- Hero -->
<section class="hero hero--page">
    <img
        src="/assets/images/sections/contact-bg.webp"
        srcset="/assets/images/sections/contact-bg-480w.webp 480w,
                /assets/images/sections/contact-bg-800w.webp 800w,
                /assets/images/sections/contact-bg-1200w.webp 1200w,
                /assets/images/sections/contact-bg.webp 1920w"
        sizes="100vw"
        alt="Contact us"
        class="hero__bg"
        width="1920"
        height="1080"
        fetchpriority="high">
    <div class="hero__overlay"></div>
    <div class="hero__content">
        <span class="hero__label"><i class="ph-bold ph-chat-circle"></i> Get In Touch</span>
        <h1 class="hero__title">Contact Us</h1>
        <p class="hero__desc">Have questions about your shipment or our services? We're here to help.</p>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section">
    <div class="container">
        <div class="contact-grid">
            <!-- Contact Info -->
            <div>
                <span class="section-label">Reach Out</span>
                <h2 class="section-title">We'd Love to Hear From You</h2>
                <p class="mb-xl" style="color: var(--color-text-light);">Whether you have a question about our services, need help tracking a package, or want to partner with us — our team is ready to assist.</p>

                <div class="contact-info">
                    <div class="contact-info__item">
                        <div class="contact-info__icon">
                            <i class="ph-bold ph-envelope"></i>
                        </div>
                        <div>
                            <h5>Email Us</h5>
                            <p>support@truepathexpress.com</p>
                        </div>
                    </div>

                    <div class="contact-info__item">
                        <div class="contact-info__icon">
                            <i class="ph-bold ph-phone"></i>
                        </div>
                        <div>
                            <h5>Call Us</h5>
                            <p>+1 (800) 555-0199</p>
                        </div>
                    </div>

                    <div class="contact-info__item">
                        <div class="contact-info__icon">
                            <i class="ph-bold ph-map-pin"></i>
                        </div>
                        <div>
                            <h5>Visit Us</h5>
                            <p>2400 Industrial Blvd, Dallas, TX 75207</p>
                        </div>
                    </div>

                    <div class="contact-info__item">
                        <div class="contact-info__icon">
                            <i class="ph-bold ph-clock"></i>
                        </div>
                        <div>
                            <h5>Working Hours</h5>
                            <p>Mon - Fri: 8:00 AM - 6:00 PM (CST)</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div>
                <form id="contactForm" class="card" style="box-shadow: var(--shadow-lg);">
                    <h3 class="mb-xl">Send Us a Message</h3>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="firstname">First Name</label>
                            <input type="text" id="firstname" name="firstname" class="form-input" placeholder="John" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="lastname">Last Name</label>
                            <input type="text" id="lastname" name="lastname" class="form-input" placeholder="Doe" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Email Address</label>
                        <input type="email" id="email" name="email" class="form-input" placeholder="john@example.com" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="inquiry">Inquiry Type</label>
                        <select id="inquiry" name="inquiry" class="form-select" required>
                            <option value="" disabled selected>Select an inquiry type</option>
                            <option value="general">General Inquiry</option>
                            <option value="tracking">Package Tracking</option>
                            <option value="shipping">Shipping Rates</option>
                            <option value="partnership">Partnership</option>
                            <option value="complaint">Complaint</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="message">Message</label>
                        <textarea id="message" name="message" class="form-textarea" placeholder="How can we help you?" required></textarea>
                    </div>

                    <button type="submit" class="btn btn--primary btn--lg" style="width: 100%;">
                        <i class="ph-bold ph-paper-plane-tilt"></i> Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<script src="/assets/js/contact.js" defer></script>
<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
