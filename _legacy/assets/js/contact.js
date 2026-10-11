/**
 * Project: truepathexpress
 * Created by: mrwayne
 * Generated: 2026-02-16
 *
 * Contact Form Frontend Logic
 * Handles form submission and validation
 */

document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');

    if (contactForm) {
        contactForm.addEventListener('submit', handleContactSubmit);
    }
});

/**
 * Handle contact form submission
 */
function handleContactSubmit(e) {
    e.preventDefault();

    // Get form values
    const firstname = document.getElementById('firstname').value.trim();
    const lastname = document.getElementById('lastname').value.trim();
    const email = document.getElementById('email').value.trim();
    const inquiry = document.getElementById('inquiry').value;
    const message = document.getElementById('message').value.trim();

    // Client-side validation
    const errors = [];

    if (!firstname || firstname.length < 2) {
        errors.push('First name must be at least 2 characters');
    }

    if (!lastname || lastname.length < 2) {
        errors.push('Last name must be at least 2 characters');
    }

    if (!email) {
        errors.push('Email is required');
    } else if (!isValidEmail(email)) {
        errors.push('Please provide a valid email address');
    }

    if (!inquiry) {
        errors.push('Please select an inquiry type');
    }

    if (!message || message.length < 10) {
        errors.push('Message must be at least 10 characters');
    }

    // Show validation errors
    if (errors.length > 0) {
        showToast(errors[0], 'error');
        return;
    }

    // Show loading state
    const submitBtn = contactForm.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="ph-bold ph-spinner"></i> Sending...';

    // Submit form data
    fetch('/api/utilities/contact.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            firstname: firstname,
            lastname: lastname,
            email: email,
            inquiry: inquiry,
            message: message
        })
    })
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;

        if (data.success) {
            showToast(data.message || 'Message sent successfully!', 'success');

            // Reset form
            contactForm.reset();

            // Scroll to top of form
            contactForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
        } else {
            showToast(data.message || 'Failed to send message. Please try again.', 'error');
        }
    })
    .catch(function(error) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
        showToast('Connection error. Please check your internet and try again.', 'error');
        console.error('Contact form error:', error);
    });
}

/**
 * Validate email format
 */
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

/**
 * Show toast notification
 */
function showToast(message, type) {
    type = type || 'info';

    // Check if toast function exists in main.js
    if (typeof window.toast === 'function') {
        window.toast(message, type);
        return;
    }

    // Fallback toast implementation
    const toast = document.createElement('div');
    toast.className = 'toast toast--' + type;
    toast.textContent = message;

    // Style toast
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#0A7A42' : type === 'error' ? '#92140C' : '#075056'};
        color: white;
        padding: 16px 24px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 10000;
        animation: slideIn 0.3s ease;
        max-width: 400px;
        font-size: 14px;
    `;

    document.body.appendChild(toast);

    // Remove after 5 seconds
    setTimeout(function() {
        toast.style.animation = 'slideOut 0.3s ease';
        setTimeout(function() {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 300);
    }, 5000);
}
