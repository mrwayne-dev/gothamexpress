import { Head, Link } from '@inertiajs/react';
import { ArrowRight, Compass, HandHeart, Lightning, ShieldCheck } from '@phosphor-icons/react';
import { PublicLayout } from '@/Layouts/PublicLayout';

export default function About() {
    return (
        <>
            <Head title="About Gotham Express" />
            <PublicLayout>
                <section className="ge-page-hero">
                    <div className="container">
                        <span className="ge-page-hero__eyebrow">About</span>
                        <h1 className="ge-page-hero__title">We built the system we always wished we had.</h1>
                        <p className="ge-page-hero__sub">
                            Gotham Express is a consignment platform built for operators who ship real freight — and the recipients
                            who want to see where it is. One system. No stitched-together portals.
                        </p>
                    </div>
                </section>

                <section className="section">
                    <div className="container">
                        <div className="ge-split">
                            <div className="ge-split__content">
                                <span className="ge-section-eyebrow">Our story</span>
                                <h2 className="ge-section-title">From spreadsheets to a single source of truth.</h2>
                                <p className="text-muted">
                                    We spent years running shipments the manual way — email threads, offline spreadsheets, bank-transfer
                                    confirmations and status updates typed into chat. It worked right up until it didn't.
                                </p>
                                <p className="text-muted">
                                    Gotham Express is what we rebuilt from scratch. Package creation, lifecycle enforcement, crypto
                                    settlement, waybills, QR codes, and a live world-map tracker — one operator console, one recipient
                                    dashboard, zero copy-pasting.
                                </p>
                            </div>
                            <div className="ge-split__visual" aria-hidden="true" />
                        </div>
                    </div>
                </section>

                <section className="section surface-alt">
                    <div className="container">
                        <div className="ge-section-header ge-section-header--center">
                            <span className="ge-section-eyebrow">What drives us</span>
                            <h2 className="ge-section-title">The four things we don't compromise on.</h2>
                        </div>
                        <div className="ge-features">
                            <Value icon={ShieldCheck} title="Integrity" text="Every status change is logged. Every payment reconciled. No admin can quietly rewrite a shipment's history." />
                            <Value icon={Lightning} title="Speed" text="Operators move faster when the console is lean. We ship a working surface area, not a feature carnival." />
                            <Value icon={Compass} title="Clarity" text="Status language is one vocabulary across emails, notifications, dashboards, waybills. No translation tax." />
                            <Value icon={HandHeart} title="Care" text="Someone is waiting for every package. That's the whole product thesis." />
                        </div>
                    </div>
                </section>

                <section className="section">
                    <div className="container">
                        <div className="ge-cta">
                            <h3 className="ge-cta__title">Ready to run your logistics on one system?</h3>
                            <p className="ge-cta__sub">Create a user account or ask us for an admin invite.</p>
                            <div className="cluster" style={{ marginTop: 'var(--space-base)' }}>
                                <Link href="/register" className="ge-btn ge-btn--secondary ge-btn--lg">
                                    Register <ArrowRight weight="bold" />
                                </Link>
                                <Link href="/contact" className="ge-btn ge-btn--outline ge-btn--lg" style={{ color: '#fff', borderColor: 'rgba(255,255,255,.3)' }}>
                                    Contact us
                                </Link>
                            </div>
                        </div>
                    </div>
                </section>
            </PublicLayout>
        </>
    );
}

function Value({ icon: Icon, title, text }) {
    return (
        <article className="ge-feature">
            <span className="ge-feature__icon"><Icon weight="bold" /></span>
            <h3 className="ge-feature__title">{title}</h3>
            <p className="ge-feature__text">{text}</p>
        </article>
    );
}
