import { Head, Link } from '@inertiajs/react';
import {
    Airplane, Anchor, CurrencyCircleDollar, QrCode, Receipt, ShieldCheck, Truck, UsersThree,
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
                            Pick a shipping mode and a payment flow — Gotham Express handles the rest. Every service is first-class
                            in the admin console.
                        </p>
                    </div>
                </section>

                <section className="ge-stats" style={{ paddingBlock: 'var(--space-4xl)' }}>
                    <div className="container">
                        <div className="ge-section-header">
                            <span className="eyebrow">Shipping modes</span>
                            <h2 className="ge-section-title">Air, ground or sea — same workflow.</h2>
                        </div>
                        <div className="ge-features">
                            <Feature id="air" icon={Airplane} title="Air freight" text="Priority air shipments move through our carrier partners in 2–5 business days. Real-time status, insured in transit." />
                            <Feature id="ground" icon={Truck} title="Ground shipping" text="Overland transportation with route-level tracking. The cost-effective default for domestic and regional consignments." />
                            <Feature id="sea" icon={Anchor} title="Sea freight" text="Ocean cargo for bulk and oversized shipments. Our port network spans every continent." />
                        </div>
                    </div>
                </section>

                <section className="ge-stats" style={{ paddingBlock: 'var(--space-4xl)', background: 'var(--surface-alt)' }}>
                    <div className="container">
                        <div className="ge-section-header">
                            <span className="eyebrow">Platform capabilities</span>
                            <h2 className="ge-section-title">What ships in every plan.</h2>
                        </div>
                        <div className="ge-features">
                            <Feature id="crypto" icon={CurrencyCircleDollar} title="Automated crypto payments" text="NowPayments invoices are created from the package in two clicks; status posts back automatically via webhook." />
                            <Feature icon={ShieldCheck} title="Manual crypto confirmation" text="Admins can post wallet addresses and confirm receipt by hand when the automated rail isn't appropriate." />
                            <Feature icon={Receipt} title="Branded waybill PDFs" text="Each package gets a clean, invoice-style waybill with sender, recipient, QR code and status — ready to print or email." />
                            <Feature icon={QrCode} title="QR scan to track" text="Scan a package's QR to drop straight into the authenticated detail view — no digging through emails." />
                            <Feature icon={UsersThree} title="Role-gated admins" text="Super admins manage wallets, invite codes and audit log. Operators handle packages and payments." />
                            <Feature icon={Airplane} title="Live world-map tracker" text="A visual map shows the recipient exactly where their shipment is in the pipeline, at every status transition." />
                        </div>
                    </div>
                </section>

                <section className="ge-cta-band">
                    <div className="ge-cta-band__inner">
                        <div className="ge-cta-banner">
                            <img src="/images/refs/cta.webp" alt="" className="ge-cta-banner__media" aria-hidden="true" />
                            <div className="ge-cta-banner__content">
                                <h2 className="ge-cta-banner__title">Pick a shipping mode. We take it from there.</h2>
                                <div>
                                    <Link href="/register" className="ge-nav-btn ge-nav-btn--primary">Create account</Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </PublicLayout>
        </>
    );
}

function Feature({ id, icon: Icon, title, text }) {
    return (
        <article className="ge-feature" id={id}>
            <span className="ge-feature__icon"><Icon weight="bold" /></span>
            <h3 className="ge-feature__title">{title}</h3>
            <p className="ge-feature__text">{text}</p>
        </article>
    );
}
