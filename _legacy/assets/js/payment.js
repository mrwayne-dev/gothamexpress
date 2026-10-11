/**
 * Project: truepathexpress
 * Created by: mrwayne
 * Generated: 2026-02-16
 *
 * Payment and Tracking Frontend Logic
 * Handles tracking form submission, modal display, and payment initiation
 */

// Global variable to store current package data
let currentPackage = null;

/**
 * Handle tracking form submission
 */
document.addEventListener('DOMContentLoaded', function() {
    const trackingForm = document.getElementById('trackingForm');

    if (trackingForm) {
        trackingForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleTrackingSubmit();
        });
    }

    // Check for success/cancel URL parameters
    checkPaymentStatus();
});

/**
 * Handle tracking form submission
 */
function handleTrackingSubmit() {
    const email = document.getElementById('trackEmail').value.trim();
    const trackingId = document.getElementById('trackId').value.trim().toUpperCase();

    // Validate inputs
    if (!email || !trackingId) {
        showToast('Please enter both email and tracking ID', 'error');
        return;
    }

    // Validate email format
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        showToast('Please enter a valid email address', 'error');
        return;
    }

    // Show loading state
    const submitBtn = document.querySelector('#trackingForm button[type="submit"]');
    const originalBtnText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="ph-bold ph-spinner"></i> Tracking...';

    // Make API request
    fetch('/api/tracking/tracking.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            email: email,
            tracking_id: trackingId
        })
    })
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;

        if (data.success) {
            currentPackage = data.package;

            // Determine which modal to show based on payment status
            if (currentPackage.payment_status === 'unpaid') {
                showPaymentModal();
            } else {
                showTrackingModal();
            }
        } else {
            showToast(data.message || 'Package not found', 'error');
        }
    })
    .catch(function(error) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
        showToast('Connection error. Please try again.', 'error');
        console.error('Tracking error:', error);
    });
}

/**
 * Show payment modal with package details
 */
function showPaymentModal() {
    if (!currentPackage) return;

    // Populate payment modal fields
    document.getElementById('paymentPackageImage').src = currentPackage.image || '/assets/images/placeholder-package.jpg';
    document.getElementById('paymentPackageName').textContent = currentPackage.package_name;
    document.getElementById('paymentTrackingId').textContent = currentPackage.tracking_id;
    document.getElementById('paymentDescription').textContent = currentPackage.description || '—';
    document.getElementById('paymentInvoice').textContent = currentPackage.invoice_message || '—';
    document.getElementById('paymentAmount').textContent = '$' + parseFloat(currentPackage.amount).toFixed(2);

    // Show modal
    openModal('paymentModal');
    showToast('Payment required to proceed with delivery', 'info');
}

/**
 * Show tracking modal with package status
 */
function showTrackingModal() {
    if (!currentPackage) return;

    // Populate tracking modal fields
    document.getElementById('trackPackageImage').src = currentPackage.image || '/assets/images/placeholder-package.jpg';
    document.getElementById('trackTrackingId').textContent = currentPackage.tracking_id;
    document.getElementById('trackPackageName').textContent = currentPackage.package_name;
    document.getElementById('trackSender').textContent = currentPackage.sender;
    document.getElementById('trackRecipient').textContent = currentPackage.firstname + ' ' + currentPackage.lastname;
    document.getElementById('trackAddress').textContent = currentPackage.address;
    document.getElementById('trackLocation').textContent = currentPackage.location;
    document.getElementById('trackDescription').textContent = currentPackage.description || '—';
    document.getElementById('trackStatus').textContent = formatStatus(currentPackage.status);

    // Update status tracker visual state
    updateStatusTracker(currentPackage.status);

    // Show modal
    openModal('trackOrderModal');
    showToast('Package details loaded successfully', 'success');
}

/**
 * Update status tracker visual state based on package status
 */
function updateStatusTracker(status) {
    const steps = {
        processing: document.getElementById('stepProcessing'),
        shipped: document.getElementById('stepShipped'),
        delivered: document.getElementById('stepDelivered')
    };

    // Reset all steps
    Object.values(steps).forEach(function(step) {
        step.classList.remove('active', 'completed');
    });

    // Set active states based on current status
    if (status === 'processing') {
        steps.processing.classList.add('active');
    } else if (status === 'in_transit') {
        steps.processing.classList.add('completed');
        steps.shipped.classList.add('active');
    } else if (status === 'delivered') {
        steps.processing.classList.add('completed');
        steps.shipped.classList.add('completed');
        steps.delivered.classList.add('active');
    }
}

/**
 * Format status for display
 */
function formatStatus(status) {
    const statusMap = {
        'processing': 'Processing',
        'in_transit': 'In Transit',
        'delivered': 'Delivered'
    };
    return statusMap[status] || status;
}

/**
 * Initiate payment process
 */
function initiatePayment() {
    if (!currentPackage) {
        showToast('Package data not available', 'error');
        return;
    }

    // Show loading state
    const payBtn = document.getElementById('payNowBtn');
    const originalBtnText = payBtn.innerHTML;
    payBtn.disabled = true;
    payBtn.innerHTML = '<i class="ph-bold ph-spinner"></i> Processing...';

    // Create payment invoice
    fetch('/api/payments/now-payment.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            package_id: currentPackage.id
        })
    })
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        payBtn.disabled = false;
        payBtn.innerHTML = originalBtnText;

        if (data.success && data.payment_url) {
            // Validate payment URL before redirect
            try {
                const url = new URL(data.payment_url);
                if (url.protocol !== 'https:') {
                    throw new Error('Invalid payment URL protocol');
                }
            } catch (error) {
                showToast('Invalid payment URL received. Please contact support.', 'error');
                console.error('Payment URL validation failed:', data.payment_url);
                return;
            }

            showToast('Redirecting to secure payment gateway...', 'success');

            // Store email for auto-fill on return
            const email = document.getElementById('trackEmail').value;
            if (email) {
                localStorage.setItem('tracking_email', email);
            }

            // Redirect after 1.5 seconds (enough time to see toast)
            setTimeout(function() {
                window.location.href = data.payment_url;
            }, 1500);
        } else {
            showToast(data.message || 'Payment initiation failed', 'error');
        }
    })
    .catch(function(error) {
        payBtn.disabled = false;
        payBtn.innerHTML = originalBtnText;
        showToast('Connection error. Please try again.', 'error');
        console.error('Payment error:', error);
    });
}

/**
 * Check payment status from URL parameters
 */
function checkPaymentStatus() {
    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');
    const cancel = urlParams.get('cancel');
    const trackingId = urlParams.get('tracking_id');

    if (success === '1' && trackingId) {
        showToast('Payment successful! Your package is being processed.', 'success');

        // Auto-fill tracking form if email is available in localStorage
        const savedEmail = localStorage.getItem('tracking_email');
        if (savedEmail) {
            document.getElementById('trackEmail').value = savedEmail;
            document.getElementById('trackId').value = trackingId;
        }

        // Clean URL
        setTimeout(function() {
            window.history.replaceState({}, document.title, window.location.pathname);
        }, 3000);
    } else if (cancel === '1' && trackingId) {
        showToast('Payment was cancelled. You can try again anytime.', 'info');

        // Auto-fill tracking ID
        document.getElementById('trackId').value = trackingId;

        // Clean URL
        setTimeout(function() {
            window.history.replaceState({}, document.title, window.location.pathname);
        }, 3000);
    }
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

    // Remove after 4 seconds
    setTimeout(function() {
        toast.style.animation = 'slideOut 0.3s ease';
        setTimeout(function() {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 300);
    }, 4000);
}

/**
 * Open modal
 */
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

/**
 * Close modal
 */
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}

// Add CSS animations if not already defined
if (!document.getElementById('payment-animations')) {
    const style = document.createElement('style');
    style.id = 'payment-animations';
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(22, 35, 42, 0.8);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.active {
            display: flex;
        }

        .status-tracker__step {
            opacity: 0.4;
            transition: all 0.3s ease;
        }

        .status-tracker__step.active,
        .status-tracker__step.completed {
            opacity: 1;
        }

        .status-tracker__step.active .status-tracker__dot {
            background: var(--color-blaze);
            color: white;
            transform: scale(1.1);
        }

        .status-tracker__step.completed .status-tracker__dot {
            background: #0A7A42;
            color: white;
        }
    `;
    document.head.appendChild(style);
}
