import { Head, Link } from '@inertiajs/react';
import {
    ArrowRight, Globe, Lightning, LockKey, MagnifyingGlass, Package, QrCode, ShieldCheck, Truck,
} from '@phosphor-icons/react';
import { PublicLayout } from '@/Layouts/PublicLayout';
import { Button } from '@/Components/Primitives/Button';

export default function Home() {
    return (
        <>
            <Head title="Precision logistics, paid on-chain" />
            <PublicLayout>
                <section className="ge-hero">
                    <div className="container">
                        <div className="ge-hero__inner">
                            <div>
                                <span className="ge-hero__eyebrow">
                                    <span style={{ width: 6, height: 6, borderRadius: 50, background: 'currentColor' }} />
                                    Consignment · Live tracking · Crypto payouts
                                </span>
                                <h1 className="ge-hero__title">
                                    Precision logistics, paid on-chain.
                                </h1>
                                <p className="ge-hero__sub">
                                    Create a package, confirm a payment, follow every shipment on a live world map — one system from
                                    dispatch to delivery. Built for operators who move real freight.
                                </p>
                                <div className="ge-hero__actions">
                                    <Link href="/register" className="ge-btn ge-btn--primary ge-btn--lg">
                                        Create account <ArrowRight weight="bold" />
                                    </Link>
                                    <Link href="/services" className="ge-btn ge-btn--outline ge-btn--lg">
                                        See how it works
                                    </Link>
                                </div>
                            </div>
                            <div className="ge-hero__visual" aria-hidden="true">
                                <div className="ge-hero__visual-card">
                                    <div className="ge-hero__visual-row"><span>Live</span><strong>GTX-7A3F9B2C</strong></div>
                                    <div className="ge-hero__visual-row"><span>Status</span><strong>In transit · Dallas → Lagos</strong></div>
                                    <div className="ge-hero__visual-row"><span>Payment</span><strong>USDT · Confirmed</strong></div>
                                    <div className="ge-hero__visual-row"><span>ETA</span><strong>Fri · 11:40</strong></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section className="section">
                    <div className="container">
                        <div className="ge-stats-strip">
                            <div className="ge-stats-strip__intro">
                                <span className="ge-stats-strip__intro-eyebrow">By the numbers</span>
                                <p className="text-muted">Live operational metrics across the Gotham Express network.</p>
                            </div>
                            <StatCell label="Packages tracked" value="15K+" />
                            <StatCell label="Countries served" value="120+" />
                            <StatCell label="On-time delivery" value="99%" />
                        </div>
                    </div>
                </section>

                <section className="section">
                    <div className="container">
                        <div className="ge-section-header ge-section-header--center">
                            <span className="ge-section-eyebrow">What we do</span>
                            <h2 className="ge-section-title">A single pane for every shipment.</h2>
                            <p className="ge-section-desc">
                                Admins create and move packages, recipients watch them in real time, and crypto payments reconcile themselves.
                            </p>
                        </div>
                        <div className="ge-features">
                            <Feature icon={Package} title="Create any shipment" text="Air, ground, sea — set origin, destination, price and transit mode. Every package gets a GTX-tracking id." />
                            <Feature icon={Truck} title="Enforce the lifecycle" text="Processing → in-transit → delivered. Backward moves are blocked. Every change is logged." />
                            <Feature icon={QrCode} title="Scan to track" text="QR codes on labels drop recipients straight into their dashboard — no digging through emails." />
                            <Feature icon={Globe} title="Live world map" text="Your packages render on a real world map with origin, destination and route progress." />
                            <Feature icon={LockKey} title="Crypto, automated" text="Pay by NowPayments or any of our wallet addresses — confirm manually when needed." />
                            <Feature icon={ShieldCheck} title="Enumeration-safe auth" text="6-digit email verification, invite-code-gated admins, no login oracle. Rate-limited everywhere." />
                        </div>
                    </div>
                </section>

                <section className="section">
                    <div className="container">
                        <div className="ge-section-header">
                            <span className="ge-section-eyebrow">How it works</span>
                            <h2 className="ge-section-title">Dispatch to doorstep in three moves.</h2>
                        </div>
                        <div className="ge-process">
                            <div className="ge-process__step">
                                <h4>Create</h4>
                                <p>Admin creates a package with recipient details, price and photo. We mint the tracking id instantly.</p>
                            </div>
                            <div className="ge-process__step">
                                <h4>Pay</h4>
                                <p>Recipient logs in, picks a wallet or NowPayments invoice, and sends. Confirmation is automatic or admin-confirmed.</p>
                            </div>
                            <div className="ge-process__step">
                                <h4>Track</h4>
                                <p>The world map and status timeline update as the package moves. Email and Telegram notifications fire on each transition.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section className="section">
                    <div className="container">
                        <div className="ge-section-header">
                            <span className="ge-section-eyebrow">Comparison</span>
                            <h2 className="ge-section-title">Built for operators, not couriers.</h2>
                            <p className="ge-section-desc">
                                Legacy courier portals stitch together partial pieces. Gotham Express ships the full workflow.
                            </p>
                        </div>
                        <div className="ge-compare">
                            <div className="ge-compare__col-head">Capability</div>
                            <div className="ge-compare__col-head">Spreadsheet</div>
                            <div className="ge-compare__col-head">Legacy portal</div>
                            <div className="ge-compare__col-head ge-compare__col-head--us">Gotham Express</div>

                            <CompareRow label="Enforced status lifecycle" us={true} spreadsheet={false} legacy="partial" />
                            <CompareRow label="Live world-map tracking" us={true} spreadsheet={false} legacy={false} />
                            <CompareRow label="Crypto settlement (auto + manual)" us={true} spreadsheet={false} legacy={false} />
                            <CompareRow label="Branded waybills + QR" us={true} spreadsheet={false} legacy="partial" />
                            <CompareRow label="Email + Telegram notifications" us={true} spreadsheet={false} legacy={false} />
                            <CompareRow label="Role-gated admin console" us={true} spreadsheet={false} legacy={true} />
                            <CompareRow label="Dark mode, out of the box" us={true} spreadsheet="n/a" legacy={false} />
                        </div>
                    </div>
                </section>

                <section className="container">
                    <div className="ge-cta">
                        <span className="text-xs" style={{ color: 'var(--color-gray-400)', textTransform: 'uppercase', letterSpacing: 'var(--letter-spacing-wider)' }}>Get started</span>
                        <h3 className="ge-cta__title">Open your Gotham Express account in two minutes.</h3>
                        <p className="ge-cta__sub">Register as a user to track your own packages, or ask an admin for an invite code to run the dispatch console.</p>
                        <div className="cluster" style={{ marginTop: 'var(--space-base)' }}>
                            <Link href="/register" className="ge-btn ge-btn--secondary ge-btn--lg">
                                Create account <ArrowRight weight="bold" />
                            </Link>
                            <Link href="/contact" className="ge-btn ge-btn--outline ge-btn--lg" style={{ color: '#fff', borderColor: 'rgba(255,255,255,.3)' }}>
                                Talk to us
                            </Link>
                        </div>
                    </div>
                </section>
            </PublicLayout>
        </>
    );
}

function StatCell({ label, value }) {
    return (
        <div className="ge-stats-strip__cell">
            <span className="ge-stats-strip__cell-label">{label}</span>
            <span className="ge-stats-strip__cell-value">{value}</span>
        </div>
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

function CompareRow({ label, us, spreadsheet, legacy }) {
    const Yes = () => <span style={{ color: 'var(--color-success)', fontWeight: 'bold' }}>✓</span>;
    const No = () => <span style={{ color: 'var(--text-subtle)' }}>—</span>;
    const Partial = () => <span style={{ color: 'var(--color-warning)' }}>partial</span>;
    const render = (v) => v === true ? <Yes /> : v === 'partial' ? <Partial /> : v === 'n/a' ? <span className="text-subtle">n/a</span> : <No />;
    return (
        <div className="ge-compare__row">
            <div className="ge-compare__cell">{label}</div>
            <div className="ge-compare__cell">{render(spreadsheet)}</div>
            <div className="ge-compare__cell">{render(legacy)}</div>
            <div className="ge-compare__cell ge-compare__cell--us">{render(us)}</div>
        </div>
    );
}
