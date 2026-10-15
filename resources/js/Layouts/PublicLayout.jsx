import { useState } from 'react';
import { Link } from '@inertiajs/react';
import { List, X } from '@phosphor-icons/react';

export function PublicLayout({ children }) {
    const [open, setOpen] = useState(false);
    const year = new Date().getFullYear();

    return (
        <div className="ge-public">
            <nav className="ge-public-nav" aria-label="Primary">
                <div className="ge-public-nav__inner">
                    <Link href="/" className="ge-public-nav__brand">
                        <span className="ge-public-nav__mark" aria-hidden="true" />
                        <span>Gotham Express</span>
                    </Link>

                    <ul className={`ge-public-nav__links${open ? ' ge-public-nav__links--open' : ''}`}>
                        <li><Link href="/services" onClick={() => setOpen(false)}>Services</Link></li>
                        <li><Link href="/about" onClick={() => setOpen(false)}>About</Link></li>
                        <li><Link href="/policy" onClick={() => setOpen(false)}>Security</Link></li>
                        <li><Link href="/contact" onClick={() => setOpen(false)}>Contact</Link></li>
                    </ul>

                    <div className="ge-public-nav__cta">
                        <Link href="/login" className="ge-nav-btn" style={{ display: 'none' }}>Log in</Link>
                        <Link href="/register" className="ge-nav-btn">Request a demo</Link>
                        <button
                            type="button"
                            className="ge-public-nav__toggle"
                            aria-label={open ? 'Close menu' : 'Open menu'}
                            onClick={() => setOpen(o => !o)}
                        >
                            {open ? <X weight="bold" /> : <List weight="bold" />}
                        </button>
                    </div>
                </div>
            </nav>

            <main className="ge-public__main">{children}</main>

            <footer className="ge-public-footer">
                <div className="ge-public-footer__grid">
                    <div className="ge-public-footer__col">
                        <h5>Platform</h5>
                        <Link href="/">Overview</Link>
                        <Link href="/services">Services</Link>
                        <Link href="/dev/components">Component kit</Link>
                    </div>
                    <div className="ge-public-footer__col">
                        <h5>Solutions</h5>
                        <Link href="/services#air">Air freight</Link>
                        <Link href="/services#ground">Ground shipping</Link>
                        <Link href="/services#sea">Sea freight</Link>
                        <Link href="/services#crypto">Crypto settlement</Link>
                    </div>
                    <div className="ge-public-footer__col">
                        <h5>Company</h5>
                        <Link href="/about">About</Link>
                        <Link href="/contact">Contact</Link>
                        <Link href="/policy">Privacy policy</Link>
                        <Link href="/terms">Terms of service</Link>
                    </div>
                </div>
                <div className="ge-public-footer__bottom">
                    <span>© {year} Gotham Express</span>
                    <span className="ge-public-footer__mark" aria-hidden="true" />
                    <a href="https://github.com/mrwayne-dev/gothamexpress" target="_blank" rel="noopener">GitHub</a>
                </div>
            </footer>
        </div>
    );
}
