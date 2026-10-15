import { Head, Link } from '@inertiajs/react';
import {
    ArrowRight, ArrowUpRight, CaretDown, Clock, Gauge, Globe, Package,
    ShieldCheck, Truck, Users,
} from '@phosphor-icons/react';
import { PublicLayout } from '@/Layouts/PublicLayout';
import { WorldMapMini } from '@/Components/Data/WorldMapMini';
import { Accordion } from '@/Components/Data/Accordion';

export default function Home() {
    return (
        <>
            <Head title="Precision logistics, paid on-chain" />
            <PublicLayout>
                <Hero />
                <FeatureMain />
                <Stats />
                <EnterpriseScale />
                <FAQ />
                <CTABand />
            </PublicLayout>
        </>
    );
}

/* ---------------- Section 1: Hero (herosection.webp) ---------------- */
function Hero() {
    return (
        <section className="ge-hero">
            <div className="container">
                <div className="ge-hero__frame">
                    <span className="ge-hero__corner-tr" aria-hidden="true" />
                    <span className="ge-hero__corner-bl" aria-hidden="true" />

                    <div className="ge-hero__grid">
                        {/* Left: headline + CTA + industry pill */}
                        <div style={{ display: 'flex', flexDirection: 'column', height: '100%' }}>
                            <h1 className="ge-hero__title">
                                Run mission-critical consignment and logistics with freight that lands.
                            </h1>

                            <div className="ge-hero__actions">
                                <Link href="/register" className="ge-btn ge-btn--secondary ge-btn--lg">
                                    Request a demo
                                </Link>
                            </div>

                            <div className="ge-hero__spec">
                                <span className="ge-hero__spec-label">Industry</span>
                                <button type="button" className="ge-hero__spec-pill">
                                    Consignment &amp; crypto settlement
                                    <CaretDown weight="bold" size={12} />
                                </button>
                            </div>
                        </div>

                        <div className="ge-hero__divider" aria-hidden="true" />

                        {/* Right: dark ticker card above the jet artwork */}
                        <div className="ge-hero__right">
                            <div className="ge-hero__ticker">
                                <div className="ge-hero__ticker-head">
                                    <span className="ge-hero__ticker-dot" />
                                    Critical Supply Chain Monitoring
                                </div>
                                <button type="button" className="ge-hero__ticker-btn">Review</button>
                            </div>

                            <div className="ge-hero__ticker-subtle">
                                <span className="ge-hero__ticker-live">Live</span>
                                <span>Upstream supplier risks identified:</span>
                                <strong style={{ color: 'var(--accent)' }}>14</strong>
                            </div>

                            <div className="ge-hero__metrics">
                                <span className="ge-hero__metric-label">Sources:</span>
                                <span className="ge-hero__metric-value">180 Supplier Emails</span>
                                <span className="ge-hero__metric-label">Tier 2/3 Suppliers:</span>
                                <span className="ge-hero__metric-value">240</span>
                                <span className="ge-hero__metric-label">Programs Impacted:</span>
                                <span className="ge-hero__metric-value">4</span>
                                <span className="ge-hero__metric-label">Delay Exposure:</span>
                                <span className="ge-hero__metric-value">6 Weeks</span>
                            </div>

                            <div className="ge-hero__visual">
                                <img src="/images/refs/hero.webp" alt="Hero visual" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}

/* ---------- Section 2: Feature main (featuremain.webp) ----------- */
function FeatureMain() {
    return (
        <section className="ge-fm">
            <div className="container">
                <div className="ge-fm__grid">
                    {/* Intro column */}
                    <div className="ge-fm__cell ge-fm__intro">
                        <div className="ge-fm__pill">Operators</div>
                        <p className="ge-fm__intro-body">
                            Gotham Express is a market-leading platform for consignment and crypto-settled logistics,
                            built to accelerate every stage of the shipment lifecycle.
                        </p>
                        <Link href="/services" className="ge-fm__explore">
                            Explore
                            <span className="ge-fm__explore-arrow"><ArrowRight weight="bold" size={14} /></span>
                        </Link>
                    </div>

                    {/* Center column: big number + map */}
                    <div className="ge-fm__cell ge-fm__center" style={{ padding: 0 }}>
                        <div className="ge-fm__big-cell" style={{ padding: 'var(--space-xl)' }}>
                            <div>
                                <div className="ge-fm__label">Shipments tracked<sup>*</sup></div>
                                <div className="ge-fm__huge">15K+</div>
                            </div>
                        </div>
                        <div className="ge-fm__map">
                            <div className="ge-fm__label">Countries</div>
                            <div className="ge-fm__map-canvas">
                                <WorldMapMini />
                            </div>
                        </div>
                    </div>

                    {/* Right column: stacked numbers */}
                    <div className="ge-fm__cell ge-fm__side" style={{ padding: 0 }}>
                        <div className="ge-fm__side-cell">
                            <div className="ge-fm__label">Clients</div>
                            <div className="ge-fm__huge">120+</div>
                        </div>
                        <div className="ge-fm__side-cell">
                            <div className="ge-fm__label">Markets</div>
                            <div className="ge-fm__huge">30+</div>
                        </div>
                    </div>

                    {/* Full-width footnote */}
                    <div className="ge-fm__footnote">
                        <p>For more detailed information about our markets and work, please get in touch with our team.</p>
                        <p style={{ color: 'var(--text-subtle)' }}>* Potential shipment reach based on connected carrier partners.</p>
                    </div>
                </div>
            </div>
        </section>
    );
}

/* ---------- Section 3: Stats (stats.png) -------------------------- */
function Stats() {
    return (
        <section className="ge-stats">
            <div className="container">
                <div className="ge-stats__grid">
                    <div className="ge-stats__left">
                        <h2 className="ge-stats__headline">We deliver results fast</h2>

                        {/* Bar-chart decoration bottom-left */}
                        <div className="ge-stats__chart" aria-hidden="true">
                            <span className="ge-stats__bar" />
                            <span className="ge-stats__bar ge-stats__bar--empty" />
                            <span className="ge-stats__bar" />
                            <span className="ge-stats__bar ge-stats__bar--empty" />
                            <span className="ge-stats__bar" />
                            <span className="ge-stats__bar" />
                            <span className="ge-stats__bar" />
                            <span className="ge-stats__bar" />
                            <span className="ge-stats__bar" />
                            <span className="ge-stats__bar ge-stats__bar--empty" />
                            <span className="ge-stats__bar" />
                            <span className="ge-stats__bar" />
                            <span className="ge-stats__bar" />
                            <span className="ge-stats__bar" />
                        </div>
                    </div>

                    <div className="ge-stats__right">
                        <StatCell num={<>8<sup>+</sup></>} label="Countries Gotham is live in" />
                        <StatCell num={<>100<sup>+</sup></>} label="Operators in production" />
                        <StatCell num={<>90<small>%</small></>} label="Faster cycle times" />
                        <StatCell num={<>73<small>%</small></>} label="On-time delivery rate" />
                        <StatCell num={<>10<sup>+</sup></>} label="Operator hours saved per week" />
                        <StatCell num={<>6<small>x</small></>} label="Shipment throughput uplift" />
                    </div>
                </div>
            </div>
        </section>
    );
}
function StatCell({ num, label }) {
    return (
        <div className="ge-stats__cell">
            <div className="ge-stats__num">{num}</div>
            <div className="ge-stats__label">{label}</div>
        </div>
    );
}

/* ---------- Section 4: Enterprise scale (feature2.png) ------------ */
function EnterpriseScale() {
    return (
        <section className="ge-escale">
            <div className="container">
                <div className="ge-escale__header">
                    <div className="ge-escale__intro">
                        <span className="eyebrow">Scale</span>
                        <h2 className="ge-escale__title">Built for enterprise-scale operations</h2>
                        <p className="ge-escale__desc">
                            Sub-second status propagation. Live reconciliation. Redundant payment rails designed for
                            real-time logistics. And architecture that scales from 10 shipments a day to 10,000
                            seamlessly.
                        </p>
                    </div>
                    <div className="ge-escale__header-cta">
                        <Link href="/contact" className="ge-btn ge-btn--secondary ge-btn--lg">
                            Book a demo
                        </Link>
                    </div>
                </div>

                <div className="ge-escale__grid">
                    <Kpi
                        highlight
                        icon={<Package weight="bold" />}
                        label="Shipment Volume"
                        value="3 million+ consignments / mo"
                    />
                    <Kpi icon={<ShieldCheck weight="bold" />} label="Delivery Success Rate" value="99.99%" />
                    <Kpi icon={<Clock weight="bold" />} label="Status Propagation Latency" value="<80 ms" />
                    <Kpi icon={<Gauge weight="bold" />} label="Payment Reconciliation Window" value="&lt;60 min" />
                    <Kpi icon={<ShieldCheck weight="bold" />} label="Average Audit Score" value="4.9+ CSAT" />
                    <Kpi icon={<ArrowUpRight weight="bold" />} label="Lost-package Rate Reduction" value="30%" />
                    <Kpi icon={<ShieldCheck weight="bold" />} label="Platform Uptime" value="99.99%" />
                    <Kpi icon={<Users weight="bold" />} label="Avg Support Turnaround" value="&lt;60 min" />
                </div>
            </div>
        </section>
    );
}
function Kpi({ icon, label, value, highlight = false }) {
    return (
        <div className={`ge-kpi${highlight ? ' ge-kpi--highlight' : ''}`}>
            <span className="ge-kpi__icon">{icon}</span>
            <span className="ge-kpi__label">{label}</span>
            {/* value may contain HTML-encoded < from JSX */}
            <span className="ge-kpi__value" dangerouslySetInnerHTML={{ __html: value }} />
        </div>
    );
}

/* ---------- Section 5: FAQ (faqsection1.png) ---------------------- */
function FAQ() {
    const items = [
        {
            q: 'What can Gotham Express do for my operation?',
            a: 'Gotham Express is a single system for consignment logistics — admins create packages, recipients pay in crypto (automated via NowPayments or manually confirmed), and status changes propagate live across email, Telegram and the recipient dashboard. We replace spreadsheets, bank-transfer chains and three different portals with one surface area.',
        },
        {
            q: 'How do I get started?',
            a: 'Register a user account to track incoming packages, or ask us for an invite code to run the admin console. New admin accounts are provisioned in under five minutes.',
        },
        {
            q: 'Do I need to change my existing carrier contracts?',
            a: 'No. Gotham Express sits on top of your existing carriers — we handle the shipment lifecycle, waybills, payments and recipient-facing tracking. Carrier choice stays with you.',
        },
        { q: 'What does my team still handle?', a: 'Package creation, status transitions, and manual payment confirmations when a transfer comes in off-platform. Everything else — notifications, audit logging, reconciliation polling — the platform handles automatically.' },
        { q: 'How long does onboarding take?', a: 'An operator can be live and shipping on the same day — the longest step is agreeing on a wallet policy for crypto settlement. Full organisation onboarding typically takes under a week.' },
        { q: 'What does Gotham Express cost?', a: 'Pricing is per-active-operator, with a flat per-shipment settlement fee on confirmed crypto transactions. Reach out for a quote tailored to your volume.' },
        { q: 'Is my data secure?', a: 'All auth endpoints are rate-limited, verification codes are stored as SHA-256 hashes, webhook signatures are HMAC-SHA512, and we never see your wallet private keys. Secrets never land in source control.' },
    ];
    return (
        <section className="ge-faq">
            <div className="container">
                <h2 className="ge-faq__title">FAQ</h2>
                <Accordion items={items} defaultOpenIndex={0} />
            </div>
        </section>
    );
}

/* ---------- Section 6: CTA band (cta+footer.webp) ----------------- */
function CTABand() {
    return (
        <section className="ge-cta-band">
            <div className="ge-cta-band__inner">
                <div className="ge-cta-banner">
                    <img src="/images/refs/cta.webp" alt="" className="ge-cta-banner__media" aria-hidden="true" />
                    <div className="ge-cta-banner__content">
                        <h2 className="ge-cta-banner__title">
                            Bring Gotham Express into the core of your logistics operation.
                        </h2>
                        <div>
                            <Link href="/register" className="ge-nav-btn ge-nav-btn--primary">
                                Request a demo
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}
