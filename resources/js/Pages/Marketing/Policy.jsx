import { Head } from '@inertiajs/react';
import { PublicLayout } from '@/Layouts/PublicLayout';

const SECTIONS = [
    { id: 'overview', title: 'Overview' },
    { id: 'collection', title: 'What we collect' },
    { id: 'use', title: 'How we use it' },
    { id: 'sharing', title: 'Who we share with' },
    { id: 'retention', title: 'Data retention' },
    { id: 'rights', title: 'Your rights' },
    { id: 'security', title: 'Security' },
    { id: 'changes', title: 'Changes to this policy' },
    { id: 'contact', title: 'Contact' },
];

export default function Policy() {
    return (
        <>
            <Head title="Privacy policy" />
            <PublicLayout navSolid>
                <section className="ge-page-hero">
                    <div className="container">
                        <span className="ge-page-hero__eyebrow">Legal</span>
                        <h1 className="ge-page-hero__title">Privacy policy</h1>
                        <p className="ge-page-hero__sub">
                            Last updated October 2026. This policy explains what personal information Gotham Express collects, how we use
                            it, and the choices you have.
                        </p>
                    </div>
                </section>

                <div className="container">
                    <div className="ge-legal">
                        <nav className="ge-legal__toc" aria-label="On this page">
                            {SECTIONS.map(s => <a key={s.id} href={`#${s.id}`}>{s.title}</a>)}
                        </nav>
                        <article className="ge-legal__body">
                            <h2 id="overview">Overview</h2>
                            <p>Gotham Express ("we", "us") provides a consignment and crypto-payment platform. This policy applies to the website at gotham.mgbah.dev and to our connected admin and user dashboards.</p>

                            <h2 id="collection">What we collect</h2>
                            <ul>
                                <li>Account details you provide (name, email, phone, location).</li>
                                <li>Package information submitted by admins on your behalf (sender, recipient, address, item description).</li>
                                <li>Payment records (crypto payment ids, confirmed amounts, timestamps). We never see your private wallet keys.</li>
                                <li>Standard web logs (IP address, user agent, timestamps) for security and abuse prevention.</li>
                            </ul>

                            <h2 id="use">How we use it</h2>
                            <p>We use your information to run the service — creating and tracking packages, confirming payments, sending email and (opt-in) Telegram notifications, and keeping an audit trail of status changes.</p>

                            <h2 id="sharing">Who we share with</h2>
                            <p>We share only what the service requires — payment metadata with NowPayments, email contents with our SMTP provider, Telegram messages with the Telegram Bot API when you opt in. We do not sell your data.</p>

                            <h2 id="retention">Data retention</h2>
                            <p>Package and transaction records are kept for seven years for operational and regulatory reasons. Contact-form submissions are archived after 180 days. You can request earlier deletion at any time.</p>

                            <h2 id="rights">Your rights</h2>
                            <p>You can access, correct, export or delete your personal data by writing to the address in the Contact section below. We respond within 30 days.</p>

                            <h2 id="security">Security</h2>
                            <p>We hash passwords with bcrypt, use HTTPS end-to-end, rate-limit sensitive endpoints, verify payment webhooks with HMAC, and store verification codes as SHA-256 hashes. Secrets are never committed to source control.</p>

                            <h2 id="changes">Changes to this policy</h2>
                            <p>If we make a material change we will post the update here and, when appropriate, notify you by email at least 14 days before it takes effect.</p>

                            <h2 id="contact">Contact</h2>
                            <p>Reach us at <a href="mailto:support@gotham.mgbah.dev">support@gotham.mgbah.dev</a> or via the <a href="/contact">contact form</a>.</p>
                        </article>
                    </div>
                </div>
            </PublicLayout>
        </>
    );
}
