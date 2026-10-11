# Gotham Express — Day 1 Implementation Plan (CLAUDE_BUILD_PLAN.md)

> Day 1 only. Covers scaffold, env, migrations, seeders, design system, four
> layouts, the full UX component library, hooks, and the auth system.
> No marketing pages, no admin CRUD, no tracking map, no payments, no
> background jobs — those are Days 2–7.

Source documents consulted: [GOTHAM_EXPRESS_PROJECT_PLAN.md](GOTHAM_EXPRESS_PROJECT_PLAN.md),
[GOTHAM_EXPRESS_BUILD_GUIDE.md](GOTHAM_EXPRESS_BUILD_GUIDE.md),
[ARCHITECTURE.md](ARCHITECTURE.md) (legacy system notes), reference images in
[references/](../references/).

---

## 0. Design brief extracted from references/

The references consistently point to a **premium, editorial, high-contrast
aesthetic** — not a generic SaaS look. Key signals that drive Day 1 choices:

- **High-contrast surfaces.** Hero / CTA / footer sections live on near-black
  with glowing warm-light accents; content and data sections sit on
  near-white (`#FAFAFA`-ish). Pages switch surface rather than just block.
- **Editorial display type.** Hero headlines in the references use a slightly
  serifed, large display face mixed with sans-serif body. The project plan
  pins the brand face to Coolvetica (sans), so Day 1 adds **one editorial
  serif** (Instrument Serif or Fraunces) for display-size headings and keeps
  Coolvetica for UI/body.
- **Framed, bracketed layouts.** The hero reference uses tick-marks /
  corner brackets around content blocks. We'll ship that as a `.frame`
  utility rather than a dedicated component.
- **Grid-divider sections.** The stats and feature-main references use
  thin dividers between cells (no shadow, no fill), with oversized numeric
  display. We'll model `StatCard` and `Card--grid` on this.
- **Comparison panel.** The "why-choose-gotham-express" reference highlights
  one column with a soft Petal Peach gradient; `Card--highlight` variant
  handles that.
- **Dark contact form.** The reference contact form sits on black with
  Tangerine CTA. Dark mode must be first-class, not retrofitted, so all form
  components ship both skins on Day 1.

These inform component props and tokens; no marketing markup is built on Day 1.

---

## 1. Day 1 Dependencies and Checks

### 1.1 Pre-conditions

- Node ≥ 20, PHP ≥ 8.3, MySQL ≥ 8, Composer.
- `.env` secrets available (SMTP, APP_KEY, DB creds). NowPayments + Telegram
  secrets **not** needed on Day 1.
- Coolvetica woff2 files copied from the legacy repo at
  `assets/fonts/Coolvetica Rg.woff2` and `Coolvetica Rg It.woff2`.
- Reference images stay in `references/` (not shipped).

### 1.2 Composer packages added on Day 1

| Package | Reason |
|---|---|
| `laravel/framework` | Base |
| `inertiajs/inertia-laravel` | Server adapter |
| `tightenco/ziggy` | Route helper for Inertia pages |
| `laravel/sanctum` | Only if session cookie flow needs it — otherwise skipped |

Day 1 **does not** add DomPDF, SimpleQrCode, react-simple-maps,
NowPayments SDK, or Telegram SDK. Those arrive on the days that use them.

### 1.3 npm packages added on Day 1

| Package | Reason |
|---|---|
| `react`, `react-dom` | SPA runtime |
| `@inertiajs/react` | Client adapter |
| `@vitejs/plugin-react`, `vite`, `laravel-vite-plugin` | Build |
| `@phosphor-icons/react` | Icon set — matches brand (bold face) and avoids CDN dep |
| `clsx` | Conditional class helper used by every component |
| `@tailwindcss/forms` | **Optional.** We go **no-Tailwind** on Day 1 — see §3. If the owner wants Tailwind, swap in. |
| `vitest`, `@testing-library/react` | Light component tests (smoke only on Day 1) |

Decision: **plain CSS with design tokens**, not Tailwind. The legacy repo
and the project plan explicitly specify CSS custom properties. Tailwind can
be layered on later without rewriting components.

---

## 2. File-Creation Order (end-to-end)

High-level sequence. Section numbers point at the detailed file lists below.

1. **Scaffold** (§3) — Laravel skeleton, Inertia + React + Vite wired.
2. **Env, config, DB connection** (§4).
3. **Migrations** (§5) — all 9 tables.
4. **Seeders + factories** (§6) — first super admin, sample wallets, sample
   packages, test user.
5. **Enums + models + policies** (§7) — PHP enums for roles and statuses,
   Eloquent models with relationships and policies.
6. **Design-system CSS** (§8) — tokens, dark-mode overrides, base typography,
   font-face.
7. **Layout React components** (§9) — PublicLayout, AuthLayout, AdminLayout,
   UserLayout.
8. **UX primitives** (§10) — all core, data-display, nav, and feedback
   components from the project plan section 10.3 that are **UI only** (map
   components wait for Day 5).
9. **Hooks** (§11) — all eight.
10. **Auth backend** (§12) — controllers, requests, services, notifications,
    middleware.
11. **Auth frontend** (§13) — six auth pages wired to the controllers.
12. **Dev components gallery route** (§14) — `/dev/components`,
    `local`-only.
13. **Verification checklist** (§15).

Each sub-section lists the files in the order to create them so the editor's
dependency chain stays linear (no "create X but it needs Y first" surprises).

---

## 3. Scaffold

| # | File | Purpose |
|---|---|---|
| 3.1 | `composer.json`, `composer.lock` | Generated by `laravel new gotham-express --git`; add Inertia + Ziggy |
| 3.2 | `package.json`, `package-lock.json` | Add React, Inertia, Phosphor, clsx |
| 3.3 | `vite.config.js` | React plugin, Laravel plugin, `resources/js/app.jsx` entry, `resources/css/app.css` entry, alias `@` → `resources/js` |
| 3.4 | `.gitignore` | Add `.env`, `envlocal`, `envprod`, `storage/*.key`, `vendor/`, `node_modules/`, `public/build/`, `.phpunit.result.cache` |
| 3.5 | `.env.example` | Document every env key with safe defaults; the actual `.env` stays out of git from the start (lesson from the legacy repo) |
| 3.6 | `resources/views/app.blade.php` | Inertia root template — `@viteReactRefresh`, `@vite(['resources/css/app.css', 'resources/js/app.jsx'])`, `@inertiaHead`, `@inertia`, `<html data-theme="...">` from a server-side theme cookie read |
| 3.7 | `resources/js/app.jsx` | Inertia bootstrap: `createInertiaApp`, dynamic page import, `root.render(<App ... />)`, progress bar colour via `--color-blue` |
| 3.8 | `resources/js/ssr.jsx` | **Omitted on Day 1.** Can be added later if SSR is wanted |
| 3.9 | `app/Http/Middleware/HandleInertiaShared.php` | Shared props: `auth.user` (safe fields only), `flash` (success/error), `csrf_token`, `theme` (light/dark from cookie) |
| 3.10 | `bootstrap/app.php` | Register `HandleInertiaShared`, `EnsureRole`, `EnsureEmailVerified` middleware aliases, throttle middleware |
| 3.11 | `tests/Pest.php` or `tests/TestCase.php` | Base test case. Pest preferred for brevity |

Day-1 convention: **do not** touch `routes/web.php` for admin/user routes yet
beyond what §12 and §13 require. We ship the auth routes only. Marketing
pages are Day 2.

---

## 4. Env and Config

| # | File | Purpose |
|---|---|---|
| 4.1 | `.env` | Real secrets, chmod 600, **never committed**. Keys: `APP_NAME="Gotham Express"`, `APP_URL=https://gotham.mgbah.dev`, `APP_ENV=local`, `APP_KEY=`, DB_*, `MAIL_*` (spacemail SMTPS 465), `SESSION_DRIVER=cookie` initially (DB sessions can be enabled after sessions migration), `QUEUE_CONNECTION=sync` on Day 1 (`database` on Day 6), `MAIL_FROM_ADDRESS=support@gotham.mgbah.dev` |
| 4.2 | `.env.example` | Mirror of `.env` with empty values |
| 4.3 | `config/app.php` | `name`, `url`, timezone `UTC` |
| 4.4 | `config/auth.php` | Default guard `web`, password broker uses our custom code flow — see §12 |
| 4.5 | `config/mail.php` | SMTP settings pulled from env |
| 4.6 | `config/gotham.php` | **New.** Project-local config: `invite_code.expiry_hours=6`, `verification_code.expiry_minutes=60`, `password_reset_code.expiry_minutes=15`, `password_reset_code.max_attempts=5`, `telegram.bot_handle='@GothamExpressBot'`, `tracking_id.prefix='GTX-'`. Code reads from here, never literals |

---

## 5. Migrations (`database/migrations/`)

Created in dependency order so FKs resolve on `migrate:fresh`. Timestamps use
Laravel's `create_*_table_YYYY_MM_DD_HHMMSS` pattern — only the slug matters
for review:

| # | Migration slug | Purpose |
|---|---|---|
| 5.1 | `*_create_users_table` | `id`, `name`, `email` (unique), `password`, `phone`, `location`, `role` enum (`super_admin`, `operator`, `user`) default `user`, `telegram_chat_id` nullable, `telegram_enabled` bool default false, `email_verified_at` nullable, timestamps, soft deletes. Overrides Laravel's default `users` migration |
| 5.2 | `*_create_password_reset_tokens_table` | **Delete the Laravel default.** We use `verification_codes` instead |
| 5.3 | `*_create_sessions_table` | Laravel's default (DB session driver — flipped on in Day 6 if desired) |
| 5.4 | `*_create_cache_table` | Laravel default (cache lock) |
| 5.5 | `*_create_jobs_table` | Laravel default queue schema (needed by `php artisan queue:table` output) — Day 6 flips the driver on |
| 5.6 | `*_create_invite_codes_table` | `id`, `code` unique indexed, `tier` enum (`super`, `operator`), `created_by` FK users nullable (seed admin creates the first codes), `used_by` FK users nullable, `used_at` nullable, `expires_at`, timestamps |
| 5.7 | `*_create_verification_codes_table` | `id`, `email` indexed, `code` (6-digit string), `type` enum (`email_verify`, `password_reset`), `attempts` tinyint default 0, `expires_at`, `used_at` nullable, timestamps |
| 5.8 | `*_create_wallet_addresses_table` | `id`, `label`, `currency`, `network`, `address`, `is_active` bool, `display_order` int, timestamps |
| 5.9 | `*_create_packages_table` | `id`, `tracking_id` unique, `package_name`, `amount` decimal(12,2), `description` text nullable, `invoice_message` text nullable, `sender`, `phone`, `firstname`, `lastname`, `email` indexed, `address`, `location`, `address_type`, `image` nullable, `status` enum (`processing`, `in_transit`, `delivered`, `cancelled`) default `processing`, `payment_status` enum (`unpaid`, `paid`) default `unpaid`, `created_by` FK users, `user_id` FK users nullable, timestamps |
| 5.10 | `*_create_transactions_table` | `id`, `package_id` FK packages cascade, `payment_method` enum (`nowpayments`, `manual_crypto`), `payment_id` nullable, `payment_status` enum (`pending`, `confirmed`, `failed`, `expired`) default `pending`, `amount` decimal, `currency` default `USD`, `payer_email`, `payment_url` nullable, `confirmed_by` FK users nullable, `notes` text nullable, timestamps |
| 5.11 | `*_create_package_status_logs_table` | `id`, `package_id` FK cascade, `from_status`, `to_status`, `changed_by` FK users nullable, `notes` text nullable, `created_at` only |
| 5.12 | `*_create_notification_log_table` | `id`, `user_id` FK users nullable, `package_id` FK packages nullable, `channel` enum (`email`, `telegram`), `type` string, `sent_at` nullable, `failed_at` nullable, timestamps |
| 5.13 | `*_create_contact_messages_table` | `id`, `firstname`, `email`, `inquiry`, `message`, `responded_at` nullable, `created_at` |

Migrations run clean on `php artisan migrate:fresh`.

---

## 6. Seeders and Factories

### 6.1 Factories (`database/factories/`)

| # | File | Purpose |
|---|---|---|
| 6.1.1 | `UserFactory.php` | Faker-driven; states `superAdmin()`, `operator()`, `verified()`, `unverified()` |
| 6.1.2 | `PackageFactory.php` | Random tracking IDs via `TrackingIdService`; recipient fields from Faker; status weighted toward `processing` |
| 6.1.3 | `WalletAddressFactory.php` | A couple of realistic USDT/BTC addresses (dummy strings) |
| 6.1.4 | `InviteCodeFactory.php` | Alphanumeric 10-char `code`, 6 h expiry; `used()` state |

### 6.2 Seeders (`database/seeders/`)

| # | File | Purpose |
|---|---|---|
| 6.2.1 | `DatabaseSeeder.php` | Orchestrator; only runs the seeders below |
| 6.2.2 | `SuperAdminSeeder.php` | Creates the first `super_admin` from env (`SEED_ADMIN_EMAIL`, `SEED_ADMIN_PASSWORD`); fails loudly if missing. Idempotent (`firstOrCreate`) |
| 6.2.3 | `WalletAddressSeeder.php` | 3 active sample wallets (USDT-TRC20, BTC, ETH) — placeholder addresses only, flagged by comment |
| 6.2.4 | `TestUserSeeder.php` | Only in `local`/`testing`. Creates one verified `user@example.com` and a couple of sample packages linked to them so the user dashboard has data on Day 5 |

The seeder for sample packages exists on Day 1 but is harmless because
Day 1's UI doesn't surface packages yet; it's there so Day 5 opens with
immediate test data.

---

## 7. Enums, Models, Policies

### 7.1 Enums (`app/Enums/`)

| # | File | Purpose |
|---|---|---|
| 7.1.1 | `UserRole.php` | Backed enum: `SuperAdmin`, `Operator`, `User`. Helpers: `isAdmin()`, `canManageAdmins()` |
| 7.1.2 | `PackageStatus.php` | `Processing`, `InTransit`, `Delivered`, `Cancelled`. `canTransitionTo(self $next): bool` encodes the state machine so controllers reuse it |
| 7.1.3 | `PaymentStatus.php` | `Unpaid`, `Paid` (package-level) |
| 7.1.4 | `TransactionStatus.php` | `Pending`, `Confirmed`, `Failed`, `Expired` |
| 7.1.5 | `PaymentMethod.php` | `NowPayments`, `ManualCrypto` |
| 7.1.6 | `InviteTier.php` | `Super`, `Operator` |
| 7.1.7 | `VerificationCodeType.php` | `EmailVerify`, `PasswordReset` |
| 7.1.8 | `NotificationChannel.php` | `Email`, `Telegram` |

Enums are added **on Day 1** even for Day 2+ features, because they are
imported by the migrations' `->default(...)` and the models' `$casts`.

### 7.2 Models (`app/Models/`)

| # | File | Purpose |
|---|---|---|
| 7.2.1 | `User.php` | Extends `Authenticatable`; `MustVerifyEmail` not used (custom flow); `$casts` for `role`, `email_verified_at`, `telegram_enabled`; relationships `packagesCreated()`, `packagesOwned()`, `transactionsConfirmed()`, `inviteCodesCreated()`, `inviteCodesUsed()` |
| 7.2.2 | `Package.php` | `$casts` for `status`, `payment_status`, `amount`; relations `creator()`, `owner()`, `transactions()`, `statusLogs()` |
| 7.2.3 | `Transaction.php` | Casts; `package()`, `confirmer()` |
| 7.2.4 | `WalletAddress.php` | Scope `active()`, `ordered()` |
| 7.2.5 | `InviteCode.php` | Scopes `active()`, `used()`, `expired()`; method `isUsable()` |
| 7.2.6 | `VerificationCode.php` | Scopes `active()`; methods `isValid()`, `markUsed()`, `incrementAttempts()` |
| 7.2.7 | `PackageStatusLog.php` | — |
| 7.2.8 | `NotificationLog.php` | — |
| 7.2.9 | `ContactMessage.php` | — |

### 7.3 Policies (`app/Policies/`) — stubs only on Day 1

| # | File | Purpose |
|---|---|---|
| 7.3.1 | `PackagePolicy.php` | Day 1: `viewAny`, `view`, `create`, `update`, `delete` methods present but return false unless user is admin. Fleshed out Day 3 |
| 7.3.2 | `UserManagementPolicy.php` | `canManageAdmins` → `SuperAdmin` only. Used by invite-code generation on Day 4 but imported now so routes can gate correctly |

Register in `app/Providers/AuthServiceProvider.php`.

---

## 8. Design System CSS

Single source of truth lives in `resources/css/`. Entry point `app.css`
imports the sub-files in order so cascade is predictable.

| # | File | Purpose |
|---|---|---|
| 8.1 | `resources/css/app.css` | Entry: `@import` the files below, nothing else |
| 8.2 | `resources/css/tokens.css` | **The design token file.** `:root` light tokens; `:root[data-theme="dark"]` dark overrides. Palette (black, blue `#3478F7`, orange `#EC562E`, peach `#F3D2C6`, grays, success/error/warning/info), typography scale, spacing, radii, shadows, transitions, container widths, z-index scale, breakpoints |
| 8.3 | `resources/css/fonts.css` | `@font-face` for Coolvetica (regular + italic) + one editorial display face loaded from Google Fonts via `<link>` in app.blade.php (listed in §3.6). Fallbacks `system-ui, sans-serif` |
| 8.4 | `resources/css/reset.css` | Modern reset (box-sizing, margin zero, body line-height, `img { display:block; max-width:100% }`, focus-visible defaults, `color-scheme: light dark`) |
| 8.5 | `resources/css/base.css` | Element defaults using tokens: body font/colour/bg, link colour, heading sizes, lists, forms baseline. Uses `color-scheme` so native scrollbars track theme |
| 8.6 | `resources/css/utilities.css` | Short list of reusable utilities: `.container`, `.stack-*` (vertical rhythm), `.row`, `.cluster`, `.frame` (the bracketed-corner look from the hero reference), `.sr-only`, `.visually-hidden`, `.text-{sm,base,lg,xl}` |
| 8.7 | `resources/css/components/*.css` | Per-component CSS files — one per component below. Each co-located visually in `components/`. Keeps diff review simple |
| 8.8 | `resources/css/responsive.css` | Four breakpoint blocks at 576/768/992/1200. Density tweaks only; layouts stay fluid |

**Tokens — authoritative list** (what Day 1 commits):

```
Colors
  --color-black #000000
  --color-blue  #3478F7
  --color-orange #EC562E
  --color-peach  #F3D2C6
  --color-white  #FFFFFF
  --color-gray-50/100/200/400/600/800
  --color-success #16A34A
  --color-error   #DC2626
  --color-warning #F59E0B
  --color-info    #3478F7

  Semantic (light default)
  --surface, --surface-alt, --surface-inverse
  --text, --text-muted, --text-inverse
  --border, --border-strong
  --accent (blue), --accent-warm (orange), --accent-soft (peach)
  --focus-ring (blue at 40% alpha)

Typography
  --font-sans: 'Coolvetica', 'Inter', system-ui, sans-serif
  --font-display: 'Fraunces', 'Instrument Serif', Georgia, serif
  --font-mono: ui-monospace, SFMono-Regular, Menlo, monospace
  --font-size-xs through --font-size-4xl (per project plan 5.3)
  --line-height-{tight,snug,normal,relaxed}
  --letter-spacing-{tight,normal,wide}

Spacing  --space-0 … --space-5xl (4px step, named)
Radius   --radius-{sm,md,lg,xl,full}
Shadow   --shadow-{sm,md,lg,xl} + --shadow-focus
Transition --transition-{fast,base,slow}
Z-index --z-{dropdown=1000, sticky=1100, overlay=1200, modal=1300, toast=1400, tooltip=1500}
Breakpoints via @media (literal values, not vars — CSS does not substitute vars in @media)
```

**Dark mode:** every semantic token is reassigned under
`:root[data-theme="dark"]`. Palette tokens (hex) stay fixed; only
`--surface*`, `--text*`, `--border*`, `--accent-soft`, and shadow intensities
flip. `color-scheme` set to `dark` under the dark root so form controls follow.

---

## 9. Layouts (`resources/js/Layouts/`)

All four layouts ship on Day 1. They render shells only — the actual pages
mounted inside come across the week.

| # | File | Purpose |
|---|---|---|
| 9.1 | `AppProviders.jsx` | Wraps the Inertia page tree with `ToastProvider` and `ConfirmProvider` and reads initial theme from a `data-theme` attribute on `<html>` set server-side |
| 9.2 | `PublicLayout.jsx` | Marketing shell: `PublicNav`, slot, `PublicFooter`. Dark-cream surface by default. Used Day 2 but ships Day 1 |
| 9.3 | `AuthLayout.jsx` | Two-pane: left pane black with brand mark + a short tagline + a looping ambient visual (CSS gradient placeholder for now; swapped for the Arrakis-style aurora later). Right pane white/cream card with the auth form. Mobile collapses to form-only. **Full dark-mode support** |
| 9.4 | `AdminLayout.jsx` | Persistent Inertia layout. `AdminSidebar` + `AdminHeader` + `<main class="admin-content">{children}</main>`. Flash toasts rendered here |
| 9.5 | `UserLayout.jsx` | Persistent Inertia layout. `UserSidebar` + `UserHeader` + content. Lighter chrome than admin |
| 9.6 | `PublicNav.jsx` | Site nav — placeholder links (Home, About, Services, Contact, Login, Register). Scrolled state class via scroll listener |
| 9.7 | `PublicFooter.jsx` | 3-column footer per the reference image (brand, links, legal). Dark surface |
| 9.8 | `AdminSidebar.jsx` | Dashboard, Packages, Transactions dividers; sub-section links greyed/disabled on Day 1 (they route to 404 until Days 3–4). Bottom shows user info + ThemeToggle + logout |
| 9.9 | `AdminHeader.jsx` | Page title (from Inertia page prop), breadcrumbs placeholder, user dropdown |
| 9.10 | `UserSidebar.jsx` | Dashboard, Tracking, Packages, Payments, Profile — all route to `/dashboard/...`. Items greyed until Day 5 |
| 9.11 | `UserHeader.jsx` | Welcome line + ThemeToggle + user menu |

Layouts assign `data-layout` on their root so `components/*.css` can scope.

---

## 10. UX Component Library (`resources/js/Components/`)

Every component on this list ships on Day 1 **except** the four map/tracking
components (`WorldMap`, `MapMarker`, `RouteAnimation`, `PackageSelector`),
which land on Day 5 alongside their consumer. Each component has:

- `ComponentName.jsx` (named export)
- `ComponentName.module.css` **or** a line in `resources/css/components/`.
  Decision: use **plain CSS classes namespaced `.ge-componentname__part`** and
  co-locate in `resources/css/components/componentname.css`. CSS Modules add
  a Vite+SSR complication we don't need yet.
- A story / usage snippet in the `/dev/components` gallery (§14).
- Dark-mode verified via token swap only. No hard-coded colours anywhere.
- Prop API documented in a short JSDoc block at the top.

### 10.1 Core primitives — `Components/Primitives/`

| # | File | Props sketch |
|---|---|---|
| 10.1.1 | `Button.jsx` | `variant: primary\|secondary\|outline\|ghost\|danger`, `size: sm\|md\|lg`, `loading`, `icon`, `iconPosition`, `fullWidth`, native `type`/`disabled`/`onClick`. Keyboard focus-ring via `--focus-ring`. Primary = Cobalt Blue, Danger = `--color-error`, "warm" implicit via `variant='secondary'` on Orange CTAs on marketing pages |
| 10.1.2 | `FormField.jsx` | Internal wrapper used by inputs: `label`, `required`, `error`, `helpText`, `id`. Keeps a11y wiring in one place |
| 10.1.3 | `FormInput.jsx` | Wraps FormField; forwards ref; integrates with `useForm` by expecting `name` + `value` + `onChange` |
| 10.1.4 | `FormSelect.jsx` | Native `<select>` first; a `Dropdown`-based alternative in future if needed |
| 10.1.5 | `FormTextarea.jsx` | `rows`, `maxLength`, optional `showCount` |
| 10.1.6 | `FormCheckbox.jsx` | Custom-styled, keyboard friendly |
| 10.1.7 | `CodeInput.jsx` | 6-digit verification input. 6 `<input maxlength="1" inputmode="numeric">` boxes, auto-advance on type, backspace moves back, full paste support (`onPaste` splits across boxes), `onComplete(code)`. Error shake animation on invalid |
| 10.1.8 | `Badge.jsx` | `tone: success\|error\|warning\|info\|neutral`, `size: sm\|md`, optional `dot`. Tones map to `--color-*` tokens so dark mode works unchanged |
| 10.1.9 | `Toast.jsx` + `ToastProvider.jsx` + `useToast.js` (hook co-located in §11) | Fixed container top-right (bottom on mobile), stackable, auto-dismiss (default 4 s), tones mirror Badge, swipe-dismiss on mobile |
| 10.1.10 | `Modal.jsx` | Focus trap, Escape to close, click-outside, body-scroll lock, `size: sm\|md\|lg\|full`, slots via `Modal.Header`, `Modal.Body`, `Modal.Footer`. On mobile (≤768) switches to bottom-sheet slide-up to match the legacy project rule |
| 10.1.11 | `ConfirmDialog.jsx` + `ConfirmProvider.jsx` + `useConfirm.js` | Promise-based: `await confirm({title, message, confirmLabel, danger})` resolves true/false |
| 10.1.12 | `Loader.jsx` | Three modes: `mode='bar'` (top progress bar, used by Inertia start/finish events), `mode='skeleton'` (block-level shimmer), `mode='spinner'` (inline) |
| 10.1.13 | `EmptyState.jsx` | `icon`, `title`, `message`, `action` slot |

### 10.2 Data display — `Components/Data/`

| # | File | Notes |
|---|---|---|
| 10.2.1 | `Card.jsx` | Slots: `Card.Header`, `Card.Body`, `Card.Footer`. Variants: `bordered` (default), `elevated`, `highlight` (soft peach gradient — matches the comparison reference), `inverse` (dark surface for CTA band) |
| 10.2.2 | `StatCard.jsx` | Icon slot, big display-font value, label underneath, optional trend `+12% vs last week`. Grid variant (no border radius, divider-based) matches the `featuremain` reference layout — expose as `variant='grid'` |
| 10.2.3 | `Timeline.jsx` | Vertical stepper. Items `{ title, timestamp, state: 'completed'\|'active'\|'pending', notes? }`. Dot + connector style. Used by both admin audit log and user tracking |
| 10.2.4 | `StatusTracker.jsx` | Horizontal 3-step tracker (Processing → Shipped → Delivered). Receives `PackageStatus` enum value, maps internally. Mirrors the legacy UI step id `shipped` for `in_transit` |
| 10.2.5 | `DataTable.jsx` | Composed of `DataTable.Toolbar` (search + filters), `.Head` (sortable column config), `.Row`, `.Pagination`. Responsive: switches to card list on mobile. Day 1 ships the composition shell + styling; the sort/filter wiring is server-driven via Inertia (`usePagination`, `useFilters`) so the component itself stays stateless |
| 10.2.6 | `Pagination.jsx` | Works with Laravel paginator meta: `{current_page, last_page, links}`. Prev/next buttons, numbered page dots |
| 10.2.7 | `TransactionRow.jsx` | Opinionated row for Transactions tables: amount formatted via AmountDisplay, status Badge, truncated payment id with CopyButton, date |
| 10.2.8 | `PackageCard.jsx` | Tracking ID, package name, recipient, status badge, payment badge, quick-actions dropdown |
| 10.2.9 | `WalletAddressCard.jsx` | Currency chip + network label + monospaced address + CopyButton + QR shortcut (`QRDisplay` opens a modal with the address QR). Design matches "comparison" ref highlight card for visual weight |
| 10.2.10 | `Avatar.jsx` | Initials fallback, `size: xs\|sm\|md\|lg`, colour hashed from name for consistent user tint |
| 10.2.11 | `Tag.jsx` | Small label chip; `removable` variant with `onRemove` |

### 10.3 Navigation and layout — `Components/Nav/`

| # | File | Notes |
|---|---|---|
| 10.3.1 | `Sidebar.jsx`, `SidebarItem.jsx` | Collapsible, section dividers, mobile drawer behaviour, active-link detection via Inertia `usePage().url` |
| 10.3.2 | `Header.jsx` | Admin + User use their own wrappers; this one is the shared composable building block (title + breadcrumbs + actions slot) |
| 10.3.3 | `Breadcrumb.jsx` | Takes `{ label, href }[]`; last item non-link |
| 10.3.4 | `Tabs.jsx` + `Tabs.Panel` | Keyboard accessible (`role=tablist`), URL-sync optional via `queryParam` prop |
| 10.3.5 | `MobileNav.jsx` | Bottom-fixed on narrow screens for user dashboard main sections. Hidden on desktop |
| 10.3.6 | `ThemeToggle.jsx` | Phosphor sun/moon icon. Toggles `data-theme` on `<html>`, persists to `localStorage`, posts to `/preferences/theme` so the server-side `app.blade.php` renders the correct initial attribute on next load (prevents FOUC) |

### 10.4 Feedback and interaction — `Components/Feedback/`

| # | File | Notes |
|---|---|---|
| 10.4.1 | `Tooltip.jsx` | Hover-triggered, keyboard-focus triggered; portal to avoid overflow clipping |
| 10.4.2 | `Alert.jsx` | Banner alert: `tone`, `title`, children, `dismissible` |
| 10.4.3 | `Progress.jsx` | Linear bar, 0–100%; indeterminate mode too |
| 10.4.4 | `Dropdown.jsx` | Click-triggered menu, closes on outside click + Escape, keyboard arrow navigation |
| 10.4.5 | `CopyButton.jsx` | Click copies to clipboard; swaps icon to check for 2 s; uses `useClipboard` |
| 10.4.6 | `FileUpload.jsx` | Dropzone + click-to-select; preview thumbnail for images; size/type validation surfaced via `error` prop; emits File on `onChange` |
| 10.4.7 | `SearchBar.jsx` | Input with search icon, clears via `x`, debounced via `useDebounce` |
| 10.4.8 | `DatePicker.jsx` | Day 1 ships a native `<input type="date">` wrapped for consistent styling + `rangeMode` using two inputs. A fancier picker can replace it later without API change |
| 10.4.9 | `AmountDisplay.jsx` | `value` + `currency` (default USD); uses `Intl.NumberFormat`; tabular numerals via CSS |
| 10.4.10 | `QRDisplay.jsx` | Day 1 **stub**: renders a placeholder tile with a `Coming soon` note. Real implementation lands Day 3 alongside the server-side QR generator. Ships now so pages compile |

### 10.5 Map and tracking — **not Day 1**

`WorldMap`, `MapMarker`, `RouteAnimation`, `PackageSelector` land Day 5
with the user Tracking page. Added here only to confirm the Day-1 scope.

### 10.6 Component gallery route

`/dev/components` renders every component once with its states. See §14.

---

## 11. Hooks (`resources/js/Hooks/`)

| # | File | Purpose |
|---|---|---|
| 11.1 | `useToast.js` | Hook into `ToastProvider`. Returns `{ success, error, info, warning, dismiss }` |
| 11.2 | `useConfirm.js` | Returns an `async confirm(opts) => boolean` |
| 11.3 | `usePolling.js` | Wraps Inertia `router.reload({ only: [...], onFinish })` on an interval; `start`, `stop`, pauses when `document.hidden` |
| 11.4 | `useDebounce.js` | Classic debounced value hook |
| 11.5 | `useTheme.js` | Reads `document.documentElement.dataset.theme`, exposes `toggle()`, writes back + persists cookie |
| 11.6 | `useClipboard.js` | `copy(text)`, `copied` boolean with configurable reset ms |
| 11.7 | `usePagination.js` | Reads page/perPage from Inertia URL params, exposes setters that `router.get` with `preserveState`/`preserveScroll` |
| 11.8 | `useFilters.js` | Same pattern as pagination but for an arbitrary filter object. Debounced via `useDebounce` |

All hooks are plain React — no external state library.

---

## 12. Auth Backend

### 12.1 Routes (`routes/auth.php` imported from `routes/web.php`)

```
GET  /login                       Auth\LoginController@create
POST /login                       Auth\LoginController@store         (throttle:5,1)
POST /logout                      Auth\LoginController@destroy       (auth)
GET  /register                    Auth\RegisterController@create
POST /register                    Auth\RegisterController@store      (throttle:3,10)
GET  /verify-email                Auth\VerifyEmailController@create  (auth, unverified)
POST /verify-email                Auth\VerifyEmailController@store   (auth, unverified, throttle:5,15)
POST /verify-email/resend         Auth\VerifyEmailController@resend  (auth, unverified, throttle:3,10)
GET  /forgot-password             Auth\ForgotPasswordController@create
POST /forgot-password             Auth\ForgotPasswordController@store (throttle:3,10)
GET  /verify-reset-code           Auth\VerifyResetCodeController@create
POST /verify-reset-code           Auth\VerifyResetCodeController@store (throttle:5,15)
GET  /reset-password              Auth\ResetPasswordController@create
POST /reset-password              Auth\ResetPasswordController@store
GET  /admin/register              Auth\AdminRegisterController@create
POST /admin/register              Auth\AdminRegisterController@store (throttle:5,10)
POST /preferences/theme           Preferences\ThemeController@update  (optional-auth)
```

Rate limiter rules centralised in `app/Providers/RouteServiceProvider.php`.

### 12.2 Controllers (`app/Http/Controllers/Auth/`)

| # | File | Notes |
|---|---|---|
| 12.2.1 | `LoginController.php` | `create` renders `Auth/Login.jsx`; `store` validates, `attempt`, regenerates session, redirects based on role; `destroy` logs out |
| 12.2.2 | `RegisterController.php` | `create` renders `Auth/Register.jsx`; `store` creates user with `role=user`, dispatches `SendEmailVerificationCode`, logs them in (unverified), redirects to `/verify-email` |
| 12.2.3 | `VerifyEmailController.php` | Shows the 6-digit entry page; validates the code via `VerificationCodeService`; sets `email_verified_at`; redirects to user dashboard. `resend` throttles and regenerates a code |
| 12.2.4 | `ForgotPasswordController.php` | Always returns a generic success (anti-enumeration). If user exists, dispatches `SendPasswordResetCode` and redirects to `/verify-reset-code?email=...` (email in signed URL so a tampered email doesn't help the next step) |
| 12.2.5 | `VerifyResetCodeController.php` | Validates code; on success, stores a short-lived signed URL token in the session and redirects to `/reset-password` |
| 12.2.6 | `ResetPasswordController.php` | Shows the password form; `store` validates (min 10 chars, confirmation, zxcvbn-ish via `Password::defaults()`), updates, logs user in, redirects by role |
| 12.2.7 | `AdminRegisterController.php` | Shows admin register with invite-code field; `store` validates code via `InviteCodeService`, creates user with role mapped from `tier`, marks the code used, logs in, redirects to admin dashboard |

### 12.3 Form requests (`app/Http/Requests/Auth/`)

| # | File |
|---|---|
| 12.3.1 | `LoginRequest.php` |
| 12.3.2 | `RegisterRequest.php` |
| 12.3.3 | `VerifyEmailRequest.php` |
| 12.3.4 | `ForgotPasswordRequest.php` |
| 12.3.5 | `VerifyResetCodeRequest.php` |
| 12.3.6 | `ResetPasswordRequest.php` |
| 12.3.7 | `AdminRegisterRequest.php` |

Validation uses `Password::defaults()`, `phone` kept as free text (format
check deferred), `location` free text, `invite_code` `exists:invite_codes,code`
plus a custom `UsableInviteCode` rule.

### 12.4 Services (`app/Services/`)

| # | File | Purpose |
|---|---|---|
| 12.4.1 | `VerificationCodeService.php` | `issue(email, type)` → stores a sha256 hash of a 6-digit code with the right expiry; `verify(email, code, type)` → increments attempts, blocks after 5, consumes on success; `purgeExpired()` for the Day-6 cleanup job to call |
| 12.4.2 | `InviteCodeService.php` | `generate(tier, createdBy)`, `validate(code)`, `consume(code, user)` |
| 12.4.3 | `TrackingIdService.php` | `generate()` returns `GTX-XXXXXXXX`. Day-1 scope: only the service, not any consumer. Day 3 uses it |

Codes stored as `hash('sha256', $code)` so a DB dump doesn't leak live reset
codes. Comparison via `hash_equals`.

### 12.5 Notifications (`app/Notifications/Auth/`)

Day 1 ships three email notifications. Templates use the new design-system
colours but the HTML is a lightweight branded wrapper — the full redesign
is Day 6.

| # | File | Purpose |
|---|---|---|
| 12.5.1 | `SendEmailVerificationCode.php` | Queued (though queue is `sync` on Day 1, so sends inline). Includes 6-digit code and expiry window |
| 12.5.2 | `SendPasswordResetCode.php` | 6-digit code, 15 min expiry, max-attempts hint |
| 12.5.3 | `PasswordChanged.php` | Confirmation after a successful reset |

### 12.6 Middleware (`app/Http/Middleware/`)

| # | File | Purpose |
|---|---|---|
| 12.6.1 | `EnsureRole.php` | `->middleware('role:super_admin,operator')` style check. 403 on fail |
| 12.6.2 | `EnsureEmailVerified.php` | Redirects to `/verify-email` if `email_verified_at` null and route not whitelisted |
| 12.6.3 | `RedirectIfAuthenticated.php` | Keeps logged-in users out of auth pages. Routes by role: super_admin/operator → `/admin/dashboard`, user → `/dashboard` |

Registered in `bootstrap/app.php` with aliases `role`, `verified.email`,
`guest.redirect`.

### 12.7 Shared Inertia props

`HandleInertiaShared` adds:
- `auth.user`: `{ id, name, email, role, telegram_enabled, email_verified_at }`
- `flash`: `{ success, error, info }`
- `theme`: `'light' | 'dark'` from cookie
- `ziggy`: route data

---

## 13. Auth Frontend (`resources/js/Pages/Auth/`)

Each page uses `AuthLayout` and `useForm` from `@inertiajs/react`. All six
support dark mode via tokens only.

| # | File | Purpose |
|---|---|---|
| 13.1 | `Login.jsx` | Email + password + "forgot password" link + register link. Submits to `POST /login`. Server flash drives Toast |
| 13.2 | `Register.jsx` | Name, email, phone, location, password, confirm. Submits to `POST /register`. On success, Inertia redirects to Verify page |
| 13.3 | `VerifyEmail.jsx` | `CodeInput` for 6-digit code. Resend button with cooldown. On success, redirect handled by server |
| 13.4 | `ForgotPassword.jsx` | Email input only. Submit shows generic success message regardless of result (anti-enumeration) |
| 13.5 | `VerifyResetCode.jsx` | `CodeInput`; email preserved in URL (signed) and shown muted. On success, server redirects to Reset |
| 13.6 | `ResetPassword.jsx` | New password + confirm. Server validates, logs user in, redirects |
| 13.7 | `AdminRegister.jsx` | Same shape as Register plus `invite_code` field with inline validation hint |

Shared behaviours in `Pages/Auth/_shared/` (if the duplication grows):

| # | File | Purpose |
|---|---|---|
| 13.8 | `AuthCard.jsx` | Visual wrapper: title + subtitle + children + alt-action footer line ("Already have an account? Log in") |

---

## 14. Dev Components Gallery

| # | File | Purpose |
|---|---|---|
| 14.1 | `routes/dev.php` (loaded only when `APP_ENV !== 'production'`) | Registers `GET /dev/components` → `DevController@components` |
| 14.2 | `app/Http/Controllers/DevController.php` | Renders `Dev/Components.jsx` with no data |
| 14.3 | `resources/js/Pages/Dev/Components.jsx` | Grid gallery: one card per component, each showing default + relevant states (loading, error, disabled, variants). Includes a sticky Theme Toggle so dark/light can be verified visually in one place. Also includes a "colour chip" row showing every token resolving as expected |

Not shipped in prod builds — the route is excluded via env check in
`routes/dev.php`.

---

## 15. Day 1 Verification Checklist

Taken from the build guide §Verify, extended with specifics so each item
can actually fail if broken:

- [ ] `php artisan migrate:fresh --seed` runs clean; super admin, test user,
      3 wallet addresses, and 2 sample packages exist.
- [ ] Visit `/` returns a 404-styled page (no marketing on Day 1) **or** a
      stubbed "Coming soon" view — pick one and document.
- [ ] Register a user with real email, receive the 6-digit code in the
      SMTP inbox, enter via `CodeInput`, land on user dashboard shell.
- [ ] Login as seeded super admin, land on admin dashboard shell.
- [ ] From admin, hit `/admin/invite-codes` → should 404 cleanly (not a
      stack trace); the sidebar link is visibly disabled with a tooltip
      "Available in next build" to prevent operator confusion.
      *(Alternative: hide disabled items — pick one on Day 1.)*
- [ ] Generate an invite code manually via `php artisan tinker`, visit
      `/admin/register`, enter it, create an operator, login as operator.
- [ ] `/forgot-password` → generic success for both existing and
      non-existing emails. Code arrives in SMTP for existing. Reset
      completes.
- [ ] Toggle theme via header toggle — persists across reload (cookie), and
      no FOUC on next request.
- [ ] `/dev/components` renders every component, including all states.
      Nothing throws, nothing is unstyled in either theme.
- [ ] Rate limiting: 6th login attempt within 1 min returns 429 with a
      friendly flash message.
- [ ] `attempts` column on `verification_codes` increments; 6th code
      submission is rejected without consuming a valid code elsewhere.
- [ ] Component CSS is theme-safe: grep `resources/css` for literal hex
      values outside `tokens.css` — should return zero results.
- [ ] `vite build` succeeds. Bundle size reported.
- [ ] `php artisan test` is green (Day 1 tests: auth controllers, enum
      transitions, `VerificationCodeService`, `InviteCodeService`).

---

## 16. Open Day-1 Decisions (ask the owner before building)

Small, bounded choices that shape Day 1 but aren't fixed by the plan:

1. **Display font.** Project plan pins Coolvetica. References show
   editorial serif in display sizes. OK to add Fraunces/Instrument Serif
   as a `--font-display` for H1/H2 only? If no, drop and use Coolvetica
   throughout.
2. **Dev gallery route.** Keep `/dev/components` loaded only when
   `APP_ENV !== 'production'` (recommended), or ship behind a secret token
   even in prod for QA? Default: env-gated.
3. **Disabled sidebar links.** Hide links for pages not yet built, or show
   as disabled with "coming soon" tooltip? Default: hide.
4. **CSS architecture.** Plain CSS tokens + co-located component CSS
   (recommended for small team + Vite), or opt into Tailwind now? Default:
   plain CSS.
5. **Marketing root on Day 1.** `/` returns a stub, or a redirect to
   `/login`? Default: 503-ish "coming soon" stub so links in emails that
   point to `APP_URL` don't 404 if the SMTP test runs before Day 2.

---

## 17. Explicitly NOT in Day 1

So Day 1 doesn't creep:

- Marketing pages (Home/About/Services/Contact/Policy/Terms) — **Day 2**.
- Contact form backend — **Day 2**.
- Admin dashboard content, packages CRUD, waybill, QR — **Day 3**.
- Wallet/payment UI, NowPayments integration, manual confirmation,
  transactions, invite-code admin UI, audit log, settings — **Day 4**.
- User dashboard content, tracking map, map components, package detail,
  payment flow, profile — **Day 5**.
- Notification redesign, Telegram, queued jobs, scheduler, polish pass —
  **Day 6**.
- Data migration, rebrand sweep, secret rotation, deploy — **Day 7**.
