# TRUEPATH EXPRESS – CLAUDE PROJECT RULES

You are acting as a Senior Full-Stack Architect for a logistics consignment platform.

Project Name: TruePath Express  
Stack: PHP (Procedural + Structured), MySQL (PDO), Vanilla JS  
Architecture: Clean routing + modular includes + API-driven backend

You must follow ALL rules strictly.

------------------------------------------------------------
🌍 1. PROJECT STRUCTURE RULES
------------------------------------------------------------

Root:
- index.php = Router
- .env = Sensitive config
- .htaccess = Simple clean routing only

Routing rule:
- Admin auth routes must follow:
  truepathexpress.com/admin/auth.login
- No complex rewrite logic.
- Keep .htaccess minimal and clean.

Pages structure:
pages/
    public/
    admin/
    admin/auth/

Includes folder:
- head.php
- header.php
- footer.php
- sidebar.php
- payment-modal.php
- track-order-modal.php

All public pages must:
- Load header.php
- Load footer.php
- Use main.js
- Use Phosphor Icons
- Use project fonts only

------------------------------------------------------------
🎨 2. DESIGN SYSTEM ENFORCEMENT
------------------------------------------------------------

All styling MUST follow design token architecture.

At top of main.css include:

- Color Variables
- Typography Scale
- Spacing Scale
- Radius Scale
- Shadow Scale
- Transition Variables
- Container Widths

Color System:

--color-mirage: #16232A;
--color-blaze: #FF5B04;
--color-deep-sea: #075056;
--color-wild-sand: #E4EEF0;
--color-freight-crimson: #92140C;

STRICT RULES:
- No hardcoded colors
- No hardcoded spacing
- No random font sizes
- No inline styles
- No !important unless absolutely necessary

Responsive file (responsive.css):
Must include:

@media (max-width: 1200px)
@media (max-width: 992px)
@media (max-width: 768px)
@media (max-width: 576px)

Adjust:
- Typography scale
- Hero sizing
- Grid stacking
- Button sizes
- Container width
- Section padding

Mobile Modal Rule:
On mobile:
- Modals must slide up from bottom
- Must NOT be centered vertically
- Fixed bottom positioning
- Smooth transform transition

------------------------------------------------------------
⚙️ 3. BACKEND RULES
------------------------------------------------------------

Use PDO only.
No mysqli.
Use prepared statements always.
Never trust input.

All backend files live in:

api/
    admin-dashboard/
    auth/
    payment/
    utilities/
    webhooks/

Admin Dashboard API:
- dashboard.php
- packages.php (CRUD)
- transactions.php

Authentication:
- admin-login
- admin-register
- admin-forgot-password
- password reset logic
- Secure session handling

Database:
Provide dbschema.sql
Use proper indexing.
Use foreign keys where needed.

------------------------------------------------------------
📦 4. PACKAGE SYSTEM RULES
------------------------------------------------------------

Package Fields:
- package_name
- amount
- description
- invoice_message
- sender
- phone
- firstname
- lastname
- email
- address
- location
- address_type
- image
- status (Processing | In Transit | Delivered)
- payment_status (Unpaid | Paid)

Admin can:
- Create
- Edit
- Delete
- Update status

Tracking Page:
- Form: Email + Tracking ID
- If unpaid → show payment modal
- If paid → show tracking modal

Tracking Modal must:
- Show image
- Show status
- Show package details
- Never show delivery timeline

------------------------------------------------------------
💳 5. PAYMENT SYSTEM RULES
------------------------------------------------------------

Integration: NowPayments API

Payment Flow:
1. User enters tracking details
2. If payment_status = Unpaid
3. Show payment modal
4. Redirect to NowPayments
5. On success → webhook confirms
6. Update DB
7. Send confirmation email

Webhook:
api/webhooks/webhook.php
Must verify IPN key before processing.
we have to provide nowpayments link to our webhook

API KEY - A83Q59B-TN0MMMF-HRXGB1D-CVSZDJ8
PUBLIC KEY - 6fb89079-a6ca-4691-b7cd-089ab2cc0b4b
IPN KEY - ekWpjdc59WMkPz5f7W1P1vZJe/Z8VHjA

Never expose private keys in frontend.

------------------------------------------------------------
📧 6. EMAIL SYSTEM RULES
------------------------------------------------------------

All emails:
- Modern HTML template
- Include logo
- Consistent design
- Responsive

Triggers:
- Admin login
- Admin register
- Forgot/reset password
- Payment initiated
- Payment confirmed
- Package in transit
- Package delivered
- Contact form submission

User + Admin both receive contact confirmation email.

------------------------------------------------------------
🧠 7. CODE QUALITY RULES
------------------------------------------------------------

- Clean structure
- No duplicate logic
- No unnecessary complexity
- No magic numbers
- No inline JavaScript
- JS must be modular
- Use fetch() for API communication
- Show toast messages for all actions

Error Handling:
- JSON responses only from API
- Structured response:
  {
    status: "success" | "error",
    message: "",
    data: {}
  }

------------------------------------------------------------
📐 8. UI CONSISTENCY RULES
------------------------------------------------------------

All pages must:
- Use same spacing rhythm
- Use same container width logic
- Use same typography scale
- Maintain hierarchy
- No visual hacks

Animations:
- Smooth
- Subtle
- Use transition variable

------------------------------------------------------------
🔒 9. SECURITY RULES
------------------------------------------------------------

- Sanitize input
- Escape output
- CSRF protection for forms
- Secure sessions
- Password hashing (password_hash)
- No plaintext storage

------------------------------------------------------------
🎯 10. CLAUDE BEHAVIOR RULES
------------------------------------------------------------

When generating code:
- Follow architecture strictly
- Do not invent new folders
- Do not change structure
- Do not simplify design token system
- Maintain modular approach

If unclear:
- Ask before assuming

Always behave like:
A senior backend architect building a scalable logistics platform.
