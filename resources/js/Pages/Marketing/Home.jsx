import { useEffect, useMemo, useRef, useState } from 'react';
import { Head, Link } from '@inertiajs/react';
import { AnimatePresence, animate, motion, useMotionValue } from 'motion/react';
import {
    ArrowRight, ArrowUpRight, Boat, CaretDown, Car, Clock, Diamond,
    EnvelopeOpen, Factory, Gauge, Package, PaintBrush, Pill,
    ShieldCheck, ShoppingBag, Thermometer, Users,
} from '@phosphor-icons/react';
import { PublicLayout } from '@/Layouts/PublicLayout';
import { WorldMapMini } from '@/Components/Data/WorldMapMini';
import { Accordion } from '@/Components/Data/Accordion';
import {
    EASE, fadeInUp, splitWords, staggerParent, swapOut, wordItem, wordStagger,
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

/* ---------------- Section 1: Hero ---------------------------------- */
const CAROUSEL_SECONDS = 8;
const INDUSTRIES = [
    {
        key: 'shipping',
        tag: 'Shipping',
        lede: 'Gotham Express partners with freight operators to design, run and scale consignment networks that settle in real time — impact in weeks, not quarters.',
        headline: 'Precision logistics for mission-critical freight.',
        icon: Boat,
        stat: '118',
        statLabel: 'Vessels under live monitoring',
    },
    {
        key: 'pharma',
        tag: 'Pharmaceutical & cold-chain',
        lede: 'Validated-temperature consignments with per-unit custody logs and automated breach alerts — chain-of-custody certainty, every lane.',
        headline: 'Temperature-locked chains with full custody certainty.',
        icon: Pill,
        stat: '142',
        statLabel: 'Shipments in validated transit',
    },
    {
        key: 'luxury',
        tag: 'Luxury goods & jewellery',
        lede: 'Signature-on-delivery, insurer-approved couriers and provenance-tracked movements for high-value consignments across every continent.',
        headline: 'High-value goods, signed-for and provenance-locked.',
        icon: Diamond,
        stat: '$8.2m',
        statLabel: 'Insured value in motion today',
    },
    {
        key: 'fine-art',
        tag: 'Fine art & collectibles',
        lede: 'Climate-controlled crating, gallery-to-door tracking and insured transit for fine art and collectibles — the full custody record for every piece.',
        headline: 'Gallery-to-door, climate-controlled, insured end-to-end.',
        icon: PaintBrush,
        stat: '47',
        statLabel: 'Crates logged this week',
    },
    {
        key: 'industrial',
        tag: 'Industrial equipment',
        lede: 'Oversized freight and heavy-haul coordination across multi-modal routes — permits in flight, flatbeds dispatched, delivery windows met.',
        headline: 'Oversized freight routed, permitted and delivered.',
        icon: Factory,
        stat: '58',
        statLabel: 'Flatbeds in motion',
    },
    {
        key: 'automotive',
        tag: 'Manufacturing & engineering',
        lede: 'Just-in-time delivery pipelines wired to the production line — parts, assemblies and finished vehicles synchronised across supplier networks.',
        headline: 'Keep the line moving. Parts in, vehicles out.',
        icon: Car,
        stat: '€3.1m',
        statLabel: 'Spend leakage identified',
    },
    {
        key: 'ecommerce',
        tag: 'E-commerce fulfilment',
        lede: 'Recipient-paid delivery, crypto settlement and single-click reconciliation for e-commerce consignments — scales from 10 to 10,000 orders a day.',
        headline: 'Recipient-paid fulfilment, settled on-chain.',
        icon: ShoppingBag,
        stat: '1,284',
        statLabel: 'Parcels dispatched today',
    },
    {
        key: 'perishables',
        tag: 'Perishables & agricultural',
        lede: 'Cold-chain custody for perishables and agricultural exports — port holds cleared, spoilage alerts triaged, door-to-door audit-ready.',
        headline: 'Cold-chain custody from field to final mile.',
        icon: Thermometer,
        stat: '428t',
        statLabel: 'Tonnage in motion',
    },
    {
        key: 'documents',
        tag: 'Legal & sensitive documents',
        lede: 'Signed custody, verified recipients and tamper-evident pouches for legal and sensitive paperwork across jurisdictions.',
        headline: 'Signed custody for legal and sensitive paperwork.',
        icon: EnvelopeOpen,
        stat: '64',
        statLabel: 'Pouches with verified recipients',
    },
];

function Hero() {
    const [idx, setIdx] = useState(0);
    const [paused, setPaused] = useState(false);
    const [pickerOpen, setPickerOpen] = useState(false);
    const timerFill = useMotionValue(0); // 0 → 1 over CAROUSEL_SECONDS
    const industry = INDUSTRIES[idx];

    // Carousel loop — one Motion animation at a time, re-queued on index change.
    useEffect(() => {
        if (paused) return;
        timerFill.set(0);
        const controls = animate(timerFill, 1, {
            duration: CAROUSEL_SECONDS,
            ease: 'linear',
            onComplete: () => setIdx(i => (i + 1) % INDUSTRIES.length),
        });
        return () => controls.stop();
    }, [idx, paused, timerFill]);

    // Picker outside-click
    const pickerRef = useRef(null);
    useEffect(() => {
        if (!pickerOpen) return;
        const onDoc = (e) => { if (pickerRef.current && !pickerRef.current.contains(e.target)) setPickerOpen(false); };
        const onKey = (e) => { if (e.key === 'Escape') setPickerOpen(false); };
        document.addEventListener('mousedown', onDoc);
        document.addEventListener('keydown', onKey);
        return () => {
            document.removeEventListener('mousedown', onDoc);
            document.removeEventListener('keydown', onKey);
        };
    }, [pickerOpen]);

    const jumpTo = (i) => { setIdx(i); setPickerOpen(false); };

    return (
        <section
            className="ge-hero"
            onMouseEnter={() => setPaused(true)}
            onMouseLeave={() => setPaused(false)}
        >
            <div className="container">
                <motion.div
                    className="ge-hero__frame"
                    initial="hidden"
                    animate="show"
                    variants={staggerParent(0.08, 0.1)}
                >
                    <span className="ge-hero__corner-tr" aria-hidden="true" />
                    <span className="ge-hero__corner-bl" aria-hidden="true" />

                    <div className="ge-hero__grid">
                        {/* ---------- LEFT COLUMN ---------- */}
                        <div className="ge-hero__left">
                            <motion.div className="ge-hero__title-wrap" variants={fadeInUp}>
                                <AnimatePresence mode="wait">
                                    <motion.h1
                                        key={industry.key}
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
                                                <motion.span
                                                    key={i}
                                                    className="ge-hero__title-word"
                                                    variants={wordItem}
                                                >
                                                    {word}
                                                </motion.span>
                                            )
                                        ))}
                                    </motion.h1>
                                </AnimatePresence>
                            </motion.div>

                            <motion.div variants={fadeInUp}>
                                <AnimatePresence mode="wait">
                                    <motion.p
                                        key={industry.key}
                                        className="ge-hero__lede"
                                        initial={{ opacity: 0, y: 6 }}
                                        animate={{ opacity: 1, y: 0, transition: { duration: 0.45, ease: EASE, delay: 0.15 } }}
                                        exit={{ opacity: 0, y: -6, transition: { duration: 0.15 } }}
                                    >
                                        {industry.lede}
                                    </motion.p>
                                </AnimatePresence>
                            </motion.div>

                            <motion.div className="ge-hero__actions" variants={fadeInUp}>
                                <Link href="/register" className="ge-hero__cta">Request a demo</Link>
                                <Link href="/services" className="ge-hero__cta ge-hero__cta--ghost">Explore the platform</Link>
                            </motion.div>
                        </div>

                        {/* ---------- RIGHT COLUMN: 3 panels ---------- */}
                        <motion.div className="ge-hero__right" variants={fadeInUp}>
                            <HeroTimer industry={industry} timerFill={timerFill} />
                            <HeroVisual
                                industry={industry}
                                pickerOpen={pickerOpen}
                                setPickerOpen={setPickerOpen}
                                onJump={jumpTo}
                                pickerRef={pickerRef}
                            />
                            <HeroStat industry={industry} />
                        </motion.div>
                    </div>
                </motion.div>
            </div>
        </section>
    );
}

/* ---------- Panel 1: timer bar -------------------------------------- */
function HeroTimer({ industry, timerFill }) {
    const fillRef = useRef(null);
    // Subscribe once, write directly to DOM via style — avoids re-renders.
    useEffect(() => {
        const unsub = timerFill.on('change', (v) => {
            if (fillRef.current) fillRef.current.style.width = `${v * 100}%`;
        });
        return unsub;
    }, [timerFill]);

    return (
        <div className="ge-hero__panel-timer">
            <div className="ge-hero__timer-label">
                <span>Live delivery feed</span>
                <strong>{String(INDUSTRIES.indexOf(industry) + 1).padStart(2, '0')} / {String(INDUSTRIES.length).padStart(2, '0')}</strong>
            </div>
            <div className="ge-hero__timer-bar">
                <div ref={fillRef} className="ge-hero__timer-fill" />
            </div>
        </div>
    );
}

/* ---------- Panel 2: industry visual + chip picker ------------------ */
function HeroVisual({ industry, pickerOpen, setPickerOpen, onJump, pickerRef }) {
    const Icon = industry.icon;
    return (
        <div className="ge-hero__panel-visual" ref={pickerRef}>
            <button
                type="button"
                className="ge-hero__industry-tag"
                onClick={() => setPickerOpen(o => !o)}
                aria-haspopup="listbox"
                aria-expanded={pickerOpen}
            >
                {industry.tag.toUpperCase()}
                <CaretDown weight="bold" size={11} style={{ marginLeft: 4 }} />
            </button>

            <AnimatePresence>
                {pickerOpen ? (
                    <motion.ul
                        className="ge-hero__industry-panel"
                        role="listbox"
                        aria-label="Industries"
                        initial={{ opacity: 0, y: -4 }}
                        animate={{ opacity: 1, y: 0, transition: { duration: 0.15, ease: EASE } }}
                        exit={{ opacity: 0, y: -4, transition: { duration: 0.1 } }}
                    >
                        {INDUSTRIES.map((opt, i) => (
                            <li key={opt.key}>
                                <button
                                    type="button"
                                    onClick={() => onJump(i)}
                                    role="option"
                                    aria-selected={opt.key === industry.key}
                                >
                                    {opt.tag}
                                </button>
                            </li>
                        ))}
                    </motion.ul>
                ) : null}
            </AnimatePresence>

            <div className="ge-hero__visual-stage">
                <HeroParticles seed={industry.key} />
                <AnimatePresence mode="wait">
                    <motion.div
                        key={industry.key}
                        className="ge-hero__visual-icon"
                        initial={{ opacity: 0, scale: 0.86, y: 10 }}
                        animate={{ opacity: 1, scale: 1, y: 0, transition: { duration: 0.6, ease: EASE } }}
                        exit={{ opacity: 0, scale: 0.9, y: -8, transition: { duration: 0.25 } }}
                    >
                        <Icon weight="fill" size={200} />
                    </motion.div>
                </AnimatePresence>
            </div>
        </div>
    );
}

/* ---------- Panel 3: operational-intelligence stat card ------------- */
function HeroStat({ industry }) {
    return (
        <div className="ge-hero__panel-stat">
            <div className="ge-hero__stat-head">
                <span>Operational Intelligence</span>
                <span className="ge-hero__stat-live">Live</span>
            </div>
            <AnimatePresence mode="wait">
                <motion.div
                    key={industry.key}
                    className="ge-hero__stat-value"
                    initial={{ opacity: 0, y: 8 }}
                    animate={{ opacity: 1, y: 0, transition: { duration: 0.45, ease: EASE } }}
                    exit={{ opacity: 0, y: -8, transition: { duration: 0.2 } }}
                >
                    {industry.stat}
                </motion.div>
            </AnimatePresence>
            <AnimatePresence mode="wait">
                <motion.div
                    key={industry.key + '-cap'}
                    className="ge-hero__stat-caption"
                    initial={{ opacity: 0 }}
                    animate={{ opacity: 1, transition: { duration: 0.4, delay: 0.15 } }}
                    exit={{ opacity: 0, transition: { duration: 0.15 } }}
                >
                    {industry.statLabel}
                </motion.div>
            </AnimatePresence>
        </div>
    );
}

/* ---------- Decorative particles behind the industry icon ---------- */
function HeroParticles({ seed }) {
    const dots = useMemo(() => {
        // Deterministic placement from seed so no re-render jitter.
        let h = 0;
        for (let i = 0; i < seed.length; i++) h = (h * 31 + seed.charCodeAt(i)) >>> 0;
        const out = [];
        for (let i = 0; i < 14; i++) {
            h = (h * 1664525 + 1013904223) >>> 0;
            const left = (h >>> 8) % 95 + 2;
            h = (h * 1664525 + 1013904223) >>> 0;
            const top = (h >>> 8) % 85 + 5;
            h = (h * 1664525 + 1013904223) >>> 0;
            const size = ((h >>> 8) % 3) + 1;
            h = (h * 1664525 + 1013904223) >>> 0;
            const delay = ((h >>> 8) % 40) / 10;
            out.push({ left, top, size, delay });
        }
        return out;
    }, [seed]);
    return (
        <div className="ge-hero__visual-particles" aria-hidden="true">
            {dots.map((d, i) => (
                <motion.span
                    key={i}
                    className="ge-hero__visual-particle"
                    style={{ left: `${d.left}%`, top: `${d.top}%`, width: d.size, height: d.size }}
                    animate={{ opacity: [0.2, 0.9, 0.2], scale: [1, 1.6, 1] }}
                    transition={{ duration: 2.6, repeat: Infinity, delay: d.delay, ease: 'easeInOut' }}
                />
            ))}
        </div>
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
