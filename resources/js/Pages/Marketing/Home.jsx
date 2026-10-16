import { useEffect, useRef, useState } from 'react';
import { Head, Link } from '@inertiajs/react';
import { AnimatePresence, animate, motion, useMotionValue } from 'motion/react';
import {
    ArrowRight, ArrowUpRight, Clock, Gauge, Package,
    ShieldCheck, Users,
} from '@phosphor-icons/react';
import { PublicLayout } from '@/Layouts/PublicLayout';
import { WorldMapMini } from '@/Components/Data/WorldMapMini';
import { Accordion } from '@/Components/Data/Accordion';
import {
    EASE, fadeInUp, splitWords, staggerParent, wordItem, wordStagger,
} from '@/Lib/motion';

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

/* ---------------- Section 1: Hero — image-carousel edition --------- */
const CAROUSEL_SECONDS = 7;
const INDUSTRIES = [
    {
        key: 'freight',
        tag: 'Enterprise freight',
        eyebrow: 'Freight & carriers',
        headline: 'Win and move more freight.',
        lede: 'Gotham Express gives brokers and carriers one system for consignment creation, tender response, settlement and live tracking — teams move more freight with the same headcount.',
        image: '/images/hero/freight.webp',
    },
    {
        key: 'container',
        tag: 'Container & port ops',
        eyebrow: 'Ocean & container',
        headline: 'Container flows, tracked door-to-door.',
        lede: 'Full-container-load and LCL consignments with chain-of-custody logs across every terminal hop. Reconciliation and recipient-paid settlement handled on-chain.',
        image: '/images/hero/container.webp',
    },
    {
        key: 'pharma',
        tag: 'Pharmaceutical & cold-chain',
        eyebrow: 'Validated temperature',
        headline: 'Cold-chain custody, breach-alerted.',
        lede: 'Validated-temperature consignments with per-unit custody logs, automated breach alerts and audit-ready paperwork — chain-of-custody certainty on every lane.',
        image: '/images/hero/pharma.webp',
    },
    {
        key: 'ecommerce',
        tag: 'E-commerce & last-mile',
        eyebrow: 'Recipient-paid fulfilment',
        headline: 'Recipient-paid parcels, settled on-chain.',
        lede: 'Crypto settlement, instant tender response and single-click reconciliation for e-commerce consignments — scales from 10 to 10,000 orders a day.',
        image: '/images/hero/ecommerce.webp',
    },
];

function Hero() {
    const [idx, setIdx] = useState(0);
    const [paused, setPaused] = useState(false);
    const industry = INDUSTRIES[idx];

    // One timer at a time; advances when complete, pauses on hover.
    const progress = useMotionValue(0);
    useEffect(() => {
        if (paused) return;
        progress.set(0);
        const ctl = animate(progress, 1, {
            duration: CAROUSEL_SECONDS,
            ease: 'linear',
            onComplete: () => setIdx(i => (i + 1) % INDUSTRIES.length),
        });
        return () => ctl.stop();
    }, [idx, paused, progress]);

    const jump = (i) => setIdx(i);

    return (
        <section
            className="ge-hero"
            onMouseEnter={() => setPaused(true)}
            onMouseLeave={() => setPaused(false)}
        >
            {/* Image stack — one slide per industry, crossfaded via opacity */}
            <div className="ge-hero__media" aria-hidden="true">
                {INDUSTRIES.map((item, i) => (
                    <motion.div
                        key={item.key}
                        className="ge-hero__media-slide"
                        animate={{ opacity: i === idx ? 1 : 0 }}
                        transition={{ duration: 0.9, ease: EASE }}
                    >
                        <img src={item.image} alt="" loading={i === 0 ? 'eager' : 'lazy'} />
                    </motion.div>
                ))}
            </div>
            <div className="ge-hero__overlay" aria-hidden="true" />
            <div className="ge-hero__grid-lines" aria-hidden="true">
                {Array.from({ length: 12 }).map((_, i) => <span key={i} />)}
            </div>

            {/* Content anchored to the bottom */}
            <motion.div
                className="ge-hero__content"
                initial="hidden"
                animate="show"
                variants={staggerParent(0.1, 0.3)}
            >
                <div>
                    <AnimatePresence mode="wait">
                        <motion.span
                            key={industry.key + '-eye'}
                            className="ge-hero__eyebrow"
                            initial={{ opacity: 0, y: 6 }}
                            animate={{ opacity: 0.78, y: 0, transition: { duration: 0.35, ease: EASE } }}
                            exit={{ opacity: 0, transition: { duration: 0.15 } }}
                        >
                            {industry.eyebrow}
                        </motion.span>
                    </AnimatePresence>

                    <AnimatePresence mode="wait">
                        <motion.h1
                            key={industry.key + '-title'}
                            className="ge-hero__title"
                            variants={wordStagger}
                            initial="hidden"
                            animate="show"
                            exit={{ opacity: 0, y: -10, transition: { duration: 0.2 } }}
                        >
                            {splitWords(industry.headline).map((word, i) => (
                                word.match(/^\s+$/) ? (
                                    <span key={i}>{word}</span>
                                ) : (
                                    <motion.span key={i} className="ge-hero__title-word" variants={wordItem}>
                                        {word}
                                    </motion.span>
                                )
                            ))}
                        </motion.h1>
                    </AnimatePresence>

                    <AnimatePresence mode="wait">
                        <motion.p
                            key={industry.key + '-lede'}
                            className="ge-hero__lede"
                            initial={{ opacity: 0, y: 6 }}
                            animate={{ opacity: 1, y: 0, transition: { duration: 0.45, ease: EASE, delay: 0.15 } }}
                            exit={{ opacity: 0, y: -6, transition: { duration: 0.15 } }}
                        >
                            {industry.lede}
                        </motion.p>
                    </AnimatePresence>
                </div>

                <motion.div className="ge-hero__cta-group" variants={fadeInUp}>
                    <Link href="/register" className="ge-hero__cta">Book a demo</Link>
                    <Link href="/tracking" className="ge-hero__cta-arrow" aria-label="Track a package">
                        <ArrowRight weight="bold" size={18} />
                    </Link>
                </motion.div>
            </motion.div>

            {/* Pager row */}
            <div className="ge-hero__pager">
                <span className="ge-hero__pager-counter">
                    {String(idx + 1).padStart(2, '0')} / {String(INDUSTRIES.length).padStart(2, '0')}
                </span>
                <div className="ge-hero__pager-dots" role="tablist" aria-label="Industries">
                    {INDUSTRIES.map((item, i) => (
                        <button
                            key={item.key}
                            type="button"
                            className={`ge-hero__pager-dot${i < idx ? ' ge-hero__pager-dot--complete' : ''}`}
                            onClick={() => jump(i)}
                            role="tab"
                            aria-selected={i === idx}
                            aria-label={item.tag}
                        >
                            <span className="ge-hero__pager-dot-track" />
                            {i === idx ? <PagerFill progress={progress} /> : null}
                        </button>
                    ))}
                </div>
                <span className="ge-hero__pager-label">{industry.tag}</span>
            </div>
        </section>
    );
}

/* Dedicated fill component so only the active dot subscribes to the motion
   value — no re-renders on the others. */
function PagerFill({ progress }) {
    const ref = useRef(null);
    useEffect(() => {
        const unsub = progress.on('change', (v) => {
            if (ref.current) ref.current.style.width = `${v * 100}%`;
        });
        return unsub;
    }, [progress]);
    return <span ref={ref} className="ge-hero__pager-dot-fill" />;
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
