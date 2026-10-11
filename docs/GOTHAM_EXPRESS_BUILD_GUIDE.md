# Gotham Express — Build Guide v2

> Step-by-step execution plan. 7-day sprint. Each day is one build session with a verify gate before moving on. The project plan (GOTHAM_EXPRESS_PROJECT_PLAN.md v3) is the source of truth for what each feature does. This guide is the source of truth for build order.

---

## Pre-Build Checklist

Before Day 1, have these ready:

| Item | Status |
|---|---|
| UI reference images in the project directory | Pending |
| NowPayments sandbox API key | Needed |
| Telegram bot created via BotFather (@GothamExpressBot) | Needed |
| SMTP credentials (spacemail) | Needed |
| Domain configured (gotham.mgbah.dev) | Needed |
| Hetzner VPS provisioned or Coolify instance ready | Needed for Day 7 |
| Coolvetica font files (woff2) | Carry from existing repo |
| Existing database export (for data migration) | Needed for Day 7 |

---

## Day 1: Scaffold + Auth + Design System + UX Foundation

**Goal:** Working auth system, design system applied, full component library ready.

### Build order

1. `laravel new gotham-express` with Inertia + React + Vite
2. Configure MySQL, .env (secrets out of repo from the start)
3. Write all migrations (users, invite_codes, verification_codes, packages, transactions, wallet_addresses, package_status_logs, notification_log, contact_messages)
4. Write seeders: first super admin, payment methods, sample wallet addresses, test packages
5. Set up design system:
   - CSS custom properties on :root with full palette (Pure Black, Cobalt Blue, Tangerine, Petal Peach, grays, semantic colours)
   - Dark mode variables under [data-theme="dark"]
   - Typography scale with Coolvetica
   - Spacing, radius, shadow, transition tokens
6. Build all four layouts: PublicLayout, AuthLayout, AdminLayout, UserLayout (persistent)
7. Build the full UX component library (every component from project plan Section 10.3):
   - Core primitives: Button, FormInput, FormSelect, FormTextarea, CodeInput, Badge, Toast, Modal, ConfirmDialog, Loader, EmptyState
   - Data display: DataTable, Pagination, StatCard, Card, Timeline, StatusTracker, TransactionRow, PackageCard, WalletAddressCard, Avatar, Tag
   - Navigation: Sidebar, SidebarItem, Header, Breadcrumb, Tabs, MobileNav, ThemeToggle
   - Feedback: Tooltip, Alert, Progress, Dropdown, CopyButton, FileUpload, SearchBar, DatePicker, AmountDisplay, QRDisplay
8. Build all hooks: useToast, usePolling, useConfirm, useDebounce, useTheme, useClipboard, usePagination, useFilters
9. Auth system:
   - User registration (name, email, phone, location, password)
   - Email verification via 6-digit code (CodeInput component)
   - Login (shared, routes by role)
   - Forgot password (send code) + verify code + reset password
   - Admin registration via invite code (separate route /admin/register)
   - Logout
   - EnsureRole middleware (super_admin, operator, user)
   - Verified email gate
   - Rate limiting on all auth endpoints
   - Email enumeration protection (generic responses)
   - Code brute-force protection (max 5 attempts)

### Verify

- Register as user, receive code email, verify, login, see user dashboard shell
- Login as seeded super admin, see admin dashboard shell
- Generate invite code from admin, use it to register operator, login as operator
- Forgot password works end to end
- Theme toggle switches dark/light mode across all layouts
- All components render correctly (create a /dev/components test page if needed)
- Rate limiting fires on repeated attempts

---

## Day 2: Public Site + Contact

**Goal:** All marketing pages live and responsive. Contact form working.

### Build order

1. Home page: hero section, stats row, services teaser, how-it-works steps, CTA band
2. About page
3. Services page
4. Contact page + ContactController (store in DB, email sender + admin)
5. Privacy policy page
6. Terms of service page
7. Public navbar with auth links (Login / Register)
8. Footer with brand, links, social
9. Responsive pass on all pages (576, 768, 992, 1200 breakpoints)
10. Dark mode verified on all public pages

### Verify

- All 6 public pages render, are responsive, work in dark mode
- Contact form submits, stores row, emails sender and admin
- No tracking page exists on the public site (removed)
- Navigation links work, auth links route correctly

---

## Day 3: Admin Panel — Dashboard + Package CRUD

**Goal:** Admin can create, edit, track status, and manage packages.

### Build order

1. Admin dashboard: stat cards (total, processing, in_transit, delivered, cancelled), recent transactions table, recent packages list
2. Package index: DataTable with search, filter by status, filter by payment_status, sort by date
3. Package create: full form with all fields + FileUpload for image + TrackingIdService generating GTX-XXXXXXXX
4. Package edit: same form pre-filled + status transition dropdown (limited to allowed transitions per state machine)
5. Package show: full detail view with:
   - Package info card
   - Status timeline from package_status_logs
   - Transaction history for that package
   - Waybill download button
   - QR code display
6. Status transition enforcement: server-side validation, logging to package_status_logs
7. Auto-link: when admin creates package with email matching a registered user, set user_id and queue notification "Your package {tracking_id} has been set for delivery"
8. Status-change notifications queued on in_transit and delivered
9. Package delete with ConfirmDialog (cascades transactions)
10. QR code generation per package (SimpleSoftwareIO/simple-qrcode)
11. Waybill PDF generation (DomPDF, invoice-receipt layout per Section 8.2)

### Verify

- Create package, see in list, edit, change status
- Status transitions enforce rules (no backward from delivered/cancelled)
- Every status change logged and visible in timeline
- Image upload works
- Tracking ID is GTX-XXXXXXXX
- Auto-link fires when recipient email matches a user
- QR code renders with correct URL
- Waybill PDF downloads with correct layout and data
- Delete works with confirmation

---

## Day 4: Admin Panel — Payments + Users + Settings

**Goal:** Full admin operational capability.

### Build order

1. Wallet address management (super only): CRUD, toggle active, set display order
2. Manual payment confirmation: admin selects package, clicks Confirm, enters notes, transaction created as confirmed, package marked paid, notification queued
3. NowPayments integration: PaymentController@createInvoice, NowPaymentsService wrapping API
4. NowPayments webhook: HMAC middleware, idempotent processing, status mapping, notification dispatch
5. Transactions index: DataTable with filters (method, status, date range), summary stats
6. User management (super only): list users, view user detail with their packages, disable/enable
7. Invite code management (super only): generate with tier selection (super/operator), 6-hour expiry, list active/used/expired, revoke unused
8. Audit log (super only): all package_status_logs with filters (by package, by admin, by date)
9. Settings page (super only): general config

### Verify

- Add wallet addresses, see listed with copy buttons
- Confirm manual payment, transaction created, package marked paid
- NowPayments invoice creation works (sandbox)
- Webhook accepts valid signatures, rejects invalid, updates correctly
- Transactions page filters work
- Generate invite codes with both tiers, see listed
- Audit log shows all status changes
- Operator account cannot access settings, invite codes, or audit log

---

## Day 5: User Dashboard + Tracking Map

**Goal:** Complete user experience including the visual tracking interface.

### Build order

1. User dashboard: summary cards (total packages, in transit, delivered, unpaid), recent package list
2. **Tracking page (Tracking.jsx)** — the centerpiece:
   - WorldMap component (react-simple-maps): SVG world map with zoom/pan
   - MapMarker for origin and destination
   - Route line (curved arc between points)
   - RouteAnimation: animated plane/ship icon along route based on status
   - PackageSelector: switch between packages if user has multiple
   - ActivePackageCard: tracking ID, sender, amount, status badge
   - StatusTimeline: vertical timeline from package_status_logs
   - PaymentSection: if unpaid, show wallet addresses + NowPayments button; if paid, show confirmation
3. Packages index: list all user's packages (linked by user_id OR email match)
4. Package detail: status timeline, transaction history, payment interface
5. Payment flow from user side:
   - NowPayments: click Pay, create invoice, redirect
   - Manual: see all active wallet addresses with copy buttons + amount
6. Payment history: all transactions across user's packages
7. Profile page: edit name, phone, location; email change with re-verification; Telegram linking; Telegram toggle (opt in/out)
8. Polling: usePolling on tracking page and package detail (30-second refresh)
9. QR redirect route: /track/{tracking_id} redirects to login if not auth, then to package detail

### Verify

- User sees their packages (auto-linked and manually linked)
- Tracking page renders world map with markers and route line
- Animated icon moves based on package status
- Package selector switches displayed data
- Status timeline shows full history
- NowPayments payment initiates from dashboard
- Wallet addresses display with copy buttons
- Profile edit works, email change triggers re-verification
- Telegram toggle works
- Polling updates status without page reload
- QR scan URL redirects through login to package detail

---

## Day 6: Notifications + Background Jobs + Polish

**Goal:** All notifications firing, background jobs running, polish pass.

### Build order

1. All notification classes (Section 9 of project plan): toMail on each, toTelegram where applicable
2. Email templates: new branded wrapper with Gotham Express design system (black header, blue accents, peach footer)
3. Telegram bot: BotFather setup, /start webhook for chat_id linking, TELEGRAM_BOT_TOKEN config
4. Telegram linking: deep-link in user profile, webhook processing, chat_id + telegram_enabled storage
5. Queue worker config: database driver, process manager setup
6. Scheduled commands:
   - ReconcilePendingPayments (every 30 min)
   - PurgeExpiredVerificationCodes (daily)
   - PurgeExpiredInviteCodes (daily)
   - PurgeOldContactMessages (weekly)
7. Notification logging to notification_log
8. Dark mode pass: verify every page, component, modal in dark mode
9. Responsive pass: verify every page at all breakpoints
10. Error pages: 404, 403, 500 styled with design system
11. Loading states: verify page transitions, skeleton loaders, button spinners all work

### Verify

- Emails fire on: registration, verification, password reset, package creation (auto-link), status change, payment confirmation, contact form
- Telegram bot responds to /start, links chat_id
- Telegram notifications deliver when enabled
- Telegram toggle works (opt out stops Telegram, email continues)
- Queue worker processes jobs, failed jobs logged
- Reconciliation job polls NowPayments for stale pending transactions
- All pages correct in dark mode
- All pages correct on mobile
- Error pages render

---

## Day 7: Data Migration + Rebrand + Deploy

**Goal:** Production-ready, live deployment.

### Build order

1. Rebrand sweep: `grep -ri 'truepath'` and `grep -ri 'TPX-'` across all files. Replace with Gotham Express / GTX-
2. Data migration script: import packages, transactions, users from old DB. Keep TPX- tracking IDs in data (new packages get GTX-). Clean dirty phone/location data
3. Image migration: move uploads/packages/*.jpg to Laravel storage, update paths, run storage:link
4. Secret rotation: new NowPayments API key + IPN secret, new SMTP password if needed, new APP_KEY
5. Security audit: all auth endpoints rate-limited, all admin routes gated, all forms CSRF-protected, no secrets in code, no debug endpoints
6. Deploy to Hetzner via Coolify: MySQL, queue worker, scheduler cron, SSL for gotham.mgbah.dev
7. Smoke test — full journeys:
   - **User journey:** register, verify email, login, view dashboard, view tracking map, see package, copy wallet address, check payment history, edit profile, link Telegram, toggle dark mode
   - **Admin journey:** login, view dashboard, create package (verify auto-link fires), change status (verify notification), confirm manual payment, generate waybill PDF, scan QR code, generate invite code, view audit log, manage wallet addresses
   - **Webhook journey:** simulate NowPayments IPN (sandbox), verify transaction updated, package marked paid, notification sent
8. Switch NowPayments from sandbox to live
9. Verify Telegram notifications delivering in production

### Verify

- Production live at gotham.mgbah.dev
- SSL working
- All old data migrated
- No TruePath/TPX- references in UI or emails (except legacy tracking IDs in data)
- All secrets rotated
- Queue worker running
- Scheduler firing
- Both full journeys pass

---

## Post-Sprint

- [ ] Owner reviews production, tests all flows
- [ ] UI refinements based on additional reference images
- [ ] Monitor error logs and notification delivery for 48 hours
- [ ] Confirm NowPayments webhook receiving in production
- [ ] Confirm Telegram notifications delivering
- [ ] Gather user feedback on tracking map experience
