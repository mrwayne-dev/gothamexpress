import { useState } from 'react';
import { Link, router, usePage } from '@inertiajs/react';
import { CreditCard, Package, SignOut, SquaresFour } from '@phosphor-icons/react';
import { Sidebar } from '@/Components/Nav/Sidebar';
import { Header } from '@/Components/Nav/Header';
import { ThemeToggle } from '@/Components/Nav/ThemeToggle';
import { Avatar } from '@/Components/Data/Avatar';
import { Dropdown } from '@/Components/Feedback/Dropdown';
import { Button } from '@/Components/Primitives/Button';
import { cn } from '@/Lib/cn';

/**
 * Persistent admin shell. Day 1: dashboard sidebar entry only.
 * Days 3-4 unlock Packages, Transactions, Users, Invite codes, Audit log, Settings.
 */
export function AdminLayout({ title, breadcrumb, children }) {
    const { auth } = usePage().props;
    const [open, setOpen] = useState(false);

    const items = [
        {
            title: 'Workspace',
            items: [
                { href: '/admin/dashboard', label: 'Dashboard', icon: SquaresFour },
                // The rest are hidden on Day 1 (plan: hide, don't disable).
            ],
        },
    ];

    const brand = (
        <Link href="/admin/dashboard" style={{ color: 'inherit', textDecoration: 'none', display: 'inline-flex', alignItems: 'center', gap: 'var(--space-sm)' }}>
            <span className="ge-sidebar__brand-mark">G</span>
            <span>Gotham</span>
        </Link>
    );

    const footer = (
        <>
            <div className="ge-sidebar__user">
                <Avatar name={auth?.user?.name} size="sm" />
                <div className="ge-sidebar__user-info">
                    <span className="ge-sidebar__user-name">{auth?.user?.name || 'Admin'}</span>
                    <span className="ge-sidebar__user-role">{auth?.user?.role?.replace('_', ' ')}</span>
                </div>
            </div>
            <ThemeToggle />
        </>
    );

    return (
        <div className="ge-shell">
            <div
                className={cn('ge-shell__overlay', open && 'ge-shell__overlay--open')}
                onClick={() => setOpen(false)}
            />
            <Sidebar brand={brand} items={items} footer={footer} inverse open={open} onClose={() => setOpen(false)} />
            <div className="ge-shell__main">
                <Header
                    title={title}
                    breadcrumb={breadcrumb}
                    onToggleSidebar={() => setOpen(true)}
                    actions={
                        <Dropdown
                            trigger={({ toggle }) => (
                                <button type="button" className="ge-btn ge-btn--ghost ge-btn--sm" onClick={toggle}>
                                    <Avatar name={auth?.user?.name} size="sm" />
                                    <span>{auth?.user?.name || 'Admin'}</span>
                                </button>
                            )}
                        >
                            {({ close }) => (
                                <>
                                    <Dropdown.Item onClick={close}>Profile</Dropdown.Item>
                                    <Dropdown.Divider />
                                    <Dropdown.Item
                                        danger
                                        icon={<SignOut weight="bold" size={14} />}
                                        onClick={() => router.post('/logout')}
                                    >
                                        Log out
                                    </Dropdown.Item>
                                </>
                            )}
                        </Dropdown>
                    }
                />
                <main className="ge-shell__content">{children}</main>
            </div>
        </div>
    );
}

/** Static helper so admin pages can `.layout = AdminLayout.ssr(title)` if we want persistence. */
AdminLayout.wrap = (page, { title, breadcrumb } = {}) => (
    <AdminLayout title={title} breadcrumb={breadcrumb}>{page}</AdminLayout>
);
