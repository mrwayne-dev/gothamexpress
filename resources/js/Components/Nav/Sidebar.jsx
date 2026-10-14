import { Link, usePage } from '@inertiajs/react';
import { cn } from '@/Lib/cn';

export function Sidebar({ brand, items = [], footer, inverse = false, open = false, className, onClose }) {
    const { url } = usePage();
    return (
        <aside className={cn('ge-sidebar', inverse && 'ge-sidebar--inverse', open && 'ge-sidebar--open', className)}>
            {brand ? <div className="ge-sidebar__brand">{brand}</div> : null}
            <nav className="ge-sidebar__nav" aria-label="Primary">
                {items.map((group, gi) =>
                    group.title ? (
                        <div key={gi}>
                            <div className="ge-sidebar__section-title">{group.title}</div>
                            {group.items.map((item) => (
                                <SidebarItem
                                    key={item.href}
                                    {...item}
                                    active={isActive(url, item.href, item.exact)}
                                    onClick={onClose}
                                />
                            ))}
                        </div>
                    ) : (
                        <SidebarItem
                            key={group.href}
                            {...group}
                            active={isActive(url, group.href, group.exact)}
                            onClick={onClose}
                        />
                    ),
                )}
            </nav>
            {footer ? <div className="ge-sidebar__footer">{footer}</div> : null}
        </aside>
    );
}

export function SidebarItem({ href, label, icon, active = false, onClick }) {
    const Icon = icon;
    return (
        <Link
            href={href}
            className={cn('ge-sidebar__item', active && 'ge-sidebar__item--active')}
            onClick={onClick}
        >
            {Icon ? <span className="ge-sidebar__item-icon"><Icon weight="bold" /></span> : null}
            <span>{label}</span>
        </Link>
    );
}

function isActive(currentUrl, href, exact) {
    if (!href) return false;
    if (exact) return currentUrl === href;
    return currentUrl === href || currentUrl.startsWith(`${href}/`);
}
