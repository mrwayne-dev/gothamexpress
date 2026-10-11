/**
 * TruePath Express - Main JS
 * Handles: loader, navbar, mobile menu, modals, toasts, animations
 */

// ===========================
// Throttle Helper Function
// ===========================
function throttle(func, wait) {
    var timeout;
    return function() {
        var context = this, args = arguments;
        if (!timeout) {
            timeout = setTimeout(function() {
                timeout = null;
                func.apply(context, args);
            }, wait);
        }
    };
}

document.addEventListener('DOMContentLoaded', function () {

    // ===========================
    // Page Loader
    // ===========================
    const loader = document.getElementById('pageLoader');
    if (loader) {
        window.addEventListener('load', function () {
            loader.classList.add('hidden');
            setTimeout(function () {
                loader.style.display = 'none';
            }, 500);
        });
        // Fallback: hide after 3s even if load event already fired
        setTimeout(function () {
            loader.classList.add('hidden');
        }, 3000);
    }

    // ===========================
    // Navbar Scroll (Throttled for Performance)
    // ===========================
    const navbar = document.getElementById('navbar');
    if (navbar) {
        window.addEventListener('scroll', throttle(function () {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }, 100)); // Fire max once per 100ms
    }

    // ===========================
    // Mobile Menu Toggle
    // ===========================
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');
    if (navToggle && navMenu) {
        navToggle.addEventListener('click', function () {
            navToggle.classList.toggle('active');
            navMenu.classList.toggle('open');
            // Lock/unlock body scroll
            document.body.classList.toggle('menu-open');
        });

        // Close menu on link click
        navMenu.querySelectorAll('.navbar__link').forEach(function (link) {
            link.addEventListener('click', function () {
                navToggle.classList.remove('active');
                navMenu.classList.remove('open');
                document.body.classList.remove('menu-open');
            });
        });

        // Close menu on CTA button click
        const ctaBtn = navMenu.querySelector('.navbar__cta .btn');
        if (ctaBtn) {
            ctaBtn.addEventListener('click', function () {
                navToggle.classList.remove('active');
                navMenu.classList.remove('open');
                document.body.classList.remove('menu-open');
            });
        }

        // Close menu on outside click
        document.addEventListener('click', function (e) {
            if (!navMenu.contains(e.target) && !navToggle.contains(e.target)) {
                navToggle.classList.remove('active');
                navMenu.classList.remove('open');
                document.body.classList.remove('menu-open');
            }
        });
    }

    // ===========================
    // Testimonials Carousel
    // ===========================
    var track = document.getElementById('testimonialsTrack');
    var prevBtn = document.getElementById('testimonialPrev');
    var nextBtn = document.getElementById('testimonialNext');
    var dotsContainer = document.getElementById('testimonialDots');

    if (track && prevBtn && nextBtn && dotsContainer) {
        var slides = track.children;
        var currentSlide = 0;
        var totalSlides = slides.length;
        var autoplayInterval = null;

        function goToSlide(index) {
            if (index < 0) index = totalSlides - 1;
            if (index >= totalSlides) index = 0;
            currentSlide = index;
            track.style.transform = 'translateX(-' + (currentSlide * 100) + '%)';

            var dots = dotsContainer.querySelectorAll('.testimonials__dot');
            dots.forEach(function (dot, i) {
                dot.classList.toggle('active', i === currentSlide);
            });
        }

        prevBtn.addEventListener('click', function () {
            goToSlide(currentSlide - 1);
            resetAutoplay();
        });

        nextBtn.addEventListener('click', function () {
            goToSlide(currentSlide + 1);
            resetAutoplay();
        });

        dotsContainer.addEventListener('click', function (e) {
            var dot = e.target.closest('.testimonials__dot');
            if (dot) {
                goToSlide(parseInt(dot.dataset.index));
                resetAutoplay();
            }
        });

        // Autoplay
        function startAutoplay() {
            autoplayInterval = setInterval(function () {
                goToSlide(currentSlide + 1);
            }, 5000);
        }

        function resetAutoplay() {
            clearInterval(autoplayInterval);
            startAutoplay();
        }

        startAutoplay();

        // Touch/swipe support
        var touchStartX = 0;
        var touchEndX = 0;

        track.addEventListener('touchstart', function (e) {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        track.addEventListener('touchend', function (e) {
            touchEndX = e.changedTouches[0].screenX;
            var diff = touchStartX - touchEndX;
            if (Math.abs(diff) > 50) {
                if (diff > 0) {
                    goToSlide(currentSlide + 1);
                } else {
                    goToSlide(currentSlide - 1);
                }
                resetAutoplay();
            }
        }, { passive: true });
    }

    // ===========================
    // Scroll Animations
    // ===========================
    const animateElements = document.querySelectorAll('.card, .split__content, .split__image, .process-step, .stats-row__item, .contact-info__item, .testimonials');

    if (animateElements.length > 0) {
        // Set initial state
        animateElements.forEach(function (el) {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        });

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        animateElements.forEach(function (el) {
            observer.observe(el);
        });
    }
});

// ===========================
// Modal Functions
// ===========================
function openModal(modalId) {
    var modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'flex';
        // Trigger reflow for animation
        modal.offsetHeight;
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    var modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('active');
        setTimeout(function () {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }, 300);
    }
}

// Close modal on overlay click
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('modal-overlay')) {
        e.target.classList.remove('active');
        setTimeout(function () {
            e.target.style.display = 'none';
            document.body.style.overflow = '';
        }, 300);
    }
});

// Close modal on Escape key
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay.active').forEach(function (modal) {
            closeModal(modal.id);
        });
    }
});

// ===========================
// Toast Notifications
// ===========================
function showToast(message, type) {
    type = type || 'info';
    var container = document.getElementById('toastContainer');
    if (!container) return;

    var icons = {
        success: 'ph-check-circle',
        error: 'ph-x-circle',
        info: 'ph-info'
    };

    var toast = document.createElement('div');
    toast.className = 'toast toast--' + type;
    toast.innerHTML = '<i class="ph-bold ' + (icons[type] || icons.info) + '"></i><span>' + message + '</span>';

    container.appendChild(toast);

    // Trigger show animation
    requestAnimationFrame(function () {
        toast.classList.add('show');
    });

    // Auto-remove after 4 seconds
    setTimeout(function () {
        toast.classList.remove('show');
        setTimeout(function () {
            toast.remove();
        }, 400);
    }, 4000);
}
