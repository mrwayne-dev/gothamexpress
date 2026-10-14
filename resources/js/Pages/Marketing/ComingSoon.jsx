import { Head, Link } from '@inertiajs/react';

export default function ComingSoon() {
    return (
        <>
            <Head title="Coming soon" />
            <div className="ge-coming">
                <div className="ge-coming__brand">
                    <span className="ge-sidebar__brand-mark">G</span>
                    <span>Gotham Express</span>
                </div>
                <h1 className="ge-coming__title">
                    Precision logistics, <span className="ge-coming__accent">paid on-chain.</span>
                </h1>
                <p className="ge-coming__tagline">
                    Our marketing site arrives on Day 2 of the build. In the meantime, admins and early users can jump straight into the system.
                </p>
                <div className="cluster">
                    <Link href="/login" className="ge-btn ge-btn--primary ge-btn--lg">Log in</Link>
                    <Link href="/register" className="ge-btn ge-btn--outline ge-btn--lg" style={{ color: '#fff', borderColor: 'rgba(255,255,255,.3)' }}>Create account</Link>
                </div>
                <div className="ge-coming__footer">© {new Date().getFullYear()} Gotham Express · gotham.mgbah.dev</div>
            </div>
        </>
    );
}
