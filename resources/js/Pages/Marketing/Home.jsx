import { useEffect, useRef, useState } from 'react';
import { Head, Link } from '@inertiajs/react';
import {
    ArrowRight, ArrowUpRight, CaretDown, Clock, Gauge, Package,
    ShieldCheck, Users,
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
const INDUSTRIES = [
    {
        key: 'consignment',
        label: 'Consignment & crypto settlement',
        headline: 'Run mission-critical consignments with freight that lands and payments that settle.',
        monitor: { title: 'Live Settlement Monitor', badgeLive: 'Live', focus: 'Open consignments awaiting payment:', focusValue: '14' },
        metrics: [
            ['Pending invoices', '24 — $186K'],
            ['Confirmed today', '48 — $412K'],
            ['Routes in motion', '36'],
            ['Reconciliation window', '< 60 min'],
        ],
    },
    {
        key: 'pharma',
        label: 'Pharmaceutical & cold-chain',
        headline: 'Move temperature-sensitive pharmaceutical consignments with chain-of-custody certainty.',
        monitor: { title: 'Cold-chain Integrity Monitor', badgeLive: 'Live', focus: 'Units outside tolerance band:', focusValue: '3' },
        metrics: [
            ['Shipments in transit', '142'],
            ['Avg hold temperature', '2.6 °C'],
            ['Breach alerts (24h)', '0'],
            ['Carriers active', '18'],
        ],
    },
    {
        key: 'luxury',
        label: 'Luxury goods & jewellery',
        headline: 'Move luxury goods and jewellery with signature, insurance and provenance locked in.',
        monitor: { title: 'High-value Transit Monitor', badgeLive: 'Live', focus: 'Insured declared value in motion:', focusValue: '$8.2M' },
        metrics: [
            ['Signed-for parcels', '96'],
            ['Insurer approvals pending', '4'],
            ['White-glove couriers', '12'],
            ['Avg transit time', '38 h'],
        ],
    },
    {
        key: 'fine-art',
        label: 'Fine art & collectibles',
        headline: 'Ship fine art and collectibles with climate-controlled handling and insured transit.',
        monitor: { title: 'Gallery-to-door Monitor', badgeLive: 'Live', focus: 'Crates logged this week:', focusValue: '47' },
        metrics: [
            ['Humidity-controlled lots', '31'],
            ['Appraisers on call', '9'],
            ['Customs clearances pending', '2'],
            ['Average handling time', '26 h'],
        ],
    },
    {
        key: 'industrial',
        label: 'Industrial equipment & oversized',
        headline: 'Deliver industrial equipment and oversized freight across every continent.',
        monitor: { title: 'Heavy-haul Monitor', badgeLive: 'Live', focus: 'Oversize permits in flight:', focusValue: '11' },
        metrics: [
            ['Flatbeds in motion', '58'],
            ['Multi-modal routes', '27'],
            ['Avg load weight', '18.4 t'],
            ['Delivery windows met', '98.6 %'],
        ],
    },
    {
        key: 'automotive',
        label: 'Automotive parts & assemblies',
        headline: 'Keep automotive supply chains moving — parts, assemblies, finished vehicles.',
        monitor: { title: 'OEM Supply Monitor', badgeLive: 'Live', focus: 'Just-in-time deliveries today:', focusValue: '312' },
        metrics: [
            ['Line-side arrivals', '184'],
            ['Idle risk alerts', '2'],
            ['Carriers synced', '42'],
            ['Avg kerb-to-dock', '42 min'],
        ],
    },
    {
        key: 'ecommerce',
        label: 'E-commerce & recipient-paid',
        headline: 'Fulfil e-commerce consignments with crypto settlement and recipient-paid delivery.',
        monitor: { title: 'Order Flow Monitor', badgeLive: 'Live', focus: 'Orders awaiting payment confirmation:', focusValue: '38' },
        metrics: [
            ['Parcels dispatched today', '1,284'],
            ['Avg checkout time', '27 s'],
            ['Return rate (30d)', '2.1 %'],
            ['Payout settlements', '96'],
        ],
    },
    {
        key: 'perishables',
        label: 'Perishables & agricultural exports',
        headline: 'Export perishables and agricultural goods under live-tracked cold-chain custody.',
        monitor: { title: 'Perishables Monitor', badgeLive: 'Live', focus: 'Cold-chain shipments en route:', focusValue: '72' },
        metrics: [
            ['Tonnage in motion', '428 t'],
            ['Port holds cleared', '9'],
            ['Spoilage alerts', '0'],
            ['Avg door-to-door', '71 h'],
        ],
    },
    {
        key: 'documents',
        label: 'Legal & sensitive documents',
        headline: 'Deliver legal and sensitive documents with signed custody and verified recipients.',
        monitor: { title: 'Chain-of-custody Monitor', badgeLive: 'Live', focus: 'Signatures awaiting capture:', focusValue: '18' },
        metrics: [
            ['Pouches in motion', '64'],
            ['Verified handoffs', '247'],
            ['Avg delivery time', '19 h'],
            ['Jurisdictions served', '42'],
        ],
    },
];

function Hero() {
    const [industry, setIndustry] = useState(INDUSTRIES[0]);
    const [open, setOpen] = useState(false);
    const panelRef = useRef(null);

    useEffect(() => {
        if (!open) return;
        const onDoc = (e) => { if (panelRef.current && !panelRef.current.contains(e.target)) setOpen(false); };
        const onKey = (e) => { if (e.key === 'Escape') setOpen(false); };
        document.addEventListener('mousedown', onDoc);
        document.addEventListener('keydown', onKey);
        return () => {
            document.removeEventListener('mousedown', onDoc);
            document.removeEventListener('keydown', onKey);
        };
    }, [open]);

    const select = (next) => { setIndustry(next); setOpen(false); };

    return (
        <section className="ge-hero">
            <div className="container">
                <div className="ge-hero__frame">
                    <span className="ge-hero__corner-tr" aria-hidden="true" />
                    <span className="ge-hero__corner-bl" aria-hidden="true" />

                    <div className="ge-hero__grid">
                        <div className="ge-hero__left">
                            <h1 className="ge-hero__title" key={industry.key}>
                                {industry.headline}
                            </h1>

                            <div className="ge-hero__actions">
                                <Link href="/register" className="ge-btn ge-btn--secondary ge-btn--lg">
                                    Request a demo
                                </Link>
                                <Link href="/services" className="ge-btn ge-btn--outline ge-btn--lg">
                                    Explore the platform
                                </Link>
                            </div>

                            <div className="ge-industry" data-open={open} ref={panelRef}>
                                <span className="ge-industry__label">Industry</span>
                                <button
                                    type="button"
                                    className="ge-industry__trigger"
                                    onClick={() => setOpen(o => !o)}
                                    aria-haspopup="listbox"
                                    aria-expanded={open}
                                >
                                    <span className="ge-industry__trigger-label">{industry.label}</span>
                                    <span className="ge-industry__caret">
                                        <CaretDown weight="bold" size={14} />
                                    </span>
                                </button>
                                {open ? (
                                    <ul className="ge-industry__panel" role="listbox" aria-label="Industries">
                                        {INDUSTRIES.map(opt => (
                                            <li key={opt.key}>
                                                <button
                                                    type="button"
                                                    className={`ge-industry__item${opt.key === industry.key ? ' ge-industry__item--active' : ''}`}
                                                    onClick={() => select(opt)}
                                                    role="option"
                                                    aria-selected={opt.key === industry.key}
                                                >
                                                    <span className="ge-industry__item-dot" aria-hidden="true" />
                                                    {opt.label}
                                                </button>
                                            </li>
                                        ))}
                                    </ul>
                                ) : null}
                            </div>
                        </div>

                        <div className="ge-hero__divider" aria-hidden="true" />

                        <div className="ge-hero__right">
                            <HeroDashboard industry={industry} />
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}

function HeroDashboard({ industry }) {
    // Deterministic bar heights per industry key so switching feels different.
    const bars = pseudoBars(industry.key, 24);
    return (
        <div className="ge-hero__dashboard" key={industry.key}>
            <div className="ge-hero__dashboard-head">
                <span className="ge-hero__dashboard-head-title">
                    <span className="ge-hero__ticker-dot" aria-hidden="true" />
                    {industry.monitor.title}
                </span>
                <button type="button" className="ge-hero__ticker-btn">Review</button>
            </div>

            <div className="ge-hero__live-row">
                <span className="ge-hero__live-badge">{industry.monitor.badgeLive}</span>
                <span>{industry.monitor.focus}</span>
                <strong style={{ color: 'var(--accent)' }}>{industry.monitor.focusValue}</strong>
            </div>

            <div className="ge-hero__dash-chart" aria-hidden="true">
                {bars.map((b, i) => (
                    <span
                        key={i}
                        className={`ge-hero__dash-bar${b.hot ? ' ge-hero__dash-bar--hot' : ''}`}
                        style={{ height: `${b.h}%` }}
                    />
                ))}
            </div>

            <div className="ge-hero__dash-metrics">
                {industry.metrics.map(([label, value]) => (
                    <div className="ge-hero__dash-row" key={label}>
                        <span className="ge-hero__dash-label">{label}</span>
                        <span className="ge-hero__dash-value">{value}</span>
                    </div>
                ))}
            </div>
        </div>
    );
}

/* Deterministic pseudo-random bar heights seeded by the industry key.
   Keeps the chart visually different per industry without introducing
   actual randomness (would re-render differently each tick). */
function pseudoBars(seed, count) {
    let h = 0;
    for (let i = 0; i < seed.length; i++) h = (h * 31 + seed.charCodeAt(i)) >>> 0;
    const out = [];
    for (let i = 0; i < count; i++) {
        h = (h * 1664525 + 1013904223) >>> 0;
        const pct = 25 + ((h >>> 8) % 70);
        out.push({ h: pct, hot: (h & 0b111) === 0 });
    }
    return out;
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
