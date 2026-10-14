import { Link } from '@inertiajs/react';

export function AuthLayout({ title, subtitle, altAction, children }) {
    return (
        <div className="ge-auth">
            <aside className="ge-auth__brand-side">
                <Link href="/" className="ge-auth__brand">
                    <span className="ge-sidebar__brand-mark" aria-hidden="true">G</span>
                    <span>Gotham Express</span>
                </Link>
                <div style={{ position: 'relative', zIndex: 1, display: 'grid', gap: 'var(--space-base)' }}>
                    <h2 className="ge-auth__brand-headline">
                        Precision logistics, paid on-chain.
                    </h2>
                    <p className="ge-auth__brand-tagline">
                        Create packages, confirm payments, and follow every shipment on a live world map — one system from
                        dispatch to delivery.
                    </p>
                </div>
                <small style={{ color: 'var(--color-gray-600)', position: 'relative', zIndex: 1 }}>
                    © {new Date().getFullYear()} Gotham Express
                </small>
            </aside>
            <section className="ge-auth__form-side">
                <div className="ge-auth__card">
                    {title ? <h1 className="ge-auth__title">{title}</h1> : null}
                    {subtitle ? <p className="ge-auth__subtitle">{subtitle}</p> : null}
                    {children}
                    {altAction ? <div className="ge-auth__alt">{altAction}</div> : null}
                </div>
            </section>
        </div>
    );
}
