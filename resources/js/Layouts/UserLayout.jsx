import { useState } from 'react';
import { Link, router, usePage } from '@inertiajs/react';
import { House, SignOut } from '@phosphor-icons/react';
import { Sidebar } from '@/Components/Nav/Sidebar';
import { Header } from '@/Components/Nav/Header';
import { ThemeToggle } from '@/Components/Nav/ThemeToggle';
import { Avatar } from '@/Components/Data/Avatar';
import { Dropdown } from '@/Components/Feedback/Dropdown';
import { cn } from '@/Lib/cn';

export function UserLayout({ title, breadcrumb, children }) {
    const { auth } = usePage().props;
    const [open, setOpen] = useState(false);

    const items = [
        {
            title: 'Account',
            items: [{ href: '/dashboard', label: 'Dashboard', icon: House, exact: true }],
        },
    ];

    const brand = (
        <Link href="/dashboard" style={{ color: 'inherit', textDecoration: 'none', display: 'inline-flex', alignItems: 'center', gap: 'var(--space-sm)' }}>
            <span className="ge-sidebar__brand-mark">G</span>
            <span>Gotham</span>
        </Link>
    );

    const footer = (
        <>
            <div className="ge-sidebar__user">
                <Avatar name={auth?.user?.name} size="sm" />
                <div className="ge-sidebar__user-info">
                    <span className="ge-sidebar__user-name">{auth?.user?.name || 'You'}</span>
                    <span className="ge-sidebar__user-role">{auth?.user?.email}</span>
                </div>
            </div>
            <ThemeToggle />
        </>
    );

    return (
        <div className="ge-shell">
            <div className={cn('ge-shell__overlay', open && 'ge-shell__overlay--open')} onClick={() => setOpen(false)} />
            <Sidebar brand={brand} items={items} footer={footer} open={open} onClose={() => setOpen(false)} />
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
                                    <span>{auth?.user?.name || 'Account'}</span>
                                </button>
                            )}
                        >
                            {({ close }) => (
                                <>
                                    <Dropdown.Item onClick={close}>Profile</Dropdown.Item>
                                    <Dropdown.Divider />
                                    <Dropdown.Item danger icon={<SignOut weight="bold" size={14} />} onClick={() => router.post('/logout')}>
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

UserLayout.wrap = (page, { title, breadcrumb } = {}) => (
    <UserLayout title={title} breadcrumb={breadcrumb}>{page}</UserLayout>
);
