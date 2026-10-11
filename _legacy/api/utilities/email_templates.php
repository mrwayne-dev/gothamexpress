<?php
/**
 * Project: truepathexpress
 * Created by: mrwayne
 * Generated: 2026-02-16
 *
 * Email template functions for admin authentication
 * All templates use modern, responsive HTML with inline CSS for email client compatibility
 */

require_once __DIR__ . '/../../config/constants.php';

/**
 * Base email template wrapper with branding
 *
 * @param string $title Email title
 * @param string $content HTML content to wrap
 * @return string Complete HTML email
 */
function getEmailBaseTemplate($title, $content) {
    $logoUrl = APP_URL . '/assets/images/logo/3.png';
    $appName = APP_NAME;
    $currentYear = date('Y');

    return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title}</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #F7F9FA;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #F7F9FA; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width: 600px; width: 100%; background: #FFFFFF; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(22, 35, 42, 0.08);">
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #16232A; padding: 32px 40px; text-align: center;">
                            <img src="{$logoUrl}" alt="{$appName}" style="height: 48px; display: block; margin: 0 auto;">
                            <div style="color: #FFFFFF; font-size: 20px; font-weight: 600; margin-top: 8px;">{$appName}</div>
                        </td>
                    </tr>
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px; color: #16232A; line-height: 1.7; font-size: 16px;">
                            {$content}
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #E4EEF0; padding: 24px 40px; text-align: center; color: #5C7078; font-size: 14px;">
                            <p style="margin: 0 0 8px 0;">&copy; {$currentYear} {$appName}. All rights reserved.</p>
                            <p style="margin: 0;">Trusted logistics and consignment tracking platform.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
HTML;
}

/**
 * Admin login notification email
 * Sent when an admin successfully logs in
 *
 * @param string $adminName Admin username
 * @param string $loginTime Formatted login timestamp
 * @param string $ipAddress Login IP address
 * @return string Complete HTML email
 */
function getAdminLoginEmail($adminName, $loginTime, $ipAddress) {
    $content = <<<HTML

<h2 style="color: #16232A; font-size: 24px; margin: 0 0 16px 0; font-weight: 600;">Security Alert: New Login Detected</h2>

<p style="color: #5C7078; margin: 0 0 24px 0;">Hello <strong>{$adminName}</strong>,</p>

<p style="color: #5C7078; margin: 0 0 24px 0;">
    We detected a new login to your TruePath Express admin account. If this was you, no action is needed. If you do not recognize this activity, please secure your account as soon as possible.
</p>

<div style="background-color: #F7F9FA; border-left: 4px solid #FF5B04; padding: 20px; margin: 24px 0; border-radius: 8px;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Login Time:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">{$loginTime}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">IP Address:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">{$ipAddress}</td>
        </tr>
    </table>
</div>

<p style="color: #5C7078; margin: 0 0 24px 0;">
    If you did not log in, we recommend changing your password and reviewing your account security settings.
</p>

<div style="text-align: center; margin: 32px 0;">
    <a href="{APP_URL}/admin.auth.forgotpassword" style="display: inline-block; padding: 14px 32px; background-color: #FF5B04; color: #FFFFFF; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px;">Secure My Account</a>
</div>

<p style="color: #9CA3AF; font-size: 14px; margin: 24px 0 0 0; border-top: 1px solid #E4EEF0; padding-top: 24px;">
    If you have any concerns about your account security, please contact our support team.
</p>
HTML;

    return getEmailBaseTemplate('Security Alert: New Login', $content);
}

/**
 * Admin registration welcome email
 * Sent when a new admin account is created
 *
 * @param string $adminName Admin username
 * @param string $email Admin email address
 * @return string Complete HTML email
 */
function getAdminRegisterEmail($adminName, $email) {
    $content = <<<HTML
<h2 style="color: #16232A; font-size: 24px; margin: 0 0 16px 0; font-weight: 600;">Welcome to TruePath Express!</h2>

<p style="color: #5C7078; margin: 0 0 24px 0;">Hello <strong>{$adminName}</strong>,</p>

<p style="color: #5C7078; margin: 0 0 24px 0;">
    Thank you for registering with TruePath Express Admin Portal. Your account has been successfully created and you're all set to start managing your logistics operations.
</p>

<div style="background-color: #F7F9FA; border-radius: 8px; padding: 24px; margin: 24px 0;">
    <h3 style="color: #16232A; font-size: 18px; margin: 0 0 16px 0; font-weight: 600;">Account Details</h3>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Username:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">{$adminName}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Email:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">{$email}</td>
        </tr>
    </table>
</div>

<p style="color: #5C7078; margin: 0 0 24px 0;">
    You can now access the admin dashboard to manage packages, track shipments, and oversee all logistics operations.
</p>

<div style="text-align: center; margin: 32px 0;">
    <a href="{APP_URL}/admin.auth.login" style="display: inline-block; padding: 14px 32px; background-color: #075056; color: #FFFFFF; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px;">Go to Dashboard</a>
</div>

<div style="background-color: rgba(7, 80, 86, 0.05); border-left: 4px solid #075056; padding: 16px; margin: 24px 0; border-radius: 8px;">
    <p style="color: #5C7078; margin: 0; font-size: 14px;">
        <strong style="color: #075056;">Security Tip:</strong> Keep your login credentials secure and never share them with anyone. Enable all available security features to protect your account.
    </p>
</div>

<p style="color: #9CA3AF; font-size: 14px; margin: 24px 0 0 0; border-top: 1px solid #E4EEF0; padding-top: 24px;">
    If you did not create this account, please contact our support team.
</p>
HTML;

    return getEmailBaseTemplate('Welcome to TruePath Express', $content);
}

/**
 * Forgot password reset link email
 * Sent when admin requests password reset
 *
 * @param string $adminName Admin username
 * @param string $resetLink Password reset URL with token
 * @return string Complete HTML email
 */
function getForgotPasswordEmail($adminName, $resetLink) {
    $content = <<<HTML

<h2 style="color: #16232A; font-size: 24px; margin: 0 0 16px 0; font-weight: 600;">Password Reset Request</h2>

<p style="color: #5C7078; margin: 0 0 24px 0;">Hello <strong>{$adminName}</strong>,</p>

<p style="color: #5C7078; margin: 0 0 24px 0;">
    We received a request to reset your TruePath Express admin account password. To proceed with resetting your password, use the button below.
</p>

<div style="text-align: center; margin: 32px 0;">
    <a href="{$resetLink}" style="display: inline-block; padding: 14px 32px; background-color: #075056; color: #FFFFFF; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px;">Reset Password</a>
</div>

<div style="background-color: rgba(146, 20, 12, 0.05); border-left: 4px solid #92140C; padding: 16px; margin: 24px 0; border-radius: 8px;">
    <p style="color: #5C7078; margin: 0 0 8px 0; font-size: 14px;">
        <strong style="color: #92140C;">Important:</strong> This reset link will expire in <strong>1 hour</strong> for security reasons.
    </p>
    <p style="color: #5C7078; margin: 0; font-size: 14px;">
        If you need a new link after expiry, you may request another password reset.
    </p>
</div>

<p style="color: #5C7078; margin: 0 0 16px 0;">
    Alternatively, you may copy and paste this link into your browser:
</p>

<div style="background-color: #F7F9FA; padding: 16px; border-radius: 8px; word-break: break-all; font-family: monospace; font-size: 13px; color: #5C7078; margin: 0 0 24px 0;">
    {$resetLink}
</div>

<p style="color: #9CA3AF; font-size: 14px; margin: 24px 0 0 0; border-top: 1px solid #E4EEF0; padding-top: 24px;">
    If you did not request a password reset, please ignore this email or contact our support team if you have concerns about your account security. Your password will remain unchanged.
</p>
HTML;

    return getEmailBaseTemplate('Password Reset Request', $content);
}

/**
 * Password reset confirmation email
 * Sent after successful password change
 *
 * @param string $adminName Admin username
 * @return string Complete HTML email
 */
function getResetPasswordConfirmationEmail($adminName) {
    $resetTime = date('F j, Y g:i A');

    $content = <<<HTML

<h2 style="color: #16232A; font-size: 24px; margin: 0 0 16px 0; font-weight: 600;">Password Successfully Changed</h2>

<p style="color: #5C7078; margin: 0 0 24px 0;">Hello <strong>{$adminName}</strong>,</p>

<p style="color: #5C7078; margin: 0 0 24px 0;">
    Your TruePath Express admin account password has been successfully changed. You can now use your new password to log in.
</p>

<div style="background-color: #F7F9FA; border-left: 4px solid #0A7A42; padding: 20px; margin: 24px 0; border-radius: 8px;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Changed At:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">{$resetTime}</td>
        </tr>
    </table>
</div>

<p style="color: #5C7078; margin: 0 0 24px 0;">
    For your security, all active sessions have been logged out. Please log in again with your new password.
</p>

<div style="text-align: center; margin: 32px 0;">
    <a href="{APP_URL}/admin.auth.login" style="display: inline-block; padding: 14px 32px; background-color: #075056; color: #FFFFFF; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px;">Log In Now</a>
</div>

<div style="background-color: rgba(146, 20, 12, 0.05); border-left: 4px solid #92140C; padding: 16px; margin: 24px 0; border-radius: 8px;">
    <p style="color: #5C7078; margin: 0; font-size: 14px;">
        <strong style="color: #92140C;">Security Alert:</strong> If you did not make this change, someone may have unauthorized access to your account. Please contact our support team.
    </p>
</div>

<p style="color: #9CA3AF; font-size: 14px; margin: 24px 0 0 0; border-top: 1px solid #E4EEF0; padding-top: 24px;">
    This is an automated security notification. Please do not reply to this email.
</p>
HTML;

    return getEmailBaseTemplate('Password Successfully Changed', $content);
}

/**
 * Payment initiated email template for customers
 *
 * @param string $customerEmail Customer email
 * @param string $trackingId Package tracking ID
 * @param string $packageName Package name
 * @param float $amount Payment amount
 * @param string $paymentUrl Payment URL
 * @return string HTML email
 */
function getPaymentInitiatedEmail($customerEmail, $trackingId, $packageName, $amount, $paymentUrl) {
    $formattedAmount = number_format($amount, 2);

    $content = <<<HTML

<h2 style="color: #16232A; font-size: 24px; margin: 0 0 16px 0; font-weight: 600;">Invoice for Package Delivery</h2>

<p style="color: #5C7078; margin: 0 0 24px 0;">Hello,</p>

<p style="color: #5C7078; margin: 0 0 24px 0;">
    This is your invoice for package delivery services. Your package is ready for shipment and awaiting payment confirmation to proceed with delivery.
</p>

<div style="background-color: #F7F9FA; border-left: 4px solid #075056; padding: 20px; margin: 24px 0; border-radius: 8px;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Tracking ID:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">{$trackingId}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Package:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">{$packageName}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Invoice Amount:</strong></td>
            <td style="padding: 8px 0; color: #16232A; font-size: 16px; font-weight: 600; text-align: right;">\${$formattedAmount} USD</td>
        </tr>
    </table>
</div>

<div style="text-align: center; margin: 32px 0;">
    <a href="{$paymentUrl}" style="display: inline-block; padding: 14px 32px; background-color: #075056; color: #FFFFFF; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px;">View Invoice and Pay</a>
</div>

<p style="color: #5C7078; margin: 0 0 24px 0;">
    After payment confirmation, your package will be processed for delivery within 24 hours.
</p>

<div style="background-color: rgba(7, 80, 86, 0.05); border-left: 4px solid #075056; padding: 16px; margin: 24px 0; border-radius: 8px;">
    <p style="color: #5C7078; margin: 0; font-size: 14px;">
        <strong style="color: #075056;">Payment Information:</strong> Multiple payment methods are available through our secure payment gateway. All transactions are encrypted and processed securely.
    </p>
</div>

<p style="color: #5C7078; font-size: 14px; margin: 24px 0 8px 0;">
    <strong>Need assistance?</strong> Contact our support team at support@truepathexpress.com
</p>

<p style="color: #9CA3AF; font-size: 14px; margin: 8px 0 0 0; border-top: 1px solid #E4EEF0; padding-top: 24px;">
    This is an automated invoice from TruePath Express for tracking ID {$trackingId}. If you have questions about this invoice, please contact our support team.
</p>
HTML;

    return getEmailBaseTemplate('Invoice for Package ' . $trackingId . ' - TruePath Express', $content);
}

/**
 * Payment confirmed email template
 *
 * @param string $customerEmail Customer email
 * @param string $trackingId Package tracking ID
 * @param string $packageName Package name
 * @param float $amount Payment amount
 * @param string $paymentId Payment transaction ID
 * @return string HTML email
 */
function getPaymentConfirmedEmail($customerEmail, $trackingId, $packageName, $amount, $paymentId) {
    $formattedAmount = number_format($amount, 2);
    $confirmationTime = date('F j, Y g:i A');

    $content = <<<HTML

<h2 style="color: #16232A; font-size: 24px; margin: 0 0 16px 0; font-weight: 600;">Payment Confirmed</h2>

<p style="color: #5C7078; margin: 0 0 24px 0;">Hello,</p>

<p style="color: #5C7078; margin: 0 0 24px 0;">
    Your payment has been successfully confirmed. Your package is now being prepared for shipment.
</p>

<div style="background-color: #F7F9FA; border-left: 4px solid #0A7A42; padding: 20px; margin: 24px 0; border-radius: 8px;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Tracking ID:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">{$trackingId}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Package:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">{$packageName}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Amount Paid:</strong></td>
            <td style="padding: 8px 0; color: #0A7A42; font-size: 18px; font-weight: 600; text-align: right;">\${$formattedAmount} USD</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Payment ID:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">{$paymentId}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Confirmed At:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">{$confirmationTime}</td>
        </tr>
    </table>
</div>

<div style="text-align: center; margin: 32px 0;">
    <a href="{APP_URL}/tracking" style="display: inline-block; padding: 14px 32px; background-color: #075056; color: #FFFFFF; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px;">Track Your Package</a>
</div>

<p style="color: #5C7078; margin: 0 0 24px 0;">
    You can now track your package status anytime using your tracking ID and email address.
</p>

<div style="background-color: rgba(7, 80, 86, 0.05); border-left: 4px solid #075056; padding: 16px; margin: 24px 0; border-radius: 8px;">
    <p style="color: #5C7078; margin: 0; font-size: 14px;">
        <strong style="color: #075056;">Next Steps:</strong> Your package will be processed and shipped within 24 hours. You will receive tracking updates as your package moves through our network.
    </p>
</div>

<p style="color: #9CA3AF; font-size: 14px; margin: 24px 0 0 0; border-top: 1px solid #E4EEF0; padding-top: 24px;">
    Thank you for choosing TruePath Express. This is an automated confirmation email.
</p>
HTML;

    return getEmailBaseTemplate('Payment Confirmed - TruePath Express', $content);
}

/**
 * Package status update email template
 *
 * @param string $customerEmail Customer email
 * @param string $trackingId Package tracking ID
 * @param string $packageName Package name
 * @param string $status Package status (in_transit or delivered)
 * @param string $location Current location
 * @return string HTML email
 */
function getPackageStatusUpdateEmail($customerEmail, $trackingId, $packageName, $status, $location) {
    $updateTime = date('F j, Y g:i A');

    if ($status === 'in_transit') {
        $statusTitle = 'Package In Transit';
        $statusMessage = 'Your package is on its way. It is currently being transported to your delivery address.';
        $statusColor = '#FF5B04';
        $statusLabel = 'In Transit';
    } else if ($status === 'delivered') {
        $statusTitle = 'Package Delivered';
        $statusMessage = 'Your package has been successfully delivered to your address.';
        $statusColor = '#0A7A42';
        $statusLabel = 'Delivered';
    } else {
        $statusTitle = 'Package Processing';
        $statusMessage = 'Your package is being processed at our facility.';
        $statusColor = '#075056';
        $statusLabel = 'Processing';
    }

    $content = <<<HTML

<h2 style="color: #16232A; font-size: 24px; margin: 0 0 16px 0; font-weight: 600;">{$statusTitle}</h2>

<p style="color: #5C7078; margin: 0 0 24px 0;">Hello,</p>

<p style="color: #5C7078; margin: 0 0 24px 0;">
    {$statusMessage}
</p>

<div style="background-color: #F7F9FA; border-left: 4px solid {$statusColor}; padding: 20px; margin: 24px 0; border-radius: 8px;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Tracking ID:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">{$trackingId}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Package:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">{$packageName}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Status:</strong></td>
            <td style="padding: 8px 0; color: {$statusColor}; font-size: 16px; font-weight: 600; text-align: right;">{$statusLabel}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Location:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">{$location}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Updated At:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">{$updateTime}</td>
        </tr>
    </table>
</div>

<div style="text-align: center; margin: 32px 0;">
    <a href="{APP_URL}/tracking" style="display: inline-block; padding: 14px 32px; background-color: #075056; color: #FFFFFF; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px;">View Full Details</a>
</div>

<p style="color: #9CA3AF; font-size: 14px; margin: 24px 0 0 0; border-top: 1px solid #E4EEF0; padding-top: 24px;">
    You will receive updates as your package progresses. This is an automated notification.
</p>
HTML;

    return getEmailBaseTemplate('Package Status Update - TruePath Express', $content);
}

/**
 * Contact form user confirmation email
 * Sent to user who submitted the contact form
 *
 * @param string $firstname User first name
 * @param string $lastname User last name
 * @param string $email User email
 * @param string $inquiryType Type of inquiry
 * @param string $message User's message
 * @return string HTML email
 */
function getContactUserEmail($firstname, $lastname, $email, $inquiryType, $message) {
    $submittedTime = date('F j, Y g:i A');
    $fullName = $firstname . ' ' . $lastname;

    // Format inquiry type for display
    $inquiryLabels = [
        'general' => 'General Inquiry',
        'tracking' => 'Package Tracking',
        'shipping' => 'Shipping Rates',
        'partnership' => 'Partnership Opportunity',
        'complaint' => 'Complaint or Feedback'
    ];
    $inquiryLabel = $inquiryLabels[$inquiryType] ?? ucfirst($inquiryType);

    $content = <<<HTML

<h2 style="color: #16232A; font-size: 24px; margin: 0 0 16px 0; font-weight: 600;">Thank You for Contacting Us</h2>

<p style="color: #5C7078; margin: 0 0 24px 0;">Hello <strong>{$fullName}</strong>,</p>

<p style="color: #5C7078; margin: 0 0 24px 0;">
    We have received your message and appreciate you reaching out to TruePath Express. Our support team will review your inquiry and respond within 24-48 business hours.
</p>

<div style="background-color: #F7F9FA; border-left: 4px solid #075056; padding: 20px; margin: 24px 0; border-radius: 8px;">
    <h3 style="color: #16232A; font-size: 16px; margin: 0 0 16px 0; font-weight: 600;">Your Inquiry Details</h3>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Name:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">{$fullName}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Email:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">{$email}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Inquiry Type:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">{$inquiryLabel}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Submitted:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">{$submittedTime}</td>
        </tr>
    </table>
</div>

<div style="background-color: #F7F9FA; padding: 16px; margin: 24px 0; border-radius: 8px;">
    <p style="color: #5C7078; margin: 0 0 8px 0; font-size: 14px;"><strong style="color: #16232A;">Your Message:</strong></p>
    <p style="color: #5C7078; margin: 0; font-size: 14px; line-height: 1.6; white-space: pre-wrap;">{$message}</p>
</div>

<div style="background-color: rgba(7, 80, 86, 0.05); border-left: 4px solid #075056; padding: 16px; margin: 24px 0; border-radius: 8px;">
    <p style="color: #5C7078; margin: 0; font-size: 14px;">
        <strong style="color: #075056;">What happens next?</strong> Our team will review your inquiry and send a detailed response to this email address. Response time is typically 24-48 business hours.
    </p>
</div>

<p style="color: #5C7078; font-size: 14px; margin: 24px 0 8px 0;">
    <strong>Need urgent assistance?</strong> You can also reach us at:
</p>

<p style="color: #5C7078; font-size: 14px; margin: 0;">
    Phone: +1 (800) 555-0199<br>
    Email: support@truepathexpress.com<br>
    Hours: Mon - Fri, 8:00 AM - 6:00 PM (CST)
</p>

<p style="color: #9CA3AF; font-size: 14px; margin: 24px 0 0 0; border-top: 1px solid #E4EEF0; padding-top: 24px;">
    This is an automated confirmation. Please do not reply to this email. If you did not submit this inquiry, please contact our support team.
</p>
HTML;

    return getEmailBaseTemplate('Message Received - TruePath Express', $content);
}

/**
 * Contact form admin notification email
 * Sent to admin when contact form is submitted
 *
 * @param string $firstname User first name
 * @param string $lastname User last name
 * @param string $email User email
 * @param string $inquiryType Type of inquiry
 * @param string $message User's message
 * @return string HTML email
 */
function getContactAdminEmail($firstname, $lastname, $email, $inquiryType, $message) {
    $submittedTime = date('F j, Y g:i A');
    $fullName = $firstname . ' ' . $lastname;

    // Format inquiry type for display
    $inquiryLabels = [
        'general' => 'General Inquiry',
        'tracking' => 'Package Tracking',
        'shipping' => 'Shipping Rates',
        'partnership' => 'Partnership Opportunity',
        'complaint' => 'Complaint or Feedback'
    ];
    $inquiryLabel = $inquiryLabels[$inquiryType] ?? ucfirst($inquiryType);

    // Set priority color based on inquiry type
    $priorityColor = '#075056';
    if ($inquiryType === 'complaint') {
        $priorityColor = '#92140C';
    } elseif ($inquiryType === 'partnership') {
        $priorityColor = '#FF5B04';
    }

    $content = <<<HTML

<h2 style="color: #16232A; font-size: 24px; margin: 0 0 16px 0; font-weight: 600;">New Contact Form Submission</h2>

<p style="color: #5C7078; margin: 0 0 24px 0;">
    A new inquiry has been submitted through the TruePath Express contact form. Please review and respond accordingly.
</p>

<div style="background-color: #F7F9FA; border-left: 4px solid {$priorityColor}; padding: 20px; margin: 24px 0; border-radius: 8px;">
    <h3 style="color: #16232A; font-size: 16px; margin: 0 0 16px 0; font-weight: 600;">Contact Information</h3>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Name:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">{$fullName}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Email:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">
                <a href="mailto:{$email}" style="color: #075056; text-decoration: none;">{$email}</a>
            </td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Inquiry Type:</strong></td>
            <td style="padding: 8px 0; color: {$priorityColor}; font-size: 14px; font-weight: 600; text-align: right;">{$inquiryLabel}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Submitted:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">{$submittedTime}</td>
        </tr>
    </table>
</div>

<div style="background-color: #FFFFFF; border: 1px solid #E4EEF0; padding: 20px; margin: 24px 0; border-radius: 8px;">
    <p style="color: #5C7078; margin: 0 0 12px 0; font-size: 14px;"><strong style="color: #16232A;">Message:</strong></p>
    <p style="color: #16232A; margin: 0; font-size: 14px; line-height: 1.7; white-space: pre-wrap;">{$message}</p>
</div>

<div style="text-align: center; margin: 32px 0;">
    <a href="mailto:{$email}?subject=Re: Your TruePath Express Inquiry" style="display: inline-block; padding: 14px 32px; background-color: #075056; color: #FFFFFF; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px;">Reply to Customer</a>
</div>

<div style="background-color: rgba(7, 80, 86, 0.05); border-left: 4px solid #075056; padding: 16px; margin: 24px 0; border-radius: 8px;">
    <p style="color: #5C7078; margin: 0; font-size: 14px;">
        <strong style="color: #075056;">Action Required:</strong> Please respond to this inquiry within 24-48 business hours to maintain our service quality standards.
    </p>
</div>

<p style="color: #9CA3AF; font-size: 14px; margin: 24px 0 0 0; border-top: 1px solid #E4EEF0; padding-top: 24px;">
    This is an automated notification from the TruePath Express contact form system.
</p>
HTML;

    return getEmailBaseTemplate('New Contact Form Inquiry - TruePath Express', $content);
}

/**
 * Payment initiated admin notification email
 * Sent to admin when customer initiates payment
 *
 * @param string $customerEmail Customer email address
 * @param string $trackingId Package tracking ID
 * @param string $packageName Package name
 * @param float $amount Payment amount
 * @param string $paymentUrl Payment URL
 * @return string HTML email
 */
function getPaymentInitiatedAdminEmail($customerEmail, $trackingId, $packageName, $amount, $paymentUrl) {
    $formattedAmount = number_format($amount, 2);
    $initiatedTime = date('F j, Y g:i A');

    $content = <<<HTML

<h2 style="color: #16232A; font-size: 24px; margin: 0 0 16px 0; font-weight: 600;">New Payment Initiated</h2>

<p style="color: #5C7078; margin: 0 0 24px 0;">
    A customer has initiated payment for a package. The customer is currently being directed to the payment gateway.
</p>

<div style="background-color: #F7F9FA; border-left: 4px solid #075056; padding: 20px; margin: 24px 0; border-radius: 8px;">
    <h3 style="color: #16232A; font-size: 16px; margin: 0 0 16px 0; font-weight: 600;">Package Details</h3>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Tracking ID:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">{$trackingId}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Package Name:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">{$packageName}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Invoice Amount:</strong></td>
            <td style="padding: 8px 0; color: #075056; font-size: 18px; font-weight: 600; text-align: right;">\${$formattedAmount} USD</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Customer Email:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">
                <a href="mailto:{$customerEmail}" style="color: #075056; text-decoration: none;">{$customerEmail}</a>
            </td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Initiated At:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">{$initiatedTime}</td>
        </tr>
    </table>
</div>

<div style="background-color: rgba(7, 80, 86, 0.05); border-left: 4px solid #075056; padding: 16px; margin: 24px 0; border-radius: 8px;">
    <p style="color: #5C7078; margin: 0; font-size: 14px;">
        <strong style="color: #075056;">Payment Status:</strong> The customer is being redirected to the payment gateway. Payment confirmation will be sent once the transaction is completed.
    </p>
</div>

<div style="text-align: center; margin: 32px 0;">
    <a href="{APP_URL}/admin.packages" style="display: inline-block; padding: 14px 32px; background-color: #075056; color: #FFFFFF; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px;">View in Dashboard</a>
</div>

<p style="color: #5C7078; font-size: 14px; margin: 24px 0 8px 0;">
    <strong>Payment Gateway URL:</strong>
</p>

<div style="background-color: #F7F9FA; padding: 16px; border-radius: 8px; word-break: break-all; font-family: monospace; font-size: 12px; color: #5C7078; margin: 0 0 24px 0;">
    {$paymentUrl}
</div>

<p style="color: #9CA3AF; font-size: 14px; margin: 24px 0 0 0; border-top: 1px solid #E4EEF0; padding-top: 24px;">
    This is an automated notification from TruePath Express payment system. You will receive another notification once payment is confirmed.
</p>
HTML;

    return getEmailBaseTemplate('New Payment Initiated - Package #' . $trackingId, $content);
}

/**
 * Payment confirmed admin notification email
 * Sent to admin when payment is successfully completed
 *
 * @param string $customerEmail Customer email address
 * @param string $trackingId Package tracking ID
 * @param string $packageName Package name
 * @param float $amount Payment amount
 * @param string $paymentId Payment transaction ID
 * @param string $paymentMethod Payment method/currency used
 * @return string HTML email
 */
function getPaymentConfirmedAdminEmail($customerEmail, $trackingId, $packageName, $amount, $paymentId, $paymentMethod) {
    $formattedAmount = number_format($amount, 2);
    $confirmedTime = date('F j, Y g:i A');

    $content = <<<HTML

<h2 style="color: #16232A; font-size: 24px; margin: 0 0 16px 0; font-weight: 600;">Payment Confirmed</h2>

<p style="color: #5C7078; margin: 0 0 24px 0;">
    A payment has been successfully confirmed. The package is now paid and ready for processing.
</p>

<div style="background-color: #F7F9FA; border-left: 4px solid #0A7A42; padding: 20px; margin: 24px 0; border-radius: 8px;">
    <h3 style="color: #16232A; font-size: 16px; margin: 0 0 16px 0; font-weight: 600;">Payment Details</h3>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Tracking ID:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">{$trackingId}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Package Name:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">{$packageName}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Amount Paid:</strong></td>
            <td style="padding: 8px 0; color: #0A7A42; font-size: 18px; font-weight: 600; text-align: right;">\${$formattedAmount} USD</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Transaction ID:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">{$paymentId}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Payment Method:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">{$paymentMethod}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Customer Email:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">
                <a href="mailto:{$customerEmail}" style="color: #075056; text-decoration: none;">{$customerEmail}</a>
            </td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px;"><strong style="color: #16232A;">Confirmed At:</strong></td>
            <td style="padding: 8px 0; color: #5C7078; font-size: 14px; text-align: right;">{$confirmedTime}</td>
        </tr>
    </table>
</div>

<div style="background-color: rgba(10, 122, 66, 0.1); border-left: 4px solid #0A7A42; padding: 16px; margin: 24px 0; border-radius: 8px;">
    <p style="color: #5C7078; margin: 0; font-size: 14px;">
        <strong style="color: #0A7A42;">Next Steps:</strong> The package payment status has been updated to "Paid". You can now proceed with package processing and shipment.
    </p>
</div>

<div style="text-align: center; margin: 32px 0;">
    <a href="{APP_URL}/admin.transactions" style="display: inline-block; padding: 14px 32px; background-color: #0A7A42; color: #FFFFFF; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px; margin-right: 8px;">View Transaction</a>
    <a href="{APP_URL}/admin.packages" style="display: inline-block; padding: 14px 32px; background-color: #075056; color: #FFFFFF; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px;">View Package</a>
</div>

<p style="color: #9CA3AF; font-size: 14px; margin: 24px 0 0 0; border-top: 1px solid #E4EEF0; padding-top: 24px;">
    This is an automated notification from TruePath Express payment system. The customer has also received a payment confirmation email.
</p>
HTML;

    return getEmailBaseTemplate('Payment Confirmed - Package #' . $trackingId, $content);
}
