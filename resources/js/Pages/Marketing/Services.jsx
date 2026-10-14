import { Head, Link } from '@inertiajs/react';
import {
    Airplane, Anchor, ArrowRight, CurrencyCircleDollar, QrCode, Receipt, ShieldCheck, Truck, UsersThree,
} from '@phosphor-icons/react';
import { PublicLayout } from '@/Layouts/PublicLayout';

export default function Services() {
    return (
        <>
            <Head title="Services" />
            <PublicLayout>
                <section className="ge-page-hero">
                    <div className="container">
                        <span className="ge-page-hero__eyebrow">What we offer</span>
                        <h1 className="ge-page-hero__title">Logistics operations, end to end.</h1>
                        <p className="ge-page-hero__sub">
                            Pick a shipping mode and a payment flow — Gotham Express handles the rest. Every service is first-class in
                            the admin console.
                        </p>
                    </div>
                </section>

                <section className="section">
                    <div className="container">
                        <div className="ge-section-header">
                            <span className="ge-section-eyebrow">Shipping modes</span>
                            <h2 className="ge-section-title">Air, ground, or sea — same workflow.</h2>
                        </div>
                        <div className="ge-features">
                            <Feature
                                icon={Airplane}
                                title="Air freight"
                                text="Priority air shipments move through our carrier partners in 2–5 business days. Real-time status, insured in transit."
                            />
                            <Feature
                                icon={Truck}
                                title="Ground shipping"
                                text="Overland transportation with route-level tracking. The cost-effective default for domestic and regional consignments."
                            />
                            <Feature
                                icon={Anchor}
                                title="Sea freight"
                                text="Ocean cargo for bulk and oversized shipments. Our port network spans every continent."
                            />
                        </div>
                    </div>
                </section>

                <section className="section surface-alt">
                    <div className="container">
                        <div className="ge-section-header">
                            <span className="ge-section-eyebrow">Platform capabilities</span>
                            <h2 className="ge-section-title">What ships in every plan.</h2>
                        </div>
                        <div className="ge-features">
                            <Feature icon={CurrencyCircleDollar} title="Automated crypto payments" text="NowPayments invoices are created from the package in two clicks; status posts back automatically via webhook." />
                            <Feature icon={ShieldCheck} title="Manual crypto confirmation" text="Admins can post wallet addresses and confirm receipt by hand when the automated rail isn't appropriate." />
                            <Feature icon={Receipt} title="Branded waybill PDFs" text="Each package gets a clean, invoice-style waybill with sender, recipient, QR code and status — ready to print or email." />
                            <Feature icon={QrCode} title="QR scan to track" text="Scan a package's QR to drop straight into the authenticated detail view — no digging through emails." />
                            <Feature icon={UsersThree} title="Role-gated admins" text="Super admins manage wallets, invite codes and audit log. Operators handle packages and payments." />
                            <Feature icon={ArrowRight} title="Live world-map tracker" text="A visual map shows the recipient exactly where their shipment is in the pipeline, at every status transition." />
                        </div>
                    </div>
                </section>

                <section className="section">
                    <div className="container">
                        <div className="ge-cta">
                            <h3 className="ge-cta__title">Pick a shipping mode. We take it from there.</h3>
                            <p className="ge-cta__sub">Create an account or get an admin invite to run the dispatch console.</p>
                            <div className="cluster" style={{ marginTop: 'var(--space-base)' }}>
                                <Link href="/register" className="ge-btn ge-btn--secondary ge-btn--lg">Create account <ArrowRight weight="bold" /></Link>
                                <Link href="/contact" className="ge-btn ge-btn--outline ge-btn--lg" style={{ color: '#fff', borderColor: 'rgba(255,255,255,.3)' }}>Contact us</Link>
                            </div>
                        </div>
                    </div>
                </section>
            </PublicLayout>
        </>
    );
}

function Feature({ icon: Icon, title, text }) {
    return (
        <article className="ge-feature">
            <span className="ge-feature__icon"><Icon weight="bold" /></span>
            <h3 className="ge-feature__title">{title}</h3>
            <p className="ge-feature__text">{text}</p>
        </article>
    );
}
