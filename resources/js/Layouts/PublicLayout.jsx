import { Link } from '@inertiajs/react';

/** Marketing shell. Day 2 fills in the pages. */
export function PublicLayout({ children }) {
    return (
        <div className="ge-public">
            <nav className="ge-public-nav">
                <div className="ge-public-nav__inner">
                    <Link href="/" className="ge-public-nav__brand">
                        <span className="ge-sidebar__brand-mark" aria-hidden="true">G</span>
                        <span>Gotham Express</span>
                    </Link>
                    <div className="ge-public-nav__links">
                        <Link href="/about">About</Link>
                        <Link href="/services">Services</Link>
                        <Link href="/contact">Contact</Link>
                        <Link href="/login" className="ge-btn ge-btn--outline ge-btn--sm">Log in</Link>
                        <Link href="/register" className="ge-btn ge-btn--primary ge-btn--sm">Get started</Link>
                    </div>
                </div>
            </nav>
            <main className="ge-public__main">{children}</main>
            <footer className="ge-public-footer">
                <div className="ge-public-footer__grid">
                    <div>
                        <div className="ge-auth__brand" style={{ color: '#FFF', marginBottom: 'var(--space-sm)' }}>
                            Gotham Express
                        </div>
                        <p className="text-sm" style={{ color: 'var(--color-gray-400)' }}>
                            Consignment and crypto-paid parcel tracking.
                        </p>
                    </div>
                    <div className="ge-public-footer__col">
                        <h5>Product</h5>
                        <Link href="/about">About</Link>
                        <Link href="/services">Services</Link>
                        <Link href="/contact">Contact</Link>
                    </div>
                    <div className="ge-public-footer__col">
                        <h5>Legal</h5>
                        <Link href="/policy">Privacy policy</Link>
                        <Link href="/terms">Terms of service</Link>
                    </div>
                    <div className="ge-public-footer__col">
                        <h5>Account</h5>
                        <Link href="/login">Log in</Link>
                        <Link href="/register">Register</Link>
                    </div>
                </div>
                <div className="ge-public-footer__bottom">
                    <span>© {new Date().getFullYear()} Gotham Express</span>
                    <span>gotham.mgbah.dev</span>
                </div>
            </footer>
        </div>
    );
}
