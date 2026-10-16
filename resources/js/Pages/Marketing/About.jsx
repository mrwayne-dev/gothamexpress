import { Head, Link } from '@inertiajs/react';
import { Compass, HandHeart, Lightning, ShieldCheck } from '@phosphor-icons/react';
import { PublicLayout } from '@/Layouts/PublicLayout';

export default function About() {
    return (
        <>
            <Head title="About" />
            <PublicLayout navSolid>
                <section className="ge-page-hero">
                    <div className="container">
                        <span className="ge-page-hero__eyebrow">About</span>
                        <h1 className="ge-page-hero__title">We built the system we always wished we had.</h1>
                        <p className="ge-page-hero__sub">
                            Gotham Express is a consignment platform built for operators who ship real freight — and the
                            recipients who want to see where it is. One system. No stitched-together portals.
                        </p>
                    </div>
                </section>

                <section className="ge-stats" style={{ paddingBlock: 'var(--space-4xl)' }}>
                    <div className="container">
                        <div className="ge-stats__grid">
                            <div className="ge-stats__left">
                                <span className="eyebrow eyebrow--muted">Our story</span>
                                <h2 className="ge-stats__headline">From spreadsheets to a single source of truth.</h2>
                            </div>
                            <div style={{ display: 'flex', flexDirection: 'column', gap: 'var(--space-base)' }}>
                                <p className="ge-section-desc">
                                    We spent years running shipments the manual way — email threads, offline spreadsheets, bank-transfer
                                    confirmations and status updates typed into chat. It worked right up until it didn't.
                                </p>
                                <p className="ge-section-desc">
                                    Gotham Express is what we rebuilt from scratch. Package creation, lifecycle enforcement, crypto
                                    settlement, waybills, QR codes, and a live world-map tracker — one operator console, one
                                    recipient dashboard, zero copy-pasting.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <section className="ge-stats" style={{ paddingBlock: 'var(--space-4xl)', background: 'var(--surface-alt)' }}>
                    <div className="container">
                        <div className="ge-section-header">
                            <span className="eyebrow">What drives us</span>
                            <h2 className="ge-section-title">Four things we don't compromise on.</h2>
                        </div>
                        <div className="ge-features">
                            <Value icon={ShieldCheck} title="Integrity" text="Every status change is logged. Every payment reconciled. No admin quietly rewrites a shipment's history." />
                            <Value icon={Lightning} title="Speed" text="Operators move faster when the console is lean. We ship a working surface area, not a feature carnival." />
                            <Value icon={Compass} title="Clarity" text="Status language is one vocabulary across emails, notifications, dashboards, waybills. No translation tax." />
                            <Value icon={HandHeart} title="Care" text="Someone is waiting for every package. That's the whole product thesis." />
                        </div>
                    </div>
                </section>

                <section className="ge-cta-band">
                    <div className="ge-cta-band__inner">
                        <div className="ge-cta-banner">
                            <img src="/images/refs/cta.webp" alt="" className="ge-cta-banner__media" aria-hidden="true" />
                            <div className="ge-cta-banner__content">
                                <h2 className="ge-cta-banner__title">Ready to run your logistics on one system?</h2>
                                <div>
                                    <Link href="/register" className="ge-nav-btn ge-nav-btn--primary">Register</Link>
                                </div>
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
