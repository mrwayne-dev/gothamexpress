import { Head } from '@inertiajs/react';
import { PublicLayout } from '@/Layouts/PublicLayout';

const SECTIONS = [
    { id: 'acceptance', title: 'Acceptance' },
    { id: 'accounts', title: 'Accounts' },
    { id: 'shipments', title: 'Shipments and liability' },
    { id: 'payments', title: 'Payments' },
    { id: 'use', title: 'Acceptable use' },
    { id: 'termination', title: 'Termination' },
    { id: 'disclaimer', title: 'Disclaimer' },
    { id: 'law', title: 'Governing law' },
    { id: 'contact', title: 'Contact' },
];

export default function Terms() {
    return (
        <>
            <Head title="Terms of service" />
            <PublicLayout>
                <section className="ge-page-hero">
                    <div className="container">
                        <span className="ge-page-hero__eyebrow">Legal</span>
                        <h1 className="ge-page-hero__title">Terms of service</h1>
                        <p className="ge-page-hero__sub">
                            Last updated October 2026. By using Gotham Express you agree to these terms. Please read them.
                        </p>
                    </div>
                </section>

                <div className="container">
                    <div className="ge-legal">
                        <nav className="ge-legal__toc" aria-label="On this page">
                            {SECTIONS.map(s => <a key={s.id} href={`#${s.id}`}>{s.title}</a>)}
                        </nav>
                        <article className="ge-legal__body">
                            <h2 id="acceptance">Acceptance</h2>
                            <p>These terms form a binding agreement between you and Gotham Express. If you do not agree, do not use the service.</p>

                            <h2 id="accounts">Accounts</h2>
                            <p>You must provide accurate information when registering, keep your credentials secure, and notify us immediately of any unauthorised access. Admin accounts are created from invite codes; sharing invite codes outside your organisation is a breach of these terms.</p>

                            <h2 id="shipments">Shipments and liability</h2>
                            <p>Gotham Express facilitates consignment logistics. We handle each shipment with the care operators expect from a logistics platform, but we are not the carrier of record. Loss, damage or delay claims should be filed with the carrier identified on your waybill, and we will assist with the paperwork.</p>

                            <h2 id="payments">Payments</h2>
                            <p>We accept crypto payments through NowPayments (automated) or direct wallet transfers that admins confirm manually. Payments once sent on-chain are generally irreversible — review the destination address carefully before sending. Our platform fees are shown on the invoice.</p>

                            <h2 id="use">Acceptable use</h2>
                            <ul>
                                <li>No shipments of prohibited or illegal items.</li>
                                <li>No attempts to abuse rate limits or probe for vulnerabilities.</li>
                                <li>No automated scraping of other users' data.</li>
                            </ul>

                            <h2 id="termination">Termination</h2>
                            <p>We may suspend or terminate accounts that violate these terms. You may close your account at any time by writing to support — pending shipments must be resolved first.</p>

                            <h2 id="disclaimer">Disclaimer</h2>
                            <p>The service is provided "as is" without warranty of any kind. To the extent permitted by law, our liability is limited to the fees paid in the 12 months preceding a claim.</p>

                            <h2 id="law">Governing law</h2>
                            <p>These terms are governed by the laws of Delaware, USA, without regard to conflicts of law. Disputes are resolved in the state and federal courts of Delaware.</p>

                            <h2 id="contact">Contact</h2>
                            <p>Reach us at <a href="mailto:support@gotham.mgbah.dev">support@gotham.mgbah.dev</a> or via the <a href="/contact">contact form</a>.</p>
                        </article>
                    </div>
                </div>
            </PublicLayout>
        </>
    );
}
